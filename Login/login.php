<?php
// Mulai session
session_start();

// Konfigurasi koneksi database
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "username"; // Ganti dengan username database Anda
$password = "password"; // Ganti dengan password database Anda
$dbname = "data_user"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$koneksi = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form login
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query SQL untuk mengambil email, password, dan user_type dari tabel akun berdasarkan email yang diberikan
    $sql = "SELECT * FROM akun WHERE email='$email'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Memeriksa apakah password yang dimasukkan sesuai dengan yang tersimpan di database
        if ($password == $row['password']) {
            // Login berhasil
            $user_type = $row['user_type'];
            switch ($user_type) {
                case 'job_seeker':
                    // Pengguna tipe job_seeker akan diarahkan ke halaman beranda.html di folder akunkerja
                    header("Location: http://localhost/KP/akunkerja/profile.html");
                    break;
                case 'job_provider':
                    // Pengguna tipe job_provider akan diarahkan ke halaman beranda.html di folder akunperusahaan
                    header("Location: /KP/akunperusahaan/beranda.html");
                    break;
                case 'trainer':
                    // Pengguna tipe trainer akan diarahkan ke halaman profile.html di folder akunpelatihan/profil
                    header("Location: http://localhost/KP/akunpelatihan/profil/profile.html");
                    break;
                default:
                    // Jika jenis pengguna tidak dikenali
                    echo "<script>alert('Jenis pengguna tidak valid');</script>";
                    echo "<script>window.location.href = 'login.html';</script>";
                    exit();
            }
        } else {
            // Password salah
            echo "<script>alert('Password salah!');</script>";
            echo "<script>window.location.href = 'login.html';</script>";
            exit();
        }
    } else {
        // Akun tidak ditemukan
        echo "<script>alert('Akun dengan email tersebut tidak ditemukan');</script>";
        echo "<script>window.location.href = 'login.html';</script>";
        exit();
    }
}
?>
