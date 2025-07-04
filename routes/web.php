<?php

use App\Http\Controllers\CoaController;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\JurnalUmumController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

// REDIRECTING
Route::get('/', function () {
    return redirect('/dashboard');
});

// DASHBOARD
Route::get('/dashboard', [dashboard::class, 'dashboard']);

// COA
// Route::prefix('/coa')->group(function () {
//     Route::get('/', [CoaController::class, 'coa']);
//     Route::get('/createCoa', [CoaController::class, 'viewCreateCoa']);
//     Route::post('/storeCoa', [CoaController::class, 'storeCoa']);
//     Route::get('/getCoa/{id}', [CoaController::class, 'getCoa']);
//     Route::post('/updateCoa/{id}', [CoaController::class, 'updateCoa']);
// });
Route::get('/coa', [CoaController::class, 'coa']);

// KELOMPOK COA
// Route::prefix('/kelompokCoa')->group(function () {
//     Route::get('/', [KelompokCoaController::class, 'kelompokCoa']);
//     Route::get('/createKelompokCoa', [KelompokCoaController::class, 'viewCreateKelompokCoa']);
//     Route::post('/storeKelompokCoa', [KelompokCoaController::class, 'storeKelompokCoa']);
//     Route::get('/getKelompokCoa/{id}', [KelompokCoaController::class, 'getKelompokCoa']);
//     Route::post('/updateKelompokCoa/{id}', [KelompokCoaController::class, 'updateKelompokCoa']);
// });

// KATEGORI
Route::prefix('/kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'kategori']);
    Route::get('/createKategori', [KategoriController::class, 'viewCreateKategori']);
    Route::post('/storeKategori', [KategoriController::class, 'storeKategori']);
    Route::get('/getKategori/{id}', [KategoriController::class, 'getKategori']);
    Route::post('/updateKategori/{id}', [KategoriController::class, 'updateKategori']);
});

// PRODUK
Route::prefix('/produk')->group(function () {
    Route::get('/', [ProdukController::class, 'produk']);
    Route::get('/createProduk', [ProdukController::class, 'viewCreateProduk']);
    Route::post('/storeProduk', [ProdukController::class, 'storeProduk']);
    Route::get('/getProduk/{id}', [ProdukController::class, 'getProduk']);
    Route::post('/updateProduk/{id}', [ProdukController::class, 'updateProduk']);
});

// PELANGGAN
Route::prefix('/pelanggan')->group(function () {
    Route::get('/', [PelangganController::class, 'pelanggan']);
    Route::get('/createPelanggan', [PelangganController::class, 'viewCreatePelanggan']);
    Route::post('/storePelanggan', [PelangganController::class, 'storePelanggan']);
    Route::get('/getPelanggan/{id}', [PelangganController::class, 'getPelanggan']);
    Route::post('/updatePelanggan/{id}', [PelangganController::class, 'updatePelanggan']);
});

// SUPPLIER
Route::prefix('/supplier')->group(function () {
    Route::get('/', [SupplierController::class, 'supplier']);
    Route::get('/createSupplier', [SupplierController::class, 'viewCreateSupplier']);
    Route::post('/storeSupplier', [SupplierController::class, 'storeSupplier']);
    Route::get('/getSupplier/{id}', [SupplierController::class, 'getSupplier']);
    Route::post('/updateSupplier/{id}', [SupplierController::class, 'updateSupplier']);
});

// PENJUALAN
Route::prefix('/penjualan')->group(function () {
    Route::get('/', [PenjualanController::class, 'penjualan']);
    Route::get('/createPenjualan', [PenjualanController::class, 'viewCreatePenjualan']);
    Route::post('/storePenjualan', [PenjualanController::class, 'storePenjualan']);
    Route::get('/getPenjualan/{id}', [PenjualanController::class, 'getPenjualan']);
    Route::get('/getProduk/{id}', [PenjualanController::class, 'getProduk']);
    Route::post('/updatePenjualan/{id}', [PenjualanController::class, 'updatePenjualan']);
    Route::get('/detailPenjualan/{id}', [PenjualanController::class, 'detailPenjualan']);
    Route::get('/dibayarkan/{id}', [PenjualanController::class, 'dibayarkan']);
    Route::get('/dibatalkan/{id}', [PenjualanController::class, 'dibatalkan']);
});

// PEMBELIAN
Route::prefix('/pembelian')->group(function () {
    Route::get('/', [PembelianController::class, 'pembelian']);
    Route::get('/createPembelian', [PembelianController::class, 'viewCreatePembelian']);
    Route::post('/storePembelian', [PembelianController::class, 'storePembelian']);
    Route::post('/stokProduk', [PembelianController::class, 'stokProduk']);
    Route::get('/getPembelian/{id}', [PembelianController::class, 'getPembelian']);
    Route::get('/detailPembelian/{id}', [PembelianController::class, 'detailPembelian']);
    Route::get('/dibayarkan/{id}', [PembelianController::class, 'dibayarkan']);
    Route::get('/dibatalkan/{id}', [PembelianController::class, 'dibatalkan']);
});

Route::prefix('/pengeluaran')->group(function () {
    Route::get('/', [PengeluaranController::class, 'pengeluaran']);
    Route::get('/createPengeluaran', [PengeluaranController::class, 'viewCreatePengeluaran']);
    Route::post('/storePengeluaran', [PengeluaranController::class, 'storePengeluaran']);
    Route::get('/getPengeluaran/{id}', [PengeluaranController::class, 'getPengeluaran']);
    Route::get('/selesai/{id}', [PengeluaranController::class, 'selesai']);
    Route::get('/hapus/{id}', [PengeluaranController::class, 'hapus']);
    Route::get('/editPengeluaran/{id}', [PengeluaranController::class, 'viewEditPengeluaran']);
});

Route::prefix('/jurnalUmum')->group(function() {
    Route::get('/', [JurnalUmumController::class, 'jurnalUmum']);
    Route::get('/periodeJurnalUmum', [JurnalUmumController::class, 'periodeJurnalUmum']);
});
