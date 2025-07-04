<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jurnal_umum extends Model
{
    /** @use HasFactory<\Database\Factories\JurnalUmumFactory> */
    use HasFactory;

    protected $table = 'jurnal_umum';
    protected $guarded = ['id'];

    public function coa()
    {
        return $this->belongsTo(coa::class, 'coa');
    }

    public function transaksi()
    {
        return $this->belongsTo(transaksi::class, 'transaksi');
    }
}
