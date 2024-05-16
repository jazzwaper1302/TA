<?php
// Koneksi ke database (ganti sesuai dengan informasi database Anda)
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

// Menangani request POST untuk menyimpan data yang diedit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $judul = $_POST["editJudul"];
    $keahlian = $_POST["editKeahlian"];
    $tanggal = $_POST["editTanggal"];
    $sesi = $_POST["editSesi"];
    $pengisi = $_POST["editPengisi"];
    $kuota = $_POST["editKuota"];
    $keterangan = $_POST["editKeterangan"];

    // Melakukan sanitasi input untuk mencegah SQL injection
    $judul = mysqli_real_escape_string($conn, $judul);
    $keahlian = mysqli_real_escape_string($conn, $keahlian);
    $tanggal = mysqli_real_escape_string($conn, $tanggal);
    $sesi = mysqli_real_escape_string($conn, $sesi);
    $pengisi = mysqli_real_escape_string($conn, $pengisi);
    $kuota = mysqli_real_escape_string($conn, $kuota);
    $keterangan = mysqli_real_escape_string($conn, $keterangan);

    // Query SQL untuk menyimpan data ke database
    $sql = "UPDATE buat_pelatihan SET keahlian='$keahlian', tanggal_pelatihan='$tanggal', sesi_pelatihan='$sesi', nama_pengisi='$pengisi', kuota_pelatihan='$kuota', deskripsi='$keterangan' WHERE judul_pelatihan='$judul'";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diperbarui";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menutup koneksi database
$conn->close();
?>
