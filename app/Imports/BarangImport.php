<?php

namespace App\Imports;

use App\Models\barang;
use App\Models\kategori;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $categoryName = trim($row['category_name']); // Ensure correct column name and trim value

        // Log the value being processed
        Log::info('Processing category:', ['name' => $categoryName]);

        // Find or create the category
        $category = kategori::firstOrCreate([
            'name' => $categoryName
        ]);
        Log::info('Processing category:', ['name' => $category->id]);
        return new Barang([
            'name'        => $row['name'],
            'quantity' => $row['quantity'],
            'id_category' => $category->id,
        ]);
    }
}
