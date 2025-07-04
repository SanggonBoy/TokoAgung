<?php

namespace App\Http\Controllers;

use App\Models\jurnal_umum;
use Illuminate\Http\Request;

class JurnalUmumController extends Controller
{
    public function jurnalUmum()
    {
        $jurnalUmum = jurnal_umum::with(['transaksi', 'coa'])->get();
        $dataJurnalUmum = $jurnalUmum->toArray();
        $dataJurnalUmum = array_map(function ($jurnalUmum) {
            $jurnalUmum['transaksi'] = $jurnalUmum['transaksi']['nama_transaksi'];
            $jurnalUmum['coa'] = $jurnalUmum['coa']['nama_akun'];
            return $jurnalUmum;
        }, $dataJurnalUmum);
        return view('jurnalUmum.index', [
            'jurnalUmum' => $dataJurnalUmum
        ]);

        // dd($dataJurnalUmum);
    }

    public function periodeJurnalUmum(Request $request)
    {
        $tanggal = $request->tanggal;
        $year = substr($tanggal, 0, 4);
        $month = substr($tanggal, 5, 2);

        $jurnalUmum = jurnal_umum::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->get();

        return view('jurnalUmum.__bodyJurnalUmum', [
            'jurnalUmum' => $jurnalUmum
        ]);
    }
}
