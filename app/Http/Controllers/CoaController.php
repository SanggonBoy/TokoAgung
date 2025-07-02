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

    public function viewCreateCoa()
    {
        $kelompokCoa = kelompok_coa::all();
        return view('coa.create', [
            'kelompokCoa' => $kelompokCoa
        ]);
    }

    public function storeCoa(Request $request)
    {
        $request->validate([
            'kode_akun' => 'required|unique:coa,kode_akun|max:255',
            'nama_akun' => 'required|unique:coa,nama_akun|max:255',
            'kelompok_akun' => 'required',
            'posisi_d_c' => 'required|in:Debit,Kredit',
        ]);
        try {
            $decryptedKelompokAkun = Crypt::decrypt($request->kelompok_akun);
        } catch (DecryptException $e) {
            return redirect()->back()->withErrors(['kelompok_akun' => 'Kelompok Akun tidak valid']);
        }
        $kelompokAkun = kelompok_coa::find($decryptedKelompokAkun);
        if (!$kelompokAkun) {
            return redirect()->back()->withErrors(['kelompok_akun' => 'Kelompok Akun tidak ditemukan']);
        }
        coa::create([
            'kode_akun' => $request->kode_akun,
            'nama_akun' => $request->nama_akun,
            'kelompok_akun' => $decryptedKelompokAkun,
            'posisi_d_c' => $request->posisi_d_c,
        ]);
        return redirect('/coa')->with('success', 'Data COA Berhasil Ditambahkan');
    }

    public function getCoa($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->withErrors(['error' => 'Data Tidak Valid']);
        }
        $coa = coa::findOrFail($decryptedId);

        $kelompokCoa = kelompok_coa::all()->map(function ($item) use ($coa) {
            return [
                'id' => Crypt::encrypt($item->id),
                'nama_kelompok_akun' => $item->nama_kelompok_akun,
                'is_selected' => $item->id == $coa->kelompok_akun
            ];
        });

        return response()->json([
            'kode_akun' => $coa->kode_akun,
            'nama_akun' => $coa->nama_akun,
            'kelompok_akun' => $kelompokCoa,
            'selected_posisi_d_c' => $coa->posisi_d_c,
        ], 200);
    }

    public function updateCoa(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
            $decryptedKelompokAkun = $request->kelompok_akun ? Crypt::decrypt($request->kelompok_akun) : null;
        } catch (DecryptException $e) {
            return back()->withErrors(['error' => 'Data Tidak Valid']);
        }
        $coa = coa::findOrFail($decryptedId);

        $kelompokAkun = kelompok_coa::find($decryptedKelompokAkun);

        if (!$kelompokAkun) {
            return redirect()->back()->withErrors(['kelompok_akun' => 'Kelompok Akun tidak ditemukan']);
        }

        if ($coa->id === $decryptedId) {
            if (coa::where('kode_akun', request('kode_akun'))->where('id', '!=', $coa->id)->exists()) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Kode Akun sudah ada!',
                    'status' => 'error'
                ], 200);
            }
            if (coa::where('nama_akun', request('nama_akun'))->where('id', '!=', $coa->id)->exists()) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Nama Akun sudah ada!',
                    'status' => 'error'
                ], 200);
            }
        }

        $coa->update([
            'kode_akun' => request('kode_akun'),
            'nama_akun' => request('nama_akun'),
            'kelompok_akun' => Crypt::decrypt(request('kelompok_akun')),
            'posisi_d_c' => request('posisi_d_c'),
        ]);

        return response()->json([
            'title' => 'Berhasil',
            'message' => 'COA Berhasil Diperbarui!',
            'status' => 'success'
        ], 200);
    }
}
