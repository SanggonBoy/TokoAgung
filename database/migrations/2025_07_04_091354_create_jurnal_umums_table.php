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
        Schema::create('jurnal_umum', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coa');
            $table->foreign('coa')->references('id')->on('coa')->onDelete('cascade');
            $table->unsignedBigInteger('transaksi');
            $table->foreign('transaksi')->references('id')->on('transaksi')->onDelete('cascade');
            $table->string('akun');
            $table->string('debet')->nullable();
            $table->string('kredit')->nullable();
            $table->date('tanggal')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_umum');
    }
};
