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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembelian');
            $table->unsignedBigInteger('nama_supplier');
            $table->foreign('nama_supplier')->references('id')->on('supplier')->onDelete('cascade');
            $table->string('total_item');
            $table->string('total_harga');
            $table->string('diskon')->nullable();
            $table->date('tanggal')->default(now());
            $table->string('status')->default('Belum Bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
