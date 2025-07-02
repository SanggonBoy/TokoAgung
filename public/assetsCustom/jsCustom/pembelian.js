$(document).ready(function() {

    let table = new DataTable("#pembelianTable")


    $("#tambahSupplier").on("click", function() {
        Swal.fire({
            title: "Tambah Supplier",
            html: `
                        <div class="mb-3">
                            <label for="nama_supplier" class="text-muted">Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" id="nama_supplier" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="text-muted">Alamat <span class="text-danger">*</span></label>
                            <input type="text" id="alamat" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="text-muted">No Telepon <span class="text-danger">*</span></label>
                            <input type="text" id="no_telp" class="form-control">
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
                    Swal.showValidationMessage("Semua field harus diisi");
                }
                return {
                    nama_supplier: nama_supplier,
                    alamat: alamat,
                    no_telp: no_telp
                };
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/supplier/storeSupplier/",
                    type: "POST",
                    data: {
                        nama_supplier: result.value.nama_supplier,
                        alamat: result.value.alamat,
                        no_telp: result.value.no_telp,
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
                            "Terjadi kesalahan saat menambahkan supplier atau supplier sudah ada.",
                            "error"
                        ).then(() => {
                            location.reload();
                        });
                    },
                });
            }
        });
    })

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

    $(".tambahStokPembelian").on("click", function() {
        const dataId = $(this).data("id");
        Swal.fire({
            title: "Tambah Stok (Melakukan Pembelian Dengan Produk yang Telah Ada)",
            html: `
                        <div class="mb-3">
                            <label for="stok" class="text-muted">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" id="stok" class="form-control">
                        </div>
                        `,
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal",
            preConfirm: () => {
                var stok = $("#stok").val();
                if (!stok) {
                    Swal.showValidationMessage("Semua field harus diisi");
                }
                return {
                    stok: stok
                };
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/pembelian/stokProduk/",
                    type: "POST",
                    data: {
                        id: dataId,
                        stok: result.value.stok,
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
                            "Terjadi kesalahan saat menambahkan stok produk.",
                            "error"
                        ).then(() => {
                            location.reload();
                        });
                    },
                });
            }
        });
    });

    $(".detailPembelian").on("click", function () {
        const dataId = $(this).data("id");
        const dataName = $(this).data("name");
        $.ajax({
            url: "/pembelian/detailPembelian/" + dataId,
            type: "GET",
            success: function (response) {
                let tombol = "";
                if (response.status === "Dibayar") {
                    tombol = `<a href="/pembelian/dibatalkan/${dataId}" class="btn btn-sm btn-danger">Retur Kembali</a>`;
                } else if (response.status === "Dibatalkan") {
                    tombol = ``;
                } else {
                    tombol = `<a href="/pembelian/dibayarkan/${dataId}" class="btn btn-sm btn-success">Dibayarkan</a>
                    <a href="/pembelian/dibatalkan/${dataId}" class="btn btn-sm btn-danger">Dibatalkan</a>
                    `;
                }

                let badgeStatus = "";
                if (response.status === "Dibayar") {
                    badgeStatus = `<span class="form-control badge bg-success">${response.status}</span>`;
                } else if (response.status === "Dibatalkan") {
                    badgeStatus = `<span class="form-control badge bg-danger">${response.status}</span><span class="form-text text-muted">Penjualan Telah Dibatalkan. Silahkan Membuat Penjualan Baru</span>`;
                } else if (response.status === "Direturkan") {
                    badgeStatus = `<span class="form-control badge bg-danger">${response.status}</span><span class="form-text text-muted">Penjualan Telah Dibatalkan untuk retur kembali. Silahkan Membuat Penjualan Baru</span>`;
                } else {
                    badgeStatus = `<span class="form-control badge bg-warning">${response.status}</span>`;
                }

                Swal.fire({
                    title:
                        "Detail Pembelian " +
                        `<span class="text-primary">${dataName}</span>`,
                    html: `
                        <div class="mb-3">
                            <label class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control"
                                disabled value="${response.nama_supplier}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control"
                                disabled value="${response.nama_produk}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Item</label>
                            <input type="number" class="form-control"
                                disabled value="${response.jumlah}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Diskon <span class="text-muted">(%)</span></label>
                            <input type="number" class="form-control"
                                disabled value="${response.diskon}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Harga</label>
                            <input type="text" class="form-control"
                                disabled value="Rp. ${response.total_harga}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-center">Status</label>
                            ${badgeStatus}
                        </div>
                        <div class="row p-2">
                            <div class="col-md-12 text-center mb-3">
                                ${tombol}
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    showConfirmButton: false,
                    cancelButtonText: "Tutup",
                });
            },
        });
    });
})