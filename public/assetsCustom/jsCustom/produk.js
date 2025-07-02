$(document).ready(function () {
    $(".editProduk").on("click", function () {
        var id = $(this).data("id");
        var url = "/produk/getProduk/" + id;
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                Swal.fire({
                    title: "Edit Produk",
                    html: `
                        <div class="mb-3">
                            <label for="nama_produk" class="text-muted">Nama Produk</label>
                            <input type="text" id="nama_produk" class="form-control" value="${
                                response.nama_produk
                            }">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" id="nama_kategori" aria-label="Default select example">
                                ${response.kategori
                                    .map(
                                        (item) => `
                                <option value="${item.id}" ${
                                            item.is_selected ? "selected" : ""
                                        }>
                                    ${item.nama_kategori}
                                </option>
                                `
                                    )
                                    .join("")}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="merk" class="text-muted">Merk</label>
                            <input type="text" id="merk" class="form-control" value="${
                                response.merk
                            }">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga Beli</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-bold" id="basic-addon1">Rp. </span>
                                <input type="number" id="harga_beli" class="form-control" placeholder="Masukkan Harga Beli" value="${
                                    response.harga_beli
                                }">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga Jual</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-bold" id="basic-addon1">Rp. </span>
                                <input type="number" id="harga_jual" class="form-control" placeholder="Masukkan Harga Jual" value="${
                                    response.harga_jual
                                }">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="text-muted">Stok</label>
                            <input type="text" id="stok" class="form-control" value="${
                                response.stok
                            }">
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal",
                    preConfirm: () => {
                        var nama_produk = $("#nama_produk").val();
                        var nama_kategori = $("#nama_kategori").val();
                        var merk = $("#merk").val();
                        var harga_beli = $("#harga_beli").val();
                        var harga_jual = $("#harga_jual").val();
                        var stok = $("#stok").val();

                        if (
                            !nama_produk ||
                            !nama_kategori ||
                            !merk ||
                            !harga_beli ||
                            !harga_jual ||
                            !stok
                        ) {
                            Swal.showValidationMessage(
                                "Semua field harus diisi"
                            );
                        }
                        return {
                            nama_produk: nama_produk,
                            nama_kategori: nama_kategori,
                            merk: merk,
                            harga_beli: harga_beli,
                            harga_jual: harga_jual,
                            stok: stok,
                        };
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/produk/updateProduk/" + id,
                            type: "POST",
                            data: {
                                id: id,
                                nama_produk: result.value.nama_produk,
                                nama_kategori: result.value.nama_kategori,
                                merk: result.value.merk,
                                harga_beli: result.value.harga_beli,
                                harga_jual: result.value.harga_jual,
                                stok: result.value.stok,
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
                                    "Gagal memperbarui Produk",
                                    "error"
                                );
                            },
                        });
                    }
                });
            },
            error: function (xhr) {
                console.error(xhr);
                Swal.fire("Error", "Gagal mengambil data Produk", "error");
            },
        });
    });

    $("#tambahKategori").on("click", function () {
        Swal.fire({
            title: "Tambah Kategori",
            html: `
                        <div class="mb-3">
                            <label for="nama_kategori" class="text-muted">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" id="nama_kategori" class="form-control">
                        </div>
                        `,
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal",
            preConfirm: () => {
                var nama_kategori = $("#nama_kategori").val();
                if (!nama_kategori) {
                    Swal.showValidationMessage("Semua field harus diisi");
                }
                return {
                    nama_kategori: nama_kategori
                };
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/kategori/storeKategori/",
                    type: "POST",
                    data: {
                        nama_kategori: result.value.nama_kategori,
                        _token: $('meta[name="csrf-token"]').attr("content"),
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
                    error: function (response) {
                        Swal.fire(
                            "Gagal",
                            "Terjadi kesalahan saat menambahkan kategori atau kategori sudah ada.",
                            "error"
                        ).then(() => {
                            location.reload();
                        });
                    },
                });
            }
        });
    });
});
