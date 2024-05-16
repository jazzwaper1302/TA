<?php
// Konfigurasi koneksi database
$servername = "localhost"; // Ganti dengan nama server Anda
$username_db = "username"; // Ganti dengan username database Anda
$password_db = "password"; // Ganti dengan password database Anda
$dbname = "data_user"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Jika form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type']; // Mendapatkan tipe pengguna yang dipilih

    // Memeriksa apakah username atau email sudah digunakan
    $check_query = "SELECT * FROM akun WHERE username='$username' OR email='$email'";
    $result = $conn->query($check_query);
    if ($result->num_rows > 0) {
        // Jika username atau email sudah digunakan
        echo "Username atau email telah digunakan!";
    } else {
        // Jika username dan email belum digunakan, melakukan insert data ke tabel akun
        $sql = "INSERT INTO akun (fullname, username, email, password, user_type) 
                VALUES ('$fullname', '$username', '$email', '$password', '$user_type')";

        if ($conn->query($sql) === TRUE) {
            // Setelah berhasil mendaftar, ambil data pengguna dari database
            $user_query = "SELECT id, username FROM akun WHERE username='$username'";
            $user_result = $conn->query($user_query);

            if ($user_result->num_rows > 0) {
                // Ambil data pengguna
                $user_data = $user_result->fetch_assoc();
                $user_id = $user_data['id'];
                $user_username = $user_data['username'];

                // Redirect ke halaman Lengkapiprofile.html dengan data pengguna
                header("Location: http://localhost/KP/Signup/Lengkapiprofile.html?user_id=$user_id&username=$user_username");
                exit();
            } else {
                echo "Pendaftaran berhasil, tetapi tidak dapat memuat data pengguna.";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Menutup koneksi
$conn->close();
?>