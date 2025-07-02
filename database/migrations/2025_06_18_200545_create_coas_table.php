<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coa', function (Blueprint $table) {
            $table->id();
            $table->string('kode_akun');
            $table->string('nama_akun');
            $table->unsignedBigInteger('kelompok_akun');
            $table->foreign('kelompok_akun')->references('id')->on('kelompok_coa')->onDelete('cascade');
            $table->string('posisi_d_c');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa');
    }
};
