$(document).ready(function() {
    $("#tanggal").on('change', function() {
        var tanggal = $(this).val();
        $.ajax({
            url: '/jurnalUmum/periodeJurnalUmum',
            type: 'GET',
            data: { tanggal: tanggal },
            success: function(response) {
                $('#jurnalUmumTable tbody').html(response);
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    });
});
