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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nama_kategori');
            $table->foreign('nama_kategori')->references('id')->on('kategori')->onDelete('cascade'); 
            $table->string('kode_produk');
            $table->string('nama_produk');
            $table->unsignedBigInteger('nama_supplier');
            $table->foreign('nama_supplier')->references('id')->on('supplier')->onDelete('cascade');
            $table->string('merk')->nullable();
            $table->string('harga_beli');
            $table->string('harga_jual');
            $table->string('stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
