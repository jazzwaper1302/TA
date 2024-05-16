<?php
// Konfigurasi koneksi database
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "username"; // Ganti dengan username database Anda
$password = "password"; // Ganti dengan password database Anda
$dbname = "data_user"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil nilai username dari permintaan GET
$username = $_GET['username'];

// Melakukan pemeriksaan username di database
$sql = "SELECT * FROM akun WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Username telah digunakan
    echo "Username telah digunakan.";
} else {
    // Username tersedia
    echo "Username tersedia.";
}

// Menutup koneksi
$conn->close();
?>
