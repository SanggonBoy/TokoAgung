@extends('template.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Penjualan</h6>
                </div>
                <a href="/penjualan/createPenjualan" class="badge badge-sm bg-success text-sm m-3 mb-4"><i
                        class="fa fa-plus"></i></a>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 p-3" id="penjualanTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kode Penjualan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Pelanggan</th>
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
                                    <th class="text-secondary opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjualan as $item)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold">{{ $item->kode_penjualan }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="text-xs font-weight-bold">{{ $item->pelanggan->nama_pelanggan }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $item->total_item }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $item->diskon }}%</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">Rp.
                                                {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="text-xs font-weight-bold {{ $item->status == 'Dibayar' ? 'badge badge-sm bg-success' : ($item->status == 'Belum Bayar' ? 'badge badge-sm bg-warning' : 'badge badge-sm bg-danger') }}">{{ $item->status }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @if ($item->status == 'Belum Bayar')
                                                <button type="button" data-id="{{ Crypt::encrypt($item->id) }}"
                                                    data-name="{{ $item->kode_penjualan }}"
                                                    class="detailPenjualan btn btn-link text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Edit user">
                                                    Detail
                                                </button>
                                                <button type="button" data-id="{{ Crypt::encrypt($item->id) }}"
                                                    class="editPenjualan btn btn-link text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Edit user">
                                                    Edit
                                                </button>
                                            @endif
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
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
