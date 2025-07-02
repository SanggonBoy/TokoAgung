@extends('template.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Tambah Supplier</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <form action="/supplier/storeSupplier" class="p-3" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" name="nama_supplier" class="form-control"
                                placeholder="Masukkan Nama Supplier" value="{{ old('nama_supplier') }}">
                            @error('nama_supplier')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <input type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat"
                                value="{{ old('alamat') }}">
                            @error('alamat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Telepon <span class="text-danger">*</span></label>
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
