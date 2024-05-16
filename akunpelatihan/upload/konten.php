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

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $category = $_POST['category'];
    if ($category === 'Lainnya') {
        $category = $_POST['otherCategory'];
    }
    $title = $_POST['title'];
    $description = $_POST['description'];
    $author = $_POST['author'];

    // Mengambil file yang diunggah
    $file_name = $_FILES['pdfFile']['name'];
    $file_temp = $_FILES['pdfFile']['tmp_name'];
    $file_path = "uploads/" . $file_name; // Direktori penyimpanan file

    // Memindahkan file ke direktori yang ditentukan
    move_uploaded_file($file_temp, $file_path);

    // Menyiapkan pernyataan SQL INSERT
    $sql = "INSERT INTO materi (category, title, description, author, file_name, file_path) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $category, $title, $description, $author, $file_name, $file_path);

    // Mengeksekusi pernyataan
    if ($stmt->execute()) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup pernyataan dan koneksi
    $stmt->close();
    $conn->close();
}
?>
