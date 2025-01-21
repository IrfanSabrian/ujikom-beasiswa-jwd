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
        $ipk = $_POST['ipk'];
        $beasiswa = $_POST['beasiswa'];
        $status = "Belum Diverifikasi";
        $berkas = $file_upload['name'];

        // Menyimpan data ke database
        $result = mysqli_query($conn, "INSERT INTO daftar_mahasiswa(nama, email, hp, semester, ipk, beasiswa, berkas, status) 
                                       VALUES('$nama', '$email', '$hp', '$semester', '$ipk', '$beasiswa', '$berkas', '$status')");
        // Memeriksa apakah penyimpanan data berhasil
        if ($result) {
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
    }
}
