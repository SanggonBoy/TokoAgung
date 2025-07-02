<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory;

    protected $table = 'produk';
    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'nama_kategori');
    }

    public function supplier()
    {
        return $this->belongsTo(supplier::class, 'nama_supplier');
    }

    public function pembelianDetail()
    {
        return $this->hasMany(pembelian_detail::class, 'nama_produk');
    }
}
