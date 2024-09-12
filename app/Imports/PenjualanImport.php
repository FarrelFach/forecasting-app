<?php

namespace App\Imports;

use App\Models\penjualan;
use App\Models\barang;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class PenjualanImport implements ToModel, WithHeadingRow 
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
        public function model(array $row)
        {
            Log::info('Processed values:', ['ordered_date' => $row['ordered_date']]);
            $createdat = Carbon::now()->subDays(2); // 2 days ago
            $updatedat = Carbon::now();

            // Ensure correct column name and trim value
            $barangName = trim($row['description']); // Replace 'description' with the correct key if needed

            // Find or create the barang
            $barang = barang::firstOrCreate(
                ['name' => $barangName],
                [
                    'name' => $barangName,
                    'id_category' => null,
                    'quantity' => null,
                ]
            );

            // Prepare values with fallback defaults
            $client = isset($row['client']) ? trim($row['client']) : 'DefaultClient';
            $description = isset($row['description']) ? trim($row['description']) : '';
            $quantity = isset($row['qty']) ? $row['qty'] : 0;
            $wo = isset($row['wo']) ? $row['wo'] : null;
            $invoice = isset($row['no_invoice']) ? $row['no_invoice'] : null;
            
            // Parse the ordered_at date from the Excel file
            $orderedAtStr = isset($row['ordered_date']) ? trim($row['ordered_date']) : null;

            // Try parsing as Excel serial date
            $orderDate = null;
            if (is_numeric($orderedAtStr)) {
                // Convert Excel serial date to Carbon date
                $excelBaseDate = Carbon::create(1900, 1, 1);
                $orderDate = $excelBaseDate->addDays($orderedAtStr - 2); // Subtract 2 for Excel leap year bug
            } else {
                // Try parsing as formatted date
                try {
                    $orderDate = Carbon::createFromFormat('d-M-y', $orderedAtStr);
                } catch (\Exception $e) {
                    Log::error('Date parsing failed for ordered_at:', ['value' => $orderedAtStr, 'exception' => $e->getMessage()]);
                }
            }

            // Log processed values
            Log::info('Processed values:', [
                'client' => $client,
                'description' => $description,
                'quantity' => $quantity,
                'wo' => $wo,
                'invoice' => $invoice,
                'id_barang' => $barang->id,
                'ordered_at' => $orderDate,
            ]);

            // Return a new penjualan model
            return new penjualan([
                'wo'                => $wo,
                'invoice'           => $invoice,
                'client'            => $client,
                'description'       => $description,
                'quantity'          => $quantity,
                'id_barang'         => $barang->id,
                'created_at'        => $createdat,
                'updated_at'        => $updatedat,
                'order_date'        => $orderDate, // Add the new date column here
            ]);
        }
}
