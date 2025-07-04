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
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kode_penjualan');
            $table->foreign('kode_penjualan')->references('id')->on('penjualan')->onDelete('cascade');
            $table->unsignedBigInteger('kode_produk');
            $table->foreign('kode_produk')->references('id')->on('produk')->onDelete('cascade');
            $table->string('jumlah');
            $table->string('harga_satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_detail');
    }
};
