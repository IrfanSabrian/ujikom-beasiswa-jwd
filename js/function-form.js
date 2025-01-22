$(document).ready(function () {
  // Menonaktifkan semua input kecuali email dan nama saat pertama kali
  $("#hp, #semester, #inputIpk, #beasiswa, #customfile, #tombolDaftar").prop(
    "disabled",
    true
  );

  $("#inputEmail").change(function () {
    var email = $("#inputEmail").val();

    // Menggunakan AJAX untuk mengambil data dari database
    $.ajax({
      url: "backend/get_email_data.php",
      method: "GET",
      data: { email: email },
      dataType: "json",
      success: function (data) {
        if (data) {
          // Enable input yang diperlukan
          $("#hp, #semester, #beasiswa, #customfile").prop("disabled", false);

          // Mengisi data nama dan IPK dari email terverifikasi
          $("#inputNama").val(data.nama);
          $("#inputIpk").val(data.ipk);

          // Cek IPK untuk enable/disable tombol daftar
          if (data.ipk < 3) {
            $("#tombolDaftar, #beasiswa, #customfile").prop("disabled", true);
            $("#warningModal").modal("show");
          } else {
            $("#tombolDaftar, #beasiswa, #customfile").prop("disabled", false);
            $("#beasiswa").focus();
          }
        } else {
          // Jika email tidak dikenali
          $("#WarningModal").modal("show");
          // Menonaktifkan semua input kecuali email dan nama
          $(
            "#hp, #semester, #inputIpk, #beasiswa, #customfile, #tombolDaftar"
          ).prop("disabled", true);
          // Mengosongkan nilai input
          $("#inputIpk").val("");
          $("#inputNama").val("");
        }
      },
      error: function () {
        $("#WarningModal").modal("show");
        // Menonaktifkan dan mengosongkan input saat terjadi error
        $(
          "#hp, #semester, #inputIpk, #beasiswa, #customfile, #tombolDaftar"
        ).prop("disabled", true);
        $("#inputIpk").val("");
        $("#inputNama").val("");
      },
    });
  });
});
