<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualan_detail extends Model
{
    /** @use HasFactory<\Database\Factories\PenjualanDetailFactory> */
    use HasFactory;

    protected $table = 'penjualan_detail';
    protected $guarded = ['id'];

    public function penjualan()
    {
        return $this->belongsTo(penjualan::class, 'kode_penjualan');
    }

    public function produk()
    {
        return $this->belongsTo(produk::class, 'kode_produk');
    }
}
