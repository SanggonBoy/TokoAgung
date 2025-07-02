<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class KategoriController extends Controller
{
    public function kategori()
    {
        $kategori = kategori::all();
        return view('kategori.index', [
            'kategori' => $kategori
        ]);
    }

    public function viewCreateKategori()
    {
        return view('kategori.create');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori|max:255',
        ]);

        if ($request->ajax) {
            if (kategori::where('nama_kategori', $request->nama_kategori)->exists()) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Nama Kategori sudah digunakan',
                    'status' => 'error'
                ], 200);
            }
        }

        kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        if($request->ajax()) {
            return response()->json([
                'title' => 'Berhasil',
                'message' => 'Kategori berhasil ditambahkan',
                'status' => 'success'
            ], 200);
        }

        return redirect('/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function getKategori($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->withErrors(['error' => 'Data Tidak Valid']);
        }
        $kategori = kategori::findOrFail($decryptedId);
        return response()->json([
            'nama_kategori' => $kategori->nama_kategori
        ], 200);
    }

    public function updateKategori(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
            $decryptedIdRequest = Crypt::decrypt($request->id);
        } catch (DecryptException $e) {
            return back()->withErrors(['error' => 'Data Tidak Valid']);
        }
        $kategori = kategori::findOrFail($decryptedId);

        if ($kategori->id === $decryptedIdRequest) {
            if (kategori::where('nama_kategori', $request->nama_kategori)->where('id', '!=', $kategori->id)->exists()) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Nama kategori sudah ada!',
                    'status' => 'error'
                ], 200);
            }
        }

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return response()->json([
            'title' => 'Berhasil',
            'message' => 'Nama kategori berhasil diperbarui!',
            'status' => 'success'
        ], 200);
    }
}
