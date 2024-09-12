<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasFactory;
    protected $table = "barangs";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'quantity',
        'id_category',
    ];

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'id_category');
    }

    public function sales() {
        return $this->hasMany(penjualan::class);
    }
}
