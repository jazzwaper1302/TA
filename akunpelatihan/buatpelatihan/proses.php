<?php
// Pastikan menghubungkan ke database Anda di sini
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "data_user";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah form telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari formulir
    $judul_pelatihan = $_POST['judul_pelatihan'];
    $keahlian = $_POST['keahlian'];
    $tanggal_pelatihan = $_POST['tanggal_pelatihan'];
    $sesi_pelatihan = $_POST['sesi_pelatihan'];
    $nama_pengisi = $_POST['nama_pengisi'];
    $kuota_pelatihan = $_POST['kuota_pelatihan'];
    $deskripsi = $_POST['deskripsi'];

    // Menyiapkan pernyataan SQL untuk disimpan ke database
    $sql = "INSERT INTO buat_pelatihan (judul_pelatihan, keahlian, tanggal_pelatihan, sesi_pelatihan, nama_pengisi, kuota_pelatihan, deskripsi) 
    VALUES ('$judul_pelatihan', '$keahlian', '$tanggal_pelatihan', '$sesi_pelatihan', '$nama_pengisi', '$kuota_pelatihan', '$deskripsi')";

    if ($conn->query($sql) === TRUE) {
        // Pesan pop-up "Pelatihan telah dibuat"
        echo '<script>alert("Pelatihan telah dibuat");</script>';
        // Mengalihkan ke halaman lain setelah 3 detik
        echo '<script>setTimeout(function(){ window.location.replace("http://localhost/KP/akunpelatihan/tambahpelatihan/tambahpelatihan.html"); }, 30);</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menutup koneksi
$conn->close();
?>
