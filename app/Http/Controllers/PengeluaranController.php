<?php

namespace App\Http\Controllers;

use App\Models\pengeluaran;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PengeluaranController extends Controller
{
    public function pengeluaran()
    {
        $pengeluaran = pengeluaran::all();
        return view('pengeluaran.index', [
            'pengeluaran' => $pengeluaran
        ]);
    }

    public function viewCreatePengeluaran()
    {
        return view('pengeluaran.create');
    }

    public function storePengeluaran(Request $request)
    {
        $request->validate([
            'nama_pengeluaran' => 'required|max:255',
            'nominal' => 'required|numeric',
        ]);

        $kodePengeluaran = 'PENG-' . rand();
        while (pengeluaran::where('kode_pengeluaran', $kodePengeluaran)->exists()) {
            $kodePengeluaran = 'PENG-' . rand();
        }

        pengeluaran::create([
            'kode_pengeluaran' => $kodePengeluaran,
            'nama_pengeluaran' => $request->nama_pengeluaran,
            'nominal' => $request->nominal
        ]);

        return redirect('/pengeluaran')->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function getPengeluaran($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('error', 'Data Tidak Valid');
        }

        $pengeluaran = pengeluaran::find($decryptedId);
        return response()->json([
            'kode_pengeluaran' => $pengeluaran->kode_pengeluaran,
            'nama_pengeluaran' => $pengeluaran->nama_pengeluaran,
            'nominal' => "Rp. " . number_format($pengeluaran->nominal, 2, ',', '.'),
            'status' => $pengeluaran->status
        ]);
    }

    public function selesai($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('error', 'Data Tidak Valid');
        }

        pengeluaran::where('id', $decryptedId)->update([
            'status' => 'Selesai'
        ]);

        return redirect('/pengeluaran')->with('success', 'Pengeluaran berhasil selesai!');
    }

    public function hapus($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('error', 'Data Tidak Valid');
        }

        pengeluaran::where('id', $decryptedId)->delete();

        return redirect('/pengeluaran')->with('success', 'Pengeluaran berhasil dihapus!');
    }

    public function viewEditPengeluaran($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('error', 'Data Tidak Valid');
        }

        $pengeluaran = pengeluaran::find($decryptedId);

        return view('pengeluaran.edit', [
            'pengeluaran' => $pengeluaran
        ]);
    }
}
