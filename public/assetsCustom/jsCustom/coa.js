$(document).ready(function() {
    $('.editCoa').on('click', function() {
        var id = $(this).data('id');
        var url = '/coa/getCoa/' + id;
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                Swal.fire({
                    title: 'Edit COA',
                    html: `
                        <div class="mb-3">
                            <label for="kode_akun" class="text-muted">Kode Akun</label>
                            <input type="text" id="kode_akun" class="form-control" value="${response.kode_akun}">
                        </div>
                        <div class="mb-3">
                            <label for="nama_akun" class="text-muted">Nama Akun</label>
                            <input type="text" id="nama_akun" class="form-control" value="${response.nama_akun}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelompok Akun</label>
                            <select class="form-select" id="kelompok_akun" name="kelompok_akun" aria-label="Default select example">
                                ${response.kelompok_akun.map(item => `
                                <option value="${item.id}" ${item.is_selected ? 'selected' : ''}>
                                    ${item.nama_kelompok_akun}
                                </option>
                                `).join('')}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Posisi Akun</label>
                            <select class="form-select" id="posisi_d_c" name="posisi_d_c" aria-label="Default select example">
                                <option value="Debit" ${response.selected_posisi_d_c === 'Debit' ? 'selected' : ''}>Debit</option>
                                <option value="Kredit" ${response.selected_posisi_d_c === 'Kredit' ? 'selected' : ''}>Kredit</option>
                            </select>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        var kode_akun = $('#kode_akun').val();
                        var nama_akun = $('#nama_akun').val();
                        var kelompok_akun = $('#kelompok_akun').val();
                        var posisi_d_c = $('#posisi_d_c').val();

                        if (!kode_akun || !nama_akun || !kelompok_akun || !posisi_d_c) {
                            Swal.showValidationMessage('Semua field harus diisi');
                        }
                        return { kode_akun: kode_akun, nama_akun: nama_akun, kelompok_akun: kelompok_akun, posisi_d_c: posisi_d_c };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/coa/updateCoa/' + id,
                            type: 'POST',
                            data: {
                                id: id,
                                kode_akun: result.value.kode_akun,
                                nama_akun: result.value.nama_akun,
                                kelompok_akun: result.value.kelompok_akun,
                                posisi_d_c: result.value.posisi_d_c,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                Swal.fire(
                                    response.title,
                                    response.message,
                                    response.status
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire('Error', 'Gagal memperbarui COA', 'error');
                            }
                        });
                    }
                });
            },
            error: function(xhr) {
                console.error(xhr);
                Swal.fire('Error', 'Gagal mengambil data COA', 'error');
            }
        });
    });
});
