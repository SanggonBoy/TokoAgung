@extends('template.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Tambah Produk</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <form action="/produk/storeProduk" class="p-3" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="nama_produk" class="form-control" placeholder="Masukkan Nama Produk"
                                value="{{ old('nama_produk') }}">
                            @error('nama_produk')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span><a
                                    href="javascript:void(0)" id="tambahKategori" style="color: #093FB4;">(Tambah
                                    Kategori?)</a></label>
                            <select class="form-select" name="nama_kategori" aria-label="Default select example">
                                <option selected>-</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ Crypt::encrypt($item->id) }}"
                                        {{ old('nama_kategori') == $item->id ? 'selected' : '' }}>{{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nama_kategori')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Merk <span class="text-danger">*</span></label>
                            <input type="text" name="merk" class="form-control" placeholder="Masukkan Merk"
                                value="{{ old('merk') }}">
                            @error('merk')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga Beli <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-bold" id="basic-addon1">Rp. </span>
                                <input type="number" name="harga_beli" class="form-control"
                                    placeholder="Masukkan Harga Beli" value="{{ old('harga_beli') }}">
                                @error('harga_beli')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga Jual <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-bold" id="basic-addon1">Rp. </span>
                                <input type="number" name="harga_jual" class="form-control"
                                    placeholder="Masukkan Harga Jual" value="{{ old('harga_jual') }}">
                                @error('harga_jual')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control" placeholder="Masukkan Stok"
                                value="{{ old('stok') }}">
                            @error('stok')
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
@section('js')
    <script src="{{ asset('assetsCustom/jsCustom/produk.js') }}"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
