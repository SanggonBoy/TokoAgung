@extends('template.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Tambah Kelompok COA</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <form action="/kelompokCoa/storeKelompokCoa" class="p-3" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Kelompok Akun <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kelompok_akun" class="form-control" placeholder="Masukkan Nama Kelompok Akun">
                            @error('nama_kelompok_akun')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Header Akun <span class="text-danger">*</span></label>
                            <input type="text" name="header_akun" class="form-control" placeholder="Masukkan Header Akun">
                            @error('header_akun')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
