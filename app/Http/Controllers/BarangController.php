<?php

namespace App\Http\Controllers;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\barang;
use App\Models\kategori;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BarangImport;
use Carbon\Carbon;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $barang = barang::with(['kategori'])->get();
        return view('barang.barang', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barang = barang::all();
        return view('barang.input', compact('barang'));
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
        $barang = barang::findOrFail($id);
        $kategori = kategori::all();

        // Return view for edit (or partial view)
        return view('barang.edit', compact('barang', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category'  => 'required|exists:kategoris,id',
            'quantity' => 'required|integer'
        ]);

        // Find the record
        $barang = barang::findOrFail($id);

        $barang->name = $request->input('name');
        $barang->id_category = $request->input('category'); // Update the foreign key
        $barang->quantity = $request->input('quantity');
        // Save the changes
        $barang->save();

        // Redirect or return a response
        return redirect()->route('barang.index')
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

        Excel::import(new BarangImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully.');
    }
}
