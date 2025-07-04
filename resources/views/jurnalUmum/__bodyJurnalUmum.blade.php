@foreach ($jurnalUmum as $item)
    <tr>
        <td class="align-middle text-center text-sm">
            <p class="text-xs font-weight-bold">{{ $loop->iteration }}</p>
        </td>
        <td class="align-middle text-center text-sm">
            <span class="text-xs font-weight-bold">{{ $item->transaksi->tanggal->format('d-m-Y') }}</span>
        </td>
        <td class="align-middle text-center text-sm">
            <span class="text-xs font-weight-bold">{{ $item->coa->nama_akun }}</span>
        </td>
        <td class="align-middle text-center text-sm">
            <span class="text-xs font-weight-bold">{{ $item->debit ? 'Rp. ' . number_format($item->debit, 0, ',', '.') : '-' }}</span>
        </td>
        <td class="align-middle text-center text-sm">
            <span class="text-xs font-weight-bold">{{ $item->kredit ? 'Rp. ' . number_format($item->kredit, 0, ',', '.') : '-' }}</span>
        </td>
    </tr>
@endforeach

