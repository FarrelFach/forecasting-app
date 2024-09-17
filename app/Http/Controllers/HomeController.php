<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\barang;
use App\Models\kategori;
use App\Models\penjualan;
use App\Models\prediksi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch total stock quantity, ensure $totalStock is set even if the table is empty
        $totalStock = barang::sum('quantity') ?: 0;

        // Get sales data grouped by month, with default values if empty
        $salesData = penjualan::selectRaw('MONTH(order_date) as month, SUM(quantity) as actual_sales')
            ->groupBy('month')
            ->get();

        // Initialize arrays to handle cases where no sales data is available
        $months = [];
        $actualSales = [];

        if ($salesData->isNotEmpty()) {
            foreach ($salesData as $data) {
                $months[] = date('F', mktime(0, 0, 0, $data->month, 10)); // Convert month number to month name
                $actualSales[] = $data->actual_sales;
            }
        } else {
            // Provide default values if no sales data is available
            $months[] = 'No Data';
            $actualSales[] = 0;
        }

        // Initialize forecasted sales data array
        $forecastedSalesData = [];
        
        $forecastedSales = prediksi::selectRaw('MONTH(created_at) as month, SUM(quantity) as forecasted_sales')
            ->groupBy('month')
            ->get();

        if ($forecastedSales->isNotEmpty()) {
            foreach ($forecastedSales as $data) {
                $forecastedSalesData[] = $data->forecasted_sales;
            }
        } else {
            // Provide default values if no forecasted sales data is available
            $forecastedSalesData[] = 0;
        }

        // Fetch forecasted data with eager loading
        $forecastData = prediksi::selectRaw('prediksis.id_barang, SUM(prediksis.quantity) as forecast_value')
            ->join('barangs', 'prediksis.id_barang', '=', 'barangs.id')
            ->join('kategoris', 'barangs.id_category', '=', 'kategoris.id')
            ->groupBy('prediksis.id_barang')
            ->get();
        
        // Handle empty forecast data
        if ($forecastData->isEmpty()) {
            $forecastData = collect(); // Use an empty collection if no forecast data is available
        }

        // Fetch categories and products with defaults
        $categories = kategori::all();
        if ($categories->isEmpty()) {
            $categories = collect(); // Use an empty collection if no categories are available
        }

        $products = barang::all();
        if ($products->isEmpty()) {
            $products = collect(); // Use an empty collection if no products are available
        }

        // Pass data to the view
        return view('home', compact('months', 'actualSales', 'forecastedSalesData', 'forecastData', 'categories', 'products', 'totalStock'));
    }


    private function getMonthName($monthNumber)
{
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];

    return $months[$monthNumber] ?? 'Unknown';
}
}
