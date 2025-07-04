@extends('template.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Jurnal Umum</h6>
                </div>
                <div class="m-2 p-2 text-center">
                    <label for="tanggal">Pilih Periode</label>
                    <input type="month" name="tanggal" id="tanggal">
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 p-3" id="jurnalUmumTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        No</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tanggal</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Akun</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Debit</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jurnalUmum as $item)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold">{{ $loop->iteration }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $item['transaksi'] }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $item['coa'] }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $item['debet'] }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $item['kredit'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="mt-4">
                        @if ($totalDebit == $totalKredit)
                            <div class="alert alert-success" role="alert">
                                Jurnal Umum Seimbang!
                            </div>
                        @else
                            <div class="alert alert-danger" role="alert">
                                Jurnal Umum Tidak Seimbang! <br>
                                Total Debit: Rp. {{ number_format($totalDebit, 0, ',', '.') }} <br>
                                Total Kredit: Rp. {{ number_format($totalKredit, 0, ',', '.') }}
                            </div>
                        @endif
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assetsCustom/jsCustom/jurnalUmum.js') }}"></script>
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
