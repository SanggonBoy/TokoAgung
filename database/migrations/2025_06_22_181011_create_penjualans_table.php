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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penjualan');
            $table->unsignedBigInteger('nama_pelanggan');
            $table->foreign('nama_pelanggan')->references('id')->on('pelanggan')->onDelete('cascade');
            $table->string('diskon')->nullable();
            $table->string('total_harga');
            $table->string('total_item');
            $table->string('status')->default('Belum Bayar'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
