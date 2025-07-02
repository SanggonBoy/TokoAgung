<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\pembelian;
use App\Models\pembelian_detail;
use App\Models\produk;
use App\Models\supplier;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function pembelian()
    {
        $pembelian = pembelian_detail::with(['pembelian', 'produk'])->get();
        return view('pembelian.index', [
            'pembelian' => $pembelian,
        ]);
    }

    public function viewCreatePembelian()
    {
        $supplier = supplier::all();
        $kategori = kategori::all();
        return view('pembelian.create', [
            'supplier' => $supplier,
            'kategori' => $kategori
        ]);
    }

    public function storePembelian(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'nama_produk' => 'required',
            'nama_kategori' => 'required',
            'merk' => 'required',
            'jumlah' => 'required',
            'harga_beli' => 'required',
            'diskon' => 'nullable',
            'harga_jual' => 'required',
        ]);

        $diskon = $request->input('diskon');
        if ($diskon < 0 || $diskon > 100) {
            return back()->with('error', 'Diskon tidak valid');
        }

        try {
            $decryptedIdKategori = Crypt::decrypt($request->input('nama_kategori'));
            $decryptedIdSupplier = Crypt::decrypt($request->input('nama_supplier'));
        } catch (DecryptException $e) {
            return back()->withErrors(['error' => 'Data Tidak Valid']);
        }

        $namaProduk = strtolower($request->input('nama_produk'));

        $supplier = supplier::find($decryptedIdSupplier);
        $kategori = kategori::find($decryptedIdKategori);

        $produk = produk::where(strtolower('nama_produk'), $namaProduk)
            ->where('nama_supplier', $supplier->id)
            ->where('nama_kategori', $kategori->id)
            ->exists();

        if ($produk) {
            return redirect('/pembelian')->with('error', 'Produk sudah ada');
        }

        $supplierStore = supplier::find($decryptedIdSupplier);
        if (!$supplierStore) {
            $supplierStore = supplier::create([
                'nama_supplier' => $request->input('nama_supplier'),
                'alamat' => $request->input('alamat'),
                'no_telp' => $request->input('no_telp')
            ]);
        }

        $kode_produk = "PR-" . rand();
        while (produk::where('kode_produk', $kode_produk)->exists()) {
            $kode_produk = "PR-" . rand();
        }

        $produkStore = produk::create([
            'kode_produk' => $kode_produk,
            'nama_kategori' => $kategori->id,
            'nama_produk' => $request->input('nama_produk'),
            'nama_supplier' => $supplierStore->id,
            'merk' => $request->input('merk'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),
            'stok' => $request->input('jumlah'),
        ]);

        $kode_pembelian = "PB-" . rand();
        while (pembelian::where('kode_pembelian', $kode_pembelian)->exists()) {
            $kode_pembelian = "PB-" . rand();
        }

        $totalHarga = $request->input('harga_beli') * $request->input('jumlah');
        if ($request->input('diskon') != 0) {
            $totalHarga -= ($totalHarga * $request->input('diskon') / 100);
        }

        $pembelianStore = pembelian::create([
            'kode_pembelian' => $kode_pembelian,
            'nama_supplier' => $supplier->id,
            'total_item' => $request->input('jumlah'),
            'diskon' => $request->input('diskon'),
            'total_harga' => $totalHarga,
        ]);

        pembelian_detail::create([
            'kode_pembelian' => $pembelianStore->id,
            'nama_produk' => $produkStore->id,
            'jumlah' => $request->input('jumlah'),
            'harga_beli' => $request->input('harga_beli'),
            'subtotal' => $request->input('harga_beli') * $request->input('jumlah'),
        ]);

        return redirect('/pembelian')->with('success', 'Pembelian Berhasil Ditambahkan.');
    }

    public function stokProduk(Request $request)
    {
        try {
            $decryptedIdPembelianDetail = Crypt::decrypt($request->input('id'));
        } catch (DecryptException $e) {
            return back()->with('error', 'Data Tidak Valid');
        }

        $pembelianDetail = pembelian_detail::find($decryptedIdPembelianDetail);

        if (!$pembelianDetail) {
            return back()->with('error', 'Pembelian tidak ditemukan');
        }

        $kodePembelian = "PB-" . rand();
        while (pembelian::where('kode_pembelian', $kodePembelian)->exists()) {
            $kodePembelian = "PB-" . rand();
        }

        $produk = produk::find($pembelianDetail->nama_produk);
        $pembelian = pembelian::find($pembelianDetail->kode_pembelian);

        $totalHarga = $produk->harga_beli * $request->stok;
        $diskon = $pembelian->diskon ? $totalHarga * $pembelian->diskon / 100 : 0;
        $totalHargaPembelian = ($produk->harga_beli * $request->stok) - $diskon;

        $pembelianStore = pembelian::create([
            'kode_pembelian' => $kodePembelian,
            'nama_supplier' => $pembelianDetail->pembelian->nama_supplier,
            'total_item' => $request->stok,
            'total_harga' => $totalHargaPembelian,
            'diskon' => $pembelian->diskon
        ]);

        pembelian_detail::create([
            'kode_pembelian' => $pembelianStore->id,
            'nama_produk' => $pembelianDetail->nama_produk,
            'harga_beli' => $produk->harga_beli,
            'jumlah' => $request->stok,
            'subtotal' => $totalHarga
        ]);

        return response()->json([
            'title' => 'Berhasil',
            'message' => 'Pembelian Berhasil Ditambahkan.',
            'status' => 'success'
        ]);
    }

    public function detailPembelian($id)
    {
        try {
            $decrytedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('error', 'Data Tidak Valid');
        }

        $pembelian = pembelian::find($decrytedId);
        if (!$pembelian) {
            return back()->with('error', 'Pembelian tidak ditemukan');
        }

        $pembelianDetail = pembelian_detail::where('kode_pembelian', $pembelian->id)->first();
        $produk = produk::find($pembelianDetail->nama_produk);

        if ($produk) {
            return response()->json([
                'nama_supplier' => $pembelian->supplier->nama_supplier,
                'nama_produk' => $produk->nama_produk,
                'jumlah' => $pembelianDetail->jumlah,
                'diskon' => $pembelian->diskon,
                'total_harga' => number_format($pembelian->total_harga, 0, ',', '.'),
                'status' => $pembelian->status,
            ]);
        }

        return back()->with('error', 'Produk tidak ditemukan');
    }

    public function dibayarkan($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('error', 'Data Tidak Valid');
        }

        $pembelian = pembelian::find($decryptedId);
        if (!$pembelian) {
            return back()->with('error', 'Pembelian tidak ditemukan');
        }

        if ($pembelian->status === 'Dibayar') {
            return back()->with('error', 'Pembelian sudah dibayar sebelumnya.');
        }

        DB::beginTransaction();
        try {
            $pembelian->status = 'Dibayar';
            $pembelian->save();

            $pembelianDetail = Pembelian_detail::where('kode_pembelian', $pembelian->id)->first();
            $produk = produk::find($pembelianDetail->nama_produk);

            $produk->update([
                'stok' => $produk->stok + $pembelianDetail->jumlah
            ]);

            DB::commit();

            return redirect('/pembelian')->with('success', 'Status pembelian berhasil dibayarkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }

    public function dibatalkan($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('error', 'Data Tidak Valid');
        }

        $pembelian = pembelian::find($decryptedId);
        if (!$pembelian) {
            return back()->with('error', 'Pembelian tidak ditemukan');
        }

        if ($pembelian->status === 'Dibatalkan' || $pembelian->status === 'Direturkan') {
            return back()->with('error', 'Pembelian sudah dibatalkan/diretur sebelumnya');
        }

        $pembelianDetail = Pembelian_detail::where('kode_pembelian', $pembelian->id)->first();
        $produk = Produk::find($pembelianDetail->nama_produk);

        if ($pembelian->status === 'Dibayar') {
            $pembelian->status = 'Direturkan';
            $message = 'Pembelian berhasil diretur, stok telah dihapus dari produk.';
        } else {
            $pembelian->status = 'Dibatalkan';
            $message = 'Pembelian berhasil dibatalkan, stok telah dihapus dari produk.';
        }

        if ($pembelian->isDirty('status')) {
            $produk->stok += $pembelianDetail->jumlah;
            $produk->save();
        }

        $pembelian->save();

        return redirect('/pembelian')->with('success', $message);
    }
}
