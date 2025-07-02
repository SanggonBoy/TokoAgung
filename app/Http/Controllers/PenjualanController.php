<?php

namespace App\Http\Controllers;

use App\Models\pelanggan;
use App\Models\penjualan;
use App\Models\penjualan_detail;
use App\Models\produk;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PenjualanController extends Controller
{
    public function penjualan()
    {
        $penjualan = penjualan::with('pelanggan')->get();
        return view('penjualan.index', [
            'penjualan' => $penjualan,
        ]);
    }

    public function viewCreatePenjualan()
    {
        $pelanggan = pelanggan::all();
        $produk = produk::all();
        return view('penjualan.create', [
            'pelanggan' => $pelanggan,
            'produk' => $produk
        ]);
    }

    public function storePenjualan(Request $request)
    {
        try {
            $decryptedIdPelanggan = Crypt::decrypt($request->nama_pelanggan);
            $decryptedIdProduk = Crypt::decrypt($request->nama_produk);
        } catch (DecryptException $e) {
            return back()->with('error', 'Data Tidak Valid');
        }

        $produk = produk::find($decryptedIdProduk);
        $pelanggan = pelanggan::find($decryptedIdPelanggan);

        if (!$pelanggan) {
            return back()->withErrors(['nama_pelanggan' => 'Pelanggan tidak ditemukan']);
        }

        if (!$produk) {
            return back()->withErrors(['nama_pelanggan' => 'Produk tidak ditemukan']);
        }

        $request->validate($this->validationRules());

        if (!$this->isStokValid($request->jumlah)) {
            return back()->withErrors(['jumlah' => 'Jumlah harus lebih dari 0']);
        }

        if (!$this->isStokCukup($produk, $request->jumlah)) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi']);
        }

        if ($this->isDiskonInvalid($request->diskon)) {
            return back()->withErrors(['diskon' => 'Diskon tidak valid']);
        }

        $kode_penjualan = $this->generateKodePenjualan();

        $total_harga = $this->calculateTotalHarga($produk, $request->jumlah, $request->diskon);
        $this->updateStokProduk($produk, $request->jumlah);

        $penjualanStore = penjualan::create([
            'kode_penjualan' => $kode_penjualan,
            'nama_pelanggan' => $pelanggan->id,
            'total_item' => $request->jumlah,
            'diskon' => $request->diskon ?? 0,
            'total_harga' => $total_harga,
        ]);

        penjualan_detail::create([
            'kode_penjualan' => $penjualanStore->id,
            'kode_produk' => $produk->id,
            'jumlah' => $request->jumlah,
            'harga_satuan' => $produk->harga_jual,
        ]);

        return redirect('/penjualan')->with('success', 'Penjualan berhasil ditambahkan');
    }

    private function validationRules()
    {
        return [
            'nama_pelanggan' => 'required',
            'nama_produk' => 'required',
            'jumlah' => 'required|integer',
            'diskon' => 'nullable|numeric',
        ];
    }

    private function isStokCukup($produk, $jumlah)
    {
        return $produk->stok >= $jumlah;
    }

    private function isStokValid($jumlah)
    {
        return $jumlah > 0;
    }

    private function isDiskonInvalid($diskon)
    {
        return $diskon < 0 || $diskon > 100;
    }

    private function generateKodePenjualan()
    {
        do {
            $kode_penjualan = 'PJ-' . rand();
        } while (penjualan::where('kode_penjualan', $kode_penjualan)->exists());

        return $kode_penjualan;
    }

    private function calculateTotalHarga($produk, $jumlah, $diskon)
    {
        $total_harga = $produk->harga_jual * $jumlah;
        if ($diskon) {
            $total_harga -= ($total_harga * ($diskon / 100));
        }
        return $total_harga;
    }

    private function updateStokProduk($produk, $jumlah)
    {
        $produk->stok -= $jumlah;
        $produk->save();
    }


    public function getProduk($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['error' => 'Invalid product ID'], 400);
        }

        $produk = produk::where('id', $decryptedId)->whereHas('pembelianDetail', function ($query) {
            $query->whereHas('pembelian', function ($query) {
                $query->where('status', 'Dibayar');
            });
        })->first();

        if (!$produk) {
            return response()->json([
            'harga_jual' => 0,
            'stok' => 0,
        ]);
        }

        return response()->json([
            'harga_jual' => $produk->harga_jual,
            'stok' => $produk->stok,
        ]);
    }

    public function detailPenjualan($id)
    {
        try {
            $decrytedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('error', 'Data Tidak Valid');
        }

        $penjualan = penjualan::find($decrytedId);
        if (!$penjualan) {
            return back()->with('error', 'Penjualan tidak ditemukan');
        }

        $penjualanDetail = penjualan_detail::where('kode_penjualan', $penjualan->id)->first();
        $produk = produk::find($penjualanDetail->kode_produk);

        if ($produk) {
            return response()->json([
                'nama_pelanggan' => $penjualan->pelanggan->nama_pelanggan,
                'nama_produk' => $produk->nama_produk,
                'jumlah' => $penjualanDetail->jumlah,
                'diskon' => $penjualan->diskon,
                'total_harga' => number_format($penjualan->total_harga, 0, ',', '.'),
                'status' => $penjualan->status,
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

        $penjualan = penjualan::find($decryptedId);
        if (!$penjualan) {
            return back()->with('error', 'Penjualan tidak ditemukan');
        }

        $penjualan->status = 'Dibayar';
        $penjualan->save();

        return redirect('/penjualan')->with('success', 'Status penjualan berhasil dibayarkan.');
    }

    public function dibatalkan($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('error', 'Data Tidak Valid');
        }

        $penjualan = Penjualan::find($decryptedId);
        if (!$penjualan) {
            return back()->with('error', 'Penjualan tidak ditemukan');
        }

        if ($penjualan->status === 'Dibatalkan' || $penjualan->status === 'Direturkan') {
            return back()->with('error', 'Penjualan sudah dibatalkan/diretur sebelumnya');
        }

        $penjualanDetail = Penjualan_detail::where('kode_penjualan', $penjualan->id)->first();
        $produk = Produk::find($penjualanDetail->kode_produk);

        if ($penjualan->status === 'Dibayar') {
            $penjualan->status = 'Direturkan';
            $message = 'Penjualan berhasil diretur, stok telah dikembalikan ke produk.';
        } else {
            $penjualan->status = 'Dibatalkan';
            $message = 'Penjualan berhasil dibatalkan, stok telah dikembalikan ke produk.';
        }

        if ($penjualan->isDirty('status')) {
            $produk->stok += $penjualanDetail->jumlah;
            $produk->save();
        }

        $penjualan->save();

        return redirect('/penjualan')->with('success', $message);
    }
}
