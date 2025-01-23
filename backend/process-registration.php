<?php
// Menyertakan file koneksi database
include_once("../connection.php");

// Memeriksa apakah ada data yang dikirim melalui metode POST
if ($_POST) {
    // Mengambil informasi file yang diupload
    $file_upload = $_FILES['berkas'];
    // Memeriksa apakah file telah diupload
    if ($file_upload['name'] != "") {
        // Mengambil data dari form
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $hp = $_POST['hp'];
        $semester = $_POST['semester'];
        $beasiswa = $_POST['beasiswa'];
        $status = "Belum Diverifikasi";
        $berkas = $file_upload['name'];

        // Mengambil IPK dari tabel email_terverifikasi
        $query_ipk = "SELECT ipk FROM email_terverifikasi WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query_ipk);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result_ipk = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result_ipk)) {
            $ipk = $row['ipk'];

            // Menyimpan data ke database dengan IPK yang benar
            $insert_query = "INSERT INTO daftar_mahasiswa(nama, email, hp, semester, ipk, beasiswa, berkas, status) 
                           VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $insert_query);
            // s = string, i = integer
            // Parameter binding: nama(s), email(s), hp(s), semester(i), ipk(s), beasiswa(s), berkas(s), status(s)
            mysqli_stmt_bind_param(
                $stmt_insert, 
                "sssissss", 
                $nama, 
                $email, $hp, $semester, $ipk, $beasiswa, $berkas, $status);

            if (mysqli_stmt_execute($stmt_insert)) {
                // Menentukan lokasi penyimpanan file
                $upload_path = dirname(__DIR__) . "/uploads/" . $berkas;
                // Memindahkan file yang diupload ke lokasi penyimpanan
                move_uploaded_file($file_upload['tmp_name'], $upload_path);
                // Redirect ke halaman hasil pendaftaran
                header("Location: ../registration-beasiswa.php");
                exit();
            } else {
                // Menampilkan pesan error jika penyimpanan data gagal
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Email tidak terverifikasi";
        }
    }
}
