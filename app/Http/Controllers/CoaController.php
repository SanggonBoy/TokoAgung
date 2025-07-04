<?php

namespace App\Http\Controllers;

use App\Models\coa;
use App\Models\kelompok_coa;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CoaController extends Controller
{
    public function coa()
    {
        $coa = coa::all();
        return view('coa.index', [
            'coa' => $coa
        ]);
    }

    // public function viewCreateCoa()
    // {
    //     return view('coa.create');
    // }

    // public function storeCoa(Request $request)
    // {
    //     $request->validate([
    //         'kode_akun' => 'required|unique:coa,kode_akun|max:255',
    //         'nama_akun' => 'required|unique:coa,nama_akun|max:255',
    //     ]);
    //     coa::create([
    //         'kode_akun' => $request->kode_akun,
    //         'nama_akun' => $request->nama_akun,
    //     ]);
    //     return redirect('/coa')->with('success', 'Data COA Berhasil Ditambahkan');
    // }

    // public function getCoa($id)
    // {
    //     try {
    //         $decryptedId = Crypt::decrypt($id);
    //     } catch (DecryptException $e) {
    //         return back()->withErrors(['error' => 'Data Tidak Valid']);
    //     }
    //     $coa = coa::findOrFail($decryptedId);

    //     return response()->json([
    //         'kode_akun' => $coa->kode_akun,
    //         'nama_akun' => $coa->nama_akun,
    //     ], 200);
    // }

    // public function updateCoa(Request $request, $id)
    // {
    //     try {
    //         $decryptedId = Crypt::decrypt($id);
    //     } catch (DecryptException $e) {
    //         return back()->withErrors(['error' => 'Data Tidak Valid']);
    //     }
    //     $coa = coa::findOrFail($decryptedId);

    //     if ($coa->id === $decryptedId) {
    //         if (coa::where('kode_akun', request('kode_akun'))->where('id', '!=', $coa->id)->exists()) {
    //             return response()->json([
    //                 'title' => 'Gagal',
    //                 'message' => 'Kode Akun sudah ada!',
    //                 'status' => 'error'
    //             ], 200);
    //         }
    //         if (coa::where('nama_akun', request('nama_akun'))->where('id', '!=', $coa->id)->exists()) {
    //             return response()->json([
    //                 'title' => 'Gagal',
    //                 'message' => 'Nama Akun sudah ada!',
    //                 'status' => 'error'
    //             ], 200);
    //         }
    //     }

    //     $coa->update([
    //         'kode_akun' => request('kode_akun'),
    //         'nama_akun' => request('nama_akun'),
    //         'kelompok_akun' => Crypt::decrypt(request('kelompok_akun')),
    //         'posisi_d_c' => request('posisi_d_c'),
    //     ]);

    //     return response()->json([
    //         'title' => 'Berhasil',
    //         'message' => 'COA Berhasil Diperbarui!',
    //         'status' => 'success'
    //     ], 200);
    // }
}
