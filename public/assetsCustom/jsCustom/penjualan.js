$(document).ready(function () {

    let table = new DataTable("#penjualanTable")


    $("#tambahPelanggan").on("click", function () {
        Swal.fire({
            title: "Tambah Pelanggan",
            html: `
                        <div class="mb-3">
                            <label for="nama_pelanggan" class="text-muted">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" id="nama_pelanggan" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="text-muted">Alamat</label>
                            <input type="text" id="alamat" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="text-muted">No Telp</label>
                            <input type="text" id="no_telp" class="form-control">
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
                    Swal.showValidationMessage("Semua field harus diisi");
                }
                return {
                    nama_pelanggan: nama_pelanggan,
                    alamat: alamat,
                    no_telp: no_telp,
                };
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/pelanggan/storePelanggan/",
                    type: "POST",
                    data: {
                        nama_pelanggan: result.value.nama_pelanggan,
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
                            "Terjadi kesalahan saat menambahkan pelanggan atau pelanggan dan no telepon sudah ada.",
                            "error"
                        ).then(() => {
                            location.reload();
                        });
                    },
                });
            }
        });
    });

    $("#produk").on("input", function () {
        const produk = $(this).val();
        if (produk.length > 3) {
            $.ajax({
                url: "/penjualan/getProduk/" + produk,
                type: "GET",
                success: function (response) {
                    const harga_jual = response.harga_jual;
                    const stok_tersedia = response.stok;
                    const harga_jual_rupiah = harga_jual
                        .toString()
                        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");

                    $("#stok").text(stok_tersedia);
                    $("#total_harga").val(harga_jual_rupiah);
                    $("#jumlah").val(stok_tersedia > 1 ? 1: 0);

                    $("#jumlah").data("max-stok", stok_tersedia);

                    updateTotalHarga(harga_jual, stok_tersedia > 1 ? 1: 0, 0);

                    $("#jumlah").on("input", function () {
                        let jumlah = $(this).val();
                        const maxStok = $(this).data("max-stok");

                        if (jumlah && !isNaN(jumlah)) {
                            jumlah = parseInt(jumlah);
                            if (jumlah > maxStok) {
                                jumlah = maxStok;
                                $(this).val(maxStok);
                            }
                            updateTotalHarga(
                                harga_jual,
                                jumlah,
                                $("#diskon").val()
                            );
                        } else {
                            $("#total_harga").val(harga_jual_rupiah);
                        }
                    });

                    $("#diskon").on("input", function () {
                        const diskon = $(this).val();
                        const jumlah = $("#jumlah").val();
                        if (jumlah && !isNaN(jumlah) && jumlah > 0) {
                            updateTotalHarga(harga_jual, jumlah, diskon);
                        }
                    });
                },
                error: function () {
                    $("#total_harga").val("");
                },
            });
        } else {
            $("#stok").text("");
            $("#total_harga").val("");
            $("#jumlah").val("");
            $("#diskon").val("");
        }
    });

    $(".detailPenjualan").on("click", function () {
        const dataId = $(this).data("id");
        const dataName = $(this).data("name");
        $.ajax({
            url: "/penjualan/detailPenjualan/" + dataId,
            type: "GET",
            success: function (response) {
                let tombol = "";
                if (response.status === "Dibayar") {
                    tombol = `<a href="/penjualan/dibatalkan/${dataId}" class="btn btn-sm btn-danger">Retur Kembali</a>`;
                } else if (response.status === "Dibatalkan") {
                    tombol = ``;
                } else {
                    tombol = `<a href="/penjualan/dibayarkan/${dataId}" class="btn btn-sm btn-success">Dibayarkan</a>
                    <a href="/penjualan/dibatalkan/${dataId}" class="btn btn-sm btn-danger">Dibatalkan</a>
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
                        "Detail Penjualan " +
                        `<span class="text-primary">${dataName}</span>`,
                    html: `
                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control"
                                disabled value="${response.nama_pelanggan}">
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

    function updateTotalHarga(harga_jual, jumlah, diskon) {
        const total_harga = harga_jual * jumlah;
        const total_harga_rupiah = total_harga
            .toString()
            .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");

        let total_setelah_diskon = total_harga;
        if (diskon && !isNaN(diskon) && diskon >= 0) {
            const total_diskon = (total_harga * diskon) / 100;
            total_setelah_diskon = total_harga - total_diskon;
        }

        const total_setelah_diskon_rupiah = total_setelah_diskon
            .toString()
            .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $("#total_harga").val(total_setelah_diskon_rupiah);
    }
});
