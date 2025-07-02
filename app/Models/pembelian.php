<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembelian extends Model
{
    /** @use HasFactory<\Database\Factories\PembelianFactory> */
    use HasFactory;

    protected $table = 'pembelian';
    protected $guarded = ['id'];

    public function pembelianDetail()
    {
        return $this->hasMany(pembelian_detail::class, 'kode_pembelian');
    }

    public function supplier()
    {
        return $this->belongsTo(supplier::class, 'nama_supplier');
    }
}
