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
        Schema::create('pembelian_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kode_pembelian');
            $table->foreign('kode_pembelian')->references('id')->on('pembelian')->onDelete('cascade');
            $table->unsignedBigInteger('nama_produk');
            $table->foreign('nama_produk')->references('id')->on('produk')->onDelete('cascade');
            $table->string('harga_beli');
            $table->string('jumlah');
            $table->string('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_detail');
    }
};
