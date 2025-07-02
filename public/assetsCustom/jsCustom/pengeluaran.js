$(document).ready(function() {
    let table = new DataTable("#pengeluaranTable")

    $(".detailPengeluaran").on("click", function() {
        var dataId = $(this).data("id");
        var dataName = $(this).data("name");
        var url = "/pengeluaran/getPengeluaran/" + dataId;
        $.ajax({
            url: url,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                let tombol = `
                    <a href="/pengeluaran/selesai/${dataId}" class="btn btn-sm btn-success">Selesai</a>
                    <a href="/pengeluaran/hapus/${dataId}" class="btn btn-sm btn-danger">Hapus</a>
                `;

                let badgeStatus = "";
                if (response.status === "Selesai") {
                    badgeStatus = `<span class="form-control badge bg-success">${response.status}</span>`;
                } else if (response.status === "Belum Selesai") {
                    badgeStatus = `<span class="form-control badge bg-danger">${response.status}</span>`;
                }

                Swal.fire({
                    title:
                        "Detail Pengeluaran " +
                        `<span class="text-primary">${dataName}</span>`,
                    html: `
                        <div class="mb-3">
                            <label class="form-label">Nama Pengeluaran</label>
                            <input type="text" class="form-control"
                                disabled value="${response.nama_pengeluaran}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nominal</label>
                            <input type="text" class="form-control"
                                disabled value="${response.nominal}">
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
            }
        })
    })
})