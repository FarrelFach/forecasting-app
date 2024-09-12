<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prediksi extends Model
{
    use HasFactory;
    protected $table = "prediksis";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_barang',
        'quantity',
        'created_at',
        'updated_at'
    ];
    
    public function barang()
    {
        return $this->belongsTo(barang::class, 'id_barang'); // Ensure the foreign key column 'id_barang' exists in `prediksi`
    }
}
