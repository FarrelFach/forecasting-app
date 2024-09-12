<?php

namespace App\Http\Controllers;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\penjualan;
use App\Models\barang;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PenjualanImport;


class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualan = penjualan::with(['barang'])->get();
        return view('penjualan.penjualan', compact('penjualan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penjualan = penjualan::all();
        return view('penjualan.input', compact('penjualan'));
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
        // Find the record by its ID
        $penjualan = penjualan::findOrFail($id);
        $barang = barang::all();

        // Return view for edit (or partial view)
        return view('penjualan.edit', compact('barang', 'penjualan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'wo' => 'required|max:255',
            'invoice' => 'required|max:255',
            'description' => 'required|max:255',
            'client' => 'required|max:255',
            'barang'  => 'required|exists:barangs,id',
            'quantity' => 'required|integer'
        ]);

        // Find the record
        $penjualan = penjualan::findOrFail($id);
        $penjualan->wo = $request->input('wo');
        $penjualan->invoice = $request->input('invoice');
        $penjualan->description = $request->input('description');
        $penjualan->quantity = $request->input('quantity');
        $penjualan->id_barang = $request->input('barang');
        $penjualan->client = $request->input('client');

        // Save the changes
        $penjualan->save();

        // Redirect or return a response
        return redirect()->route('penjualan.index')
                        ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Fetch the model by ID
        $item = barang::findOrFail($id);

        // Delete the item
        $item->delete();

        // Redirect back with a success message
        return redirect()->route('barang.index')->with('success', 'Item deleted successfully!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new PenjualanImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully.');
    }
}
