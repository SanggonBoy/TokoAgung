<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coa extends Model
{
    /** @use HasFactory<\Database\Factories\CoaFactory> */
    use HasFactory;

    protected $table = 'coa';

    protected $guarded = ['id'];

    public function kelompokAkun()
    {
        return $this->belongsTo(kelompok_coa::class, 'kelompok_akun', 'id');
    }
}
