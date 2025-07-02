<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembelian_detail extends Model
{
    /** @use HasFactory<\Database\Factories\PembelianDetailFactory> */
    use HasFactory;

    protected $table = 'pembelian_detail';
    protected $guarded = ['id'];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'kode_pembelian');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'nama_produk');
    }
}
