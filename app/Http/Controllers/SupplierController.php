<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use App\Http\Requests\StoresupplierRequest;
use App\Http\Requests\UpdatesupplierRequest;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SupplierController extends Controller
{
    public function supplier()
    {
        $supplier = supplier::all();
        return view('supplier.index', [
            'supplier' => $supplier
        ]);
    }

    public function viewCreateSupplier()
    {
        return view('supplier.create');
    }

    public function storeSupplier(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|unique:supplier,nama_supplier|max:255',
            'alamat' => 'required|max:255',
            'no_telp' => 'required|unique:supplier,no_telp|max:15',
        ]);

        if ($request->ajax) {
            if (supplier::where('nama_supplier', $request->nama_supplier)->exists()) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Nama Nama Supplier Sudah Ada.',
                    'status' => 'error'
                ], 200);
            }
            if(!$request->alamat) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Alamat Tidak Boleh Kosong.',
                    'status' => 'error'
                ], 200);
            }
            if(supplier::where('no_telp', $request->no_telp)->exists()) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'No Telepon Sudah Digunakan.',
                    'status' => 'error'
                ], 200);
            }
        }

        supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp 
        ]);

        if($request->ajax()) {
            return response()->json([
                'title' => 'Berhasil',
                'message' => 'Supplier berhasil ditambahkan',
                'status' => 'success'
            ], 200);
        }

        return redirect('/supplier')->with('success', 'Supplier Berhasil Ditambahkan.');
    }

    public function getSupplier($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        }
        catch(DecryptException $e) {
            return back()->withErrors(['error' => 'Data Tidak Valid.']);
        }

        $supplier = supplier::findOrFail($decryptedId);

        return response()->json([
            'nama_supplier' => $supplier->nama_supplier,
            'alamat' => $supplier->alamat,
            'no_telp' => $supplier->no_telp
        ]);
    }

    public function updateSupplier(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
            $decryptedIdSupplierRequest = Crypt::decrypt($request->id);
        }
        catch(DecryptException $e) {
            return back()->withErrors(['error' => 'Data Tidak Valid.']);
        }

        $supplier = supplier::findOrFail($decryptedId);

        if($supplier->id === $decryptedIdSupplierRequest) {
            if(supplier::where('nama_supplier', $request->nama_supplier)
                ->where('id', '!=', $supplier->id)
                ->exists()) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Nama Supplier Sudah Digunakan.',
                    'status' => 'error'
                ], 200);
            }
            if(supplier::where('no_telp', $request->no_telp)
                ->where('id', '!=', $supplier->id)
                ->exists()) {
                return response()->json([
                    'title' => 'Gagal',
                    'message' => 'Nomor Telepon Sudah Digunakan.',
                    'status' => 'error'
                ], 200);
            }
        }

        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp
        ]);

        return response()->json([
            'title' => 'Berhasil',
            'message' => 'Supplier Berhasil Diperbarui.',
            'status' => 'success'
        ], 200);
    }
}
