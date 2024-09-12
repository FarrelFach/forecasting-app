<?php

namespace App\Http\Controllers;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\penjualan;
use App\Models\prediksi;
use App\Models\barang;
use App\Models\kategori;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PenjualanImport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PrediksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = barang::all();
        return view('prediksi.prediksi', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function forecast(Request $request)
    {
        Log::info('request form:', [
            'weights' => $request->input('weights'),
            'itemid' => $request->input('itemid'),
        ]);

        // Step 2: Retrieve the input from the form
        $weights = $request->input('weights');
        $weightsArray = explode(',', $weights);
        $weightsArray = array_map('trim', $weightsArray);
        $weightsArray = array_map('floatval', $weightsArray);

        // Retrieve the inventory item
        $item = penjualan::findOrFail($request->input('itemid'));

        // Number of periods we want to backtest (let's say 3 backtest periods)
        $numBacktestPeriods = 3;  // Adjust this if needed
        $numWeights = count($weightsArray);

        // Fetch historical data (need n + k periods)
        $historicalData = $item->latest()->take($numWeights + $numBacktestPeriods)->get();

        Log::info('Historical data retrieved:', ['data' => $historicalData]);

        // Ensure there's enough historical data
        if ($historicalData->count() < ($numWeights + $numBacktestPeriods)) {
            return response()->json([
                'error' => 'Not enough data for forecasting and back-testing'
            ], 400);
        }

        // Calculate Weighted Moving Average for the future forecast (Month 10)
        $weightedSum = 0;
        $weightTotal = array_sum($weightsArray);

        foreach ($historicalData->take($numWeights) as $key => $data) {
            $weightedSum += $data->quantity * $weightsArray[$key];
        }

        $forecast = $weightedSum / $weightTotal;
        Log::info('Forecast calculated:', ['forecast' => $forecast]);

        // Optionally, save the forecasted data for future period
        $prediksi = new prediksi;
        $prediksi->create([
            'created_at' => Carbon::tomorrow(),
            'quantity' => $forecast,
            'id_barang' => $request->input('itemid'),
        ]);
        $historicalPrediksi = prediksi::with(['barang'])
                            ->where('id_barang', $request->input('itemid'))
                            ->get();
        // Calculate error metrics for back-testing
        $totalAbsoluteError = 0;
        $totalSquaredError = 0;
        $forecastedValues = [];
        $actualValues = [];

        // Loop through each backtest period
        for ($i = 0; $i < $numBacktestPeriods; $i++) {
            $pastWeightedSum = 0;

            // Forecast for each historical period using the same weights
            foreach (range(0, $numWeights - 1) as $weightIndex) {
                $pastWeightedSum += $historicalData[$i + 1 + $weightIndex]->quantity * $weightsArray[$weightIndex];
            }

            $backtestForecast = $pastWeightedSum / $weightTotal;
            $forecastedValues[] = $backtestForecast;
            $actualValues[] = $historicalData[$i]->quantity;

            // Calculate errors
            $actualValue = $historicalData[$i]->quantity;
            $absoluteError = abs($backtestForecast - $actualValue);
            $squaredError = pow($backtestForecast - $actualValue, 2);

            $totalAbsoluteError += $absoluteError;
            $totalSquaredError += $squaredError;
        }

        // Calculate Mean Absolute Error (MAE) and Mean Squared Error (MSE)
        $mae = $totalAbsoluteError / $numBacktestPeriods;
        $mse = $totalSquaredError / $numBacktestPeriods;
        $kategori = kategori::all();
        Log::info('Error metrics calculated:', ['MAE' => $mae, 'MSE' => $mse]);
        Log::info('Error metrics calculated:', ['had' => $actualValues, 'hfd' => $forecastedValues]);

        // Return the forecast and error metrics
        return view('prediksi.result', [
            'historiprediksi' => $historicalPrediksi,
            'item' => $item,
            'weight' => $weights,
            'period' => $numWeights,
            'prediksi' => $forecast,
            'actualValues' => $actualValues,
            'forecastedValues' => $forecastedValues,
            'mae' => $mae,
            'kategori' => $kategori,
            'mse' => $mse
        ]);
    }
}
