@extends('template.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Tambah Pelanggan</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <form action="/pelanggan/storePelanggan" class="p-3" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pelanggan" class="form-control"
                                placeholder="Masukkan Nama Pelanggan" value="{{ old('nama_pelanggan') }}">
                            @error('nama_pelanggan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat"
                                value="{{ old('alamat') }}">
                            @error('alamat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Telepon</label>
                            <input type="text" name="no_telp" class="form-control" placeholder="Masukkan No Telepon"
                                value="{{ old('no_telp') }}">
                            @error('no_telp')
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
