<?php
// Koneksi database
$conn = new mysqli("localhost", "root", "", "ujikom_jwd");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$email = $_GET['email'];

$sql = "SELECT * FROM email_terverifikasi WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(null);
}

$stmt->close();
$conn->close();
