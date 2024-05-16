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

// Mengambil email dari URL
$email = $_GET['email'];

// Melakukan query ke database untuk memeriksa apakah email sudah ada
$sql = "SELECT * FROM akun WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Email sudah digunakan.";
} else {
    echo "Email tersedia.";
}

// Menutup koneksi
$conn->close();
?>
