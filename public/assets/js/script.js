$(function () {
    $("#example1")
        .DataTable({
            responsive: true,
            autoWidth: true,
            fixedColumns: true,
            columnDefs: [
                {
                    targets: "_all",
                    className: "dt-center cell-border",
                },
            ],
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        })
        .buttons()
        .container()
        .appendTo("#example1_wrapper .col-md-6:eq(0)");
});
$(function () {
    var url = window.location.href;
    $("#sideMenu li").each(function () {
        if (url.includes($(this).children().attr("href"))) {
            $(this)
                .parent("ul")
                .parent("li")
                .addClass("menu-open")
                .children("a")
                .addClass("active");
            $(this).find("a:first").addClass("active");
        }
    });
});
$(".modal").on("hidden.bs.modal", function (e) {
    const form = $(this).find("form");
    form[0].reset(); // Reset input from form
    form.validate().resetForm(); // Reset state after validated
    form.find(".is-invalid").removeClass("is-invalid");
    form.find(".is-valid").removeClass("is-valid");
});
function logoutConfirm() {
    Swal.fire({
        title: "Apa Anda Yakin?",
        html: "Anda akan keluar dari aplikasi",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Yakin!",
        cancelButtonText: "Batal",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('/logout') }}",
                success: function (res) {
                    Swal.fire(
                        "Berhasil",
                        "Anda telah keluar dari aplikasi",
                        "success"
                    ).then((result) => {
                        window.location.href = "{{ url('signin') }}";
                    });
                },
                error: function (res) {
                    Swal.fire("Gagal", "Ada Kesalahan", "error");
                },
            });
        }
    });
}

function addQueryParam(url, param, value) {
    var separator = url.indexOf("?") === -1 ? "?" : "&";
    var pattern = new RegExp("\\b(" + param + "=).*?(&|$)");
    if (pattern.test(url)) {
        return url.replace(pattern, "$1" + value + "$2");
    }
    return (
        url +
        separator +
        encodeURIComponent(param) +
        "=" +
        encodeURIComponent(value)
    );
}
