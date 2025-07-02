$(document).ready(function () {
    $(".editKategori").on("click", function () {
        var id = $(this).data("id");
        var url = "/kategori/getKategori/" + id;
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                Swal.fire({
                    title: "Edit Kategori",
                    html: `
                        <div class="mb-3">
                            <label for="nama_kategori" class="text-muted">Nama Kelompok COA</label>
                            <input type="text" id="nama_kategori" class="form-control" value="${response.nama_kategori}">
                        </div>
                        `,
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal",
                    preConfirm: () => {
                        var nama_kategori = $("#nama_kategori").val();
                        if (!nama_kategori) {
                            Swal.showValidationMessage(
                                "Semua field harus diisi"
                            );
                        }
                        return { nama_kategori: nama_kategori };
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/kategori/updateKategori/" + id,
                            type: "POST",
                            data: {
                                id: id,
                                nama_kategori: result.value.nama_kategori,
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
                                    "Gagal memperbarui Kategori",
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
