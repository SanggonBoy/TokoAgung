<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelompok_coa extends Model
{
    /** @use HasFactory<\Database\Factories\KelompokCoaFactory> */
    use HasFactory;

    protected $table = 'kelompok_coa';

    protected $guarded = ['id'];

    public function coa()
    {
        return $this->hasMany(coa::class, 'kelompok_akun');
    }
}
