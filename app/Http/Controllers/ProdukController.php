<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\produk;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProdukController extends Controller
{
    public function produk()
    {
        $produk = produk::whereHas('pembelianDetail', function ($query) {
            $query->whereHas('pembelian', function ($query) {
                $query->where('status', 'Dibayar');
            });
        })->get();

        return view('produk.index', [
            'produk' => $produk
        ]);
    }

    public function viewCreateProduk()
    {
        $kategori = kategori::all();
        return view('produk.create', [
            'kategori' => $kategori
        ]);
    }

    public function storeProduk(Request $request)
    {
        try {
            $decryptedIdKategori = Crypt::decrypt($request->input('nama_kategori'));
        } catch (DecryptException $e) {
            return back()->withErrors(['error' => 'Data Tidak Valid']);
        }

        $request->validate([
            'nama_produk' => 'required|unique:produk,nama_produk|max:255',
            'merk' => 'required|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'nama_kategori' => 'required',
        ]);

        $kodeProduk = 'PRD-' . rand();

        while (produk::where('kode_produk', $kodeProduk)->exists()) {
            $kodeProduk = 'PRD-' . rand();
        }

        produk::create([
            'kode_produk' => $kodeProduk,
            'nama_produk' => $request->input('nama_produk'),
            'merk' => $request->input('merk'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),
            'stok' => $request->input('stok'),
            'nama_kategori' => $decryptedIdKategori,
        ]);

        return redirect('/produk')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function getProduk($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->withErrors(['error' => 'Data Tidak Valid']);
        }

        $produk = produk::find($decryptedId);

        if (!$produk) {
            return back()->withErrors(['error' => 'Produk Tidak Ditemukan']);
        }

        $kategori = kategori::all()->map(function ($item) use ($produk) {
            return [
                'id' => Crypt::encrypt($item->id),
                'nama_kategori' => $item->nama_kategori,
                'is_selected' => $item->id == $produk->nama_kategori
            ];
        });

        return response()->json([
            'nama_produk' => $produk->nama_produk,
            'merk' => $produk->merk,
            'harga_beli' => $produk->harga_beli,
            'harga_jual' => $produk->harga_jual,
            'stok' => $produk->stok,
            'kategori' => $kategori,
        ]);
    }

    public function updateProduk(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
            $decryptedIdKategori = Crypt::decrypt($request->input('nama_kategori'));
        } catch (DecryptException $e) {
            return back()->withErrors(['error' => 'Data Tidak Valid']);
        }

        $produk = produk::findOrFail($decryptedId);

        if (!$produk) {
            return back()->withErrors(['error' => 'Produk Tidak Ditemukan']);
        }

        if ($produk->id === $decryptedId) {
            if (produk::where('nama_produk', $request->input('nama_produk'))
                ->where('id', '!=', $produk->id)
                ->exists()
            ) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Nama produk sudah ada!',
                    'status' => 'error'
                ], 200);
            }
        }

        $produk->update([
            'nama_produk' => $request->input('nama_produk'),
            'merk' => $request->input('merk'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),
            'stok' => $request->input('stok'),
            'nama_kategori' => $decryptedIdKategori,
        ]);

        return response()->json([
            'title' => 'Berhasil',
            'message' => 'Data berhasil diperbarui!',
            'status' => 'success'
        ], 200);
    }
}
