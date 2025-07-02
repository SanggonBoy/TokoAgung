$(document).ready(function() {
    $('.editKelompokCoa').on('click', function() {
        var id = $(this).data('id');
        var url = '/kelompokCoa/getKelompokCoa/' + id;
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                Swal.fire({
                    title: 'Edit Kelompok COA',
                    html: `
                        <div class="mb-3">
                            <label for="nama_kelompok_akun" class="text-muted">Nama Kelompok COA</label>
                            <input type="text" id="nama_kelompok_akun" class="form-control" value="${response.nama_kelompok_akun}">
                        </div>
                        <div class="mb-3>
                            <label for="header_akun" class="text-muted">Header Akun</label>
                            <input type="text" id="header_akun" class="form-control" value="${response.header_akun}">
                        </div>
                        `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        var nama_kelompok_akun = $('#nama_kelompok_akun').val();
                        var header_akun = $('#header_akun').val();
                        if (!nama_kelompok_akun || !header_akun) {
                            Swal.showValidationMessage('Semua field harus diisi');
                        }
                        return { nama_kelompok_akun: nama_kelompok_akun, header_akun: header_akun };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/kelompokCoa/updateKelompokCoa/' + id,
                            type: 'POST',
                            data: {
                                id: id,
                                nama_kelompok_akun: result.value.nama_kelompok_akun,
                                header_akun: result.value.header_akun,
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
                                Swal.fire('Error', 'Gagal memperbarui Kelompok COA', 'error');
                            }
                        });
                    }
                })
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    });
})