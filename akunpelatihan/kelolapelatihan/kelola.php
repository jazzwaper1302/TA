<?php
// Koneksi ke database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "data_user";

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data pelatihan dari database
$sql = "SELECT * FROM buat_pelatihan";
$result = $conn->query($sql);

// Inisialisasi array untuk menampung data pelatihan
$pelatihan = array();

// Periksa apakah ada hasil
if ($result->num_rows > 0) {
    // Loop melalui setiap baris hasil dan tambahkan ke array
    while($row = $result->fetch_assoc()) {
        $pelatihan[] = $row;
    }
}

// Mengembalikan data pelatihan dalam format JSON
echo json_encode($pelatihan);

// Menutup koneksi database
$conn->close();
?>
