<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    /** @use HasFactory<\Database\Factories\PenjualanFactory> */
    use HasFactory;
    protected $table = 'penjualan';
    protected $guarded = ['id'];

    public function pelanggan()
    {
        return $this->belongsTo(pelanggan::class, 'nama_pelanggan');
    }
    
    public function penjualanDetail()
    {
        return $this->hasMany(penjualan_detail::class, 'kode_penjualan');
    }
}
