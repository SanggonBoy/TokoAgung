@extends('template.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Pembelian</h6>
                </div>
                <a href="/pembelian/createPembelian" class="badge badge-sm bg-success text-sm m-3 mb-4"><i
                        class="fa fa-plus"></i></a>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 p-3" id="pembelianTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kode Pembelian</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Supplier</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Barang</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Total Item</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Diskon</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Total Harga</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th class="text-secondary opacity-7 text-center align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelian as $item)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold">{{ $item->pembelian->kode_pembelian }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="text-xs font-weight-bold">{{ $item->pembelian->supplier->nama_supplier }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $item->produk->nama_produk }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $item->jumlah }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="text-xs font-weight-bold">{{ $item->pembelian->diskon ?? 0 }}%</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">Rp.
                                                {{ number_format($item->pembelian->total_harga, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="text-xs font-weight-bold {{ $item->pembelian->status == 'Dibayar' ? 'badge badge-sm bg-success' : ($item->pembelian->status == 'Belum Bayar' ? 'badge badge-sm bg-warning' : 'badge badge-sm bg-danger') }}">{{ $item->pembelian->status }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="row">
                                                @if ($item->pembelian->status == 'Belum Bayar')
                                                <div class="col-md-4 m-0 p-0">
                                                    <button type="button" data-id="{{ Crypt::encrypt($item->id) }}"
                                                        data-name="{{ $item->pembelian->kode_pembelian }}"
                                                        class="detailPembelian btn btn-sm btn-link text-secondary font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="Edit user">
                                                        Detail
                                                    </button>
                                                </div>
                                                    <div class="col-md-4 m-0 p-0">
                                                        <button type="button" data-id="{{ Crypt::encrypt($item->id) }}"
                                                            class="editPembelian btn btn-sm btn-link text-secondary font-weight-bold text-xs"
                                                            data-toggle="tooltip" data-original-title="Edit user">
                                                            Edit
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="col-md-4 m-0 p-0">
                                                    <button type="button" data-id="{{ Crypt::encrypt($item->id) }}"
                                                        class="tambahStokPembelian btn btn-sm btn-link text-secondary font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="Edit user">
                                                        Tambah Stok
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assetsCustom/jsCustom/pembelian.js') }}"></script>
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
