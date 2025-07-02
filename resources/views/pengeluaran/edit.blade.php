@extends('template.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Pengeluaran</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <form action="/pengeluaran/updatePengeluaran/{{ Crypt::encrypt($pengeluaran->id) }}" class="p-3" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label">Nama Pengeluaran <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pengeluaran" class="form-control" placeholder="Masukkan Nama Pengeluaran"
                                value="{{ old('nama_pengeluaran', $pengeluaran->nama_pengeluaran) }}">
                            @error('nama_pengeluaran')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nominal <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-bold" id="basic-addon1">Rp. </span>
                                <input type="number" name="nominal" class="form-control"
                                    placeholder="Masukkan Harga Beli" value="{{ old('nominal', $pengeluaran->nominal) }}">
                                @error('nominal')
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
    <script src="{{ asset('assetsCustom/jsCustom/pengeluaran.js') }}"></script>
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
