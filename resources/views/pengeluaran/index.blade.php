@extends('template.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Pengeluaran</h6>
                </div>
                <a href="/pengeluaran/createPengeluaran" class="badge badge-sm bg-success text-sm m-3 mb-4"><i
                        class="fa fa-plus"></i></a>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 p-3" id="pengeluaranTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kode Pengeluaran</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Pengeluaran</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nominal</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th class="text-secondary opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengeluaran as $item)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold">{{ $item->kode_pengeluaran }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $item->nama_pengeluaran }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">Rp.
                                                {{ number_format($item->nominal, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="text-xs font-weight-bold {{ $item->status == 'Selesai' ? 'badge badge-sm bg-success' : ($item->status == 'Belum Selesai' ? 'badge badge-sm bg-warning' : 'badge badge-sm bg-danger') }}">{{ $item->status }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @if ($item->status == 'Belum Selesai')
                                                <button type="button" data-id="{{ Crypt::encrypt($item->id) }}" data-name="{{ $item->kode_pengeluaran }}"
                                                    class="detailPengeluaran btn btn-link text-secondary font-weight-bold text-xs">
                                                    Detail
                                                </button>
                                                <a href="/pengeluaran/editPengeluaran/{{ Crypt::encrypt($item->id) }}"
                                                    class="editPengeluaran btn btn-link text-secondary font-weight-bold text-xs">
                                                    Edit
                                                </a>
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
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
