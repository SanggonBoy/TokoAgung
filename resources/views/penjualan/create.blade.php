@extends('template.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Tambah Penjualan</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <form action="/penjualan/storePenjualan" class="p-3" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan <span class="text-danger">*</span> <a
                                    href="javascript:void(0)" id="tambahPelanggan" style="color: #093FB4;">(Tambah
                                    Pelanggan?)</a></label>
                            <select class="form-select" name="nama_pelanggan" aria-label="Default select example">
                                <option selected>-</option>
                                @foreach ($pelanggan as $item)
                                    <option value="{{ Crypt::encrypt($item->id) }}"
                                        {{ old('nama_pelanggan') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_pelanggan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nama_pelanggan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <select class="form-select" id="produk" name="nama_produk"
                                aria-label="Default select example">
                                <option selected>-</option>
                                @foreach ($produk as $item)
                                    <option value="{{ Crypt::encrypt($item->id) }}"
                                        {{ old('nama_produk') == $item->id ? 'selected' : '' }}>{{ $item->nama_produk }} -
                                        {{ $item->merk }} - Rp. {{ number_format($item->harga_jual, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-muted mb-2 mt-2">Jumlah Stok: <span id="stok"
                                    class="text-danger"></span></span>
                            @error('nama_produk')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Item <span class="text-danger">*</span></label>
                            <input type="number" id="jumlah" name="jumlah" class="form-control"
                                placeholder="Masukkan Jumlah Item" value="{{ old('jumlah') }}" maxlength="1">
                            @error('jumlah')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Diskon <span class="text-muted">(Menggunakan Persenan)</span></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-danger text-bold" id="basic-addon1">%</span>
                                <input type="number" id="diskon" name="diskon" class="form-control"
                                    placeholder="Masukkan Diskon" value="{{ old('diskon') }}">
                            </div>
                            @error('diskon')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Harga <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-bold" id="basic-addon1">Rp. </span>
                                <input type="text" id="total_harga" name="harga_jual" class="form-control"
                                    placeholder="Masukkan Harga Jual" readonly value="{{ old('harga_jual') }}">
                                @error('harga_jual')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assetsCustom/jsCustom/penjualan.js') }}"></script>
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
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Berhasil',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
