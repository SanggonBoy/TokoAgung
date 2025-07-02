$(document).ready(function () {
    $(".editSupplier").on("click", function () {
        var id = $(this).data("id");
        var url = "/supplier/getSupplier/" + id;
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                Swal.fire({
                    title: "Edit Supplier",
                    html: `
                        <div class="mb-3">
                            <label for="nama_supplier" class="text-muted">Nama Supplier</label>
                            <input type="text" id="nama_supplier" class="form-control" value="${response.nama_supplier}">
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
                        var nama_supplier = $("#nama_supplier").val();
                        var alamat = $("#alamat").val();
                        var no_telp = $("#no_telp").val();
                        if (!nama_supplier || !alamat || !no_telp) {
                            Swal.showValidationMessage(
                                "Semua field harus diisi"
                            );
                        }
                        return { nama_supplier: nama_supplier, alamat: alamat, no_telp: no_telp };
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/supplier/updateSupplier/" + id,
                            type: "POST",
                            data: {
                                id: id,
                                nama_supplier: result.value.nama_supplier,
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
                                    "Gagal memperbarui Supplier",
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
