@extends('template.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Tambah COA</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <form action="/coa/storeCoa" class="p-3" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Kode Akun <span class="text-danger">*</span></label>
                            <input type="text" name="kode_akun" class="form-control" placeholder="Masukkan Kode Akun">
                            @error('kode_akun')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Akun <span class="text-danger">*</span></label>
                            <input type="text" name="nama_akun" class="form-control" placeholder="Masukkan Nama Akun">
                            @error('nama_akun')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelompok Akun <span class="text-danger">*</span></label>
                            <select class="form-select" name="kelompok_akun" aria-label="Default select example">
                                <option selected>-</option>
                                @foreach ($kelompokCoa as $item)
                                    <option value="{{ Crypt::encrypt($item->id) }}">{{ $item->nama_kelompok_akun }}</option>
                                @endforeach
                            </select>
                            @error('kelompok_akun')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Posisi Akun <span class="text-danger">*</span></label>
                            <select class="form-select" name="posisi_d_c" aria-label="Default select example">
                                <option value="Debit">Debit</option>
                                <option value="Kredit">Kredit</option>
                            </select>
                            @error('posisi_d_c')
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
