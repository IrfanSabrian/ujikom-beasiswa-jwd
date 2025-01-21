<?php
include_once("../connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Gunakan prepared statement untuk mencegah SQL injection
    $query = "UPDATE daftar_mahasiswa SET status = 'Diverifikasi' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            $response = [
                'success' => true,
                'message' => 'Berhasil memverifikasi status'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Gagal memverifikasi status: ' . mysqli_error($conn)
            ];
        }

        mysqli_stmt_close($stmt);
    } else {
        $response = [
            'success' => false,
            'message' => 'Gagal mempersiapkan query'
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid request method atau ID tidak ditemukan'
    ];
}

echo json_encode($response);
exit;
