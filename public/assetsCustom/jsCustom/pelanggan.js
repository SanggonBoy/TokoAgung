$(document).ready(function () {
    $(".editPelanggan").on("click", function () {
        var id = $(this).data("id");
        var url = "/pelanggan/getPelanggan/" + id;
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                Swal.fire({
                    title: "Edit Pelanggan",
                    html: `
                        <div class="mb-3">
                            <label for="nama_pelanggan" class="text-muted">Nama Pelanggan</label>
                            <input type="text" id="nama_pelanggan" class="form-control" value="${response.nama_pelanggan}">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="text-muted">Alamat</label>
                            <input type="text" id="alamat" class="form-control" value="${response.alamat}">
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="text-muted">No Telp</label>
                            <input type="text" id="no_telp" class="form-control" value="${response.no_telp}">
                        </div>
                        `,
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal",
                    preConfirm: () => {
                        var nama_pelanggan = $("#nama_pelanggan").val();
                        var alamat = $("#alamat").val();
                        var no_telp = $("#no_telp").val();
                        if (!nama_pelanggan || !alamat || !no_telp) {
                            Swal.showValidationMessage(
                                "Semua field harus diisi"
                            );
                        }
                        return { nama_pelanggan: nama_pelanggan, alamat: alamat, no_telp: no_telp };
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/pelanggan/updatePelanggan/" + id,
                            type: "POST",
                            data: {
                                id: id,
                                nama_pelanggan: result.value.nama_pelanggan,
                                alamat: result.value.alamat,
                                no_telp: result.value.no_telp,
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
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
                            error: function (xhr) {
                                Swal.fire(
                                    "Error",
                                    "Gagal memperbarui Pelanggan",
                                    "error"
                                );
                            },
                        });
                    }
                });
            },
            error: function (xhr) {
                console.error(xhr);
            },
        });
    });
});
