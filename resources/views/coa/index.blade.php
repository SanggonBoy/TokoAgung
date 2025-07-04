@extends('template.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>COA</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 p-3">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kode Akun</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Akun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coa as $item)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold">{{ $item->kode_akun }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $item->nama_akun }}</span>
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
