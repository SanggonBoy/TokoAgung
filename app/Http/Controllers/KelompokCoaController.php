<?php

namespace App\Http\Controllers;

use App\Models\kelompok_coa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class KelompokCoaController extends Controller
{
    public function kelompokCoa()
    {
        $kelompok_coa = kelompok_coa::all();
        return view('kelompok_coa.index', [
            'kelompok_coa' => $kelompok_coa
        ]);
    }

    public function viewCreateKelompokCoa()
    {
        return view('kelompok_coa.create');
    }

    public function storeKelompokCoa(Request $request)
    {
        $request->validate([
            'nama_kelompok_akun' => 'required|unique:kelompok_coa,nama_kelompok_akun|max:255',
            'header_akun' => 'required|unique:kelompok_coa,header_akun|max:255',
        ]);

        kelompok_coa::create([
            'nama_kelompok_akun' => $request->nama_kelompok_akun,
            'header_akun' => $request->header_akun,
        ]);

        return redirect('/kelompokCoa')->with('success', 'Kelompok COA berhasil ditambahkan!');
    }

    public function getKelompokCoa($id)
    {
        $decryptedId = Crypt::decrypt($id);

        $kelompok_coa = kelompok_coa::findOrFail($decryptedId);

        return response()->json([
            'nama_kelompok_akun' => $kelompok_coa->nama_kelompok_akun,
            'header_akun' => $kelompok_coa->header_akun,
        ], 200);
    }

    public function updateKelompokCoa(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
            $decryptedIdRequest = Crypt::decrypt($request->id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json([
                'title' => 'Gagal',
                'message' => 'Data tidak valid!',
                'status' => 'error'
            ], 200);
        }

        if(!$request->has('nama_kelompok_akun') || !$request->has('header_akun')) {
            return response()->json([
                'title' => 'Gagal',
                'message' => 'Data tidak lengkap!',
                'status' => 'error'
            ], 200);
        }

        $kelompok_coa = kelompok_coa::findOrFail($decryptedId);

        if ($kelompok_coa->id === $decryptedIdRequest) {
            if (
                kelompok_coa::where('nama_kelompok_akun', $request->nama_kelompok_akun)
                ->where('id', '!=', $kelompok_coa->id)->exists()
                ||
                kelompok_coa::where('header_akun', $request->header_akun)
                ->where('id', '!=', $kelompok_coa->id)->exists()
            ) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Kelompok akun sudah ada!',
                    'status' => 'error'
                ], 200);
            }
        }

        $kelompok_coa->update([
            'nama_kelompok_akun' => $request->nama_kelompok_akun,
            'header_akun' => $request->header_akun,
        ]);

        return response()->json([
            'title' => 'Berhasil',
            'message' => 'Kelompok akun berhasil diperbarui!',
            'status' => 'success'
        ], 200);
    }
}
