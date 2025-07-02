<?php

namespace App\Http\Controllers;

use App\Models\pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PelangganController extends Controller
{
    public function pelanggan()
    {
        $pelanggan = pelanggan::all();
        return view('pelanggan.index', [
            'pelanggan' => $pelanggan
        ]);
    }

    public function viewCreatePelanggan()
    {
        return view('pelanggan.create');
    }

    public function storePelanggan(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|unique:pelanggan,nama_pelanggan|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_telp' => 'nullable|unique:pelanggan,no_telp|string|max:15',
        ]);

        $kode_pelanggan = 'PLG-' . rand();

        while(pelanggan::where('kode_pelanggan', $kode_pelanggan)->exists()) {
            $kode_pelanggan = 'PLG-' . rand();
        }

        if ($request->ajax) {
            if (pelanggan::where('nama_pelanggan', $request->nama_pelanggan)->exists()) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Nama pelanggan sudah digunakan',
                    'status' => 'error'
                ], 200);
            }
            if (pelanggan::where('no_telp', $request->no_telp)->exists()) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Nomor telepon sudah digunakan',
                    'status' => 'error'
                ], 200);
            }
        }

        pelanggan::create([
            'kode_pelanggan' => $kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        if($request->ajax()) {
            return response()->json([
                'title' => 'Berhasil',
                'message' => 'Pelanggan berhasil ditambahkan',
                'status' => 'success'
            ], 200);
        }

        return redirect('/pelanggan')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function getPelanggan($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Data Tidak Valid']);
        }

        $pelanggan = pelanggan::find($decryptedId);

        if (!$pelanggan) {
            return back()->withErrors(['error' => 'Pelanggan Tidak Ditemukan']);
        }

        return response()->json([
            'nama_pelanggan' => $pelanggan->nama_pelanggan,
            'alamat' => $pelanggan->alamat,
            'no_telp' => $pelanggan->no_telp,
        ]);
    }

    public function updatePelanggan(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Data Tidak Valid']);
        }

        $pelanggan = pelanggan::find($decryptedId);

        if (!$pelanggan) {
            return back()->withErrors(['error' => 'Pelanggan Tidak Ditemukan']);
        }

        if(pelanggan::where('nama_pelanggan', $request->nama_pelanggan)
            ->where('id', '!=', $decryptedId)->exists()) {
            return response()->json([
                'title' => 'Gagal',
                'message' => 'Nama pelanggan sudah digunakan',
                'status' => 'error'
            ], 200);
        }

        if(pelanggan::where('no_telp', $request->no_telp)
            ->where('id', '!=', $decryptedId)->exists()) {
            return response()->json([
                'title' => 'Gagal',
                'message' => 'Nomor telepon sudah digunakan',
                'status' => 'error'
            ], 200);
        }

        $pelanggan->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        return response()->json([
            'title' => 'Berhasil',
            'message' => 'Pelanggan berhasil diperbarui',
            'status' => 'success'
        ], 200);
    }
}
