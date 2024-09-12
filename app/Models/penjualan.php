<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    use HasFactory;
    protected $table = "penjualans";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'wo',
        'invoice',
        'client',
        'description',
        'quantity',
        'order_date',
        'created_at',
        'updated_at',
        'id_barang',  // Add category_id here
    ];

    public function barang()
    {
        return $this->hasMany(barang::class, 'id', 'id_barang');
    }
}
