<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Lakukan koneksi ke database
$pdo = new PDO('pgsql:host=localhost;dbname=basdat', 'postgres', 'roufth29');

// Decode data yang dikirim dari JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Pastikan bahwa username sudah ada di dalam session sebelum digunakan
$username = $_SESSION['username'];

// Dapatkan user_id menggunakan prepared statement
$getUserID = $pdo->prepare("SELECT user_id FROM users WHERE username = :username");
$getUserID->execute(array(':username' => $username));
$user = $getUserID->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Pengguna tidak ditemukan";
    exit();
}

// Menggunakan data user_id dari hasil query sebelumnya
$user_id = $user['user_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judulBuku = $_POST['judulbuku'];
    $penulis = $_POST['penulis'];
    $tahunTerbit = $_POST['tahunterbit'];
    $penerbit = $_POST['penerbit'];
    $prioritas = $_POST['skalaprioritas'];

    // Lakukan penyimpanan data ke database menggunakan prepared statement
    $insertQuery = $pdo->prepare("INSERT INTO wishlist (judulbuku, penulis, tahunterbit, penerbit, skalaprioritas, user_id) 
                                VALUES (:judulbuku, :penulis, :tahunterbit, :penerbit, :prioritas, :user_id)");

    // Bind parameter ke statement
    $insertQuery->bindParam(':judulbuku', $judulBuku);
    $insertQuery->bindParam(':penulis', $penulis);
    $insertQuery->bindParam(':tahunterbit', $tahunTerbit);
    $insertQuery->bindParam(':penerbit', $penerbit);
    $insertQuery->bindParam(':prioritas', $prioritas);
    $insertQuery->bindParam(':user_id', $user_id);

    
    
    if (!is_numeric($tahunTerbit)) {
        echo "Tahun terbit harus berupa angka";
        exit();
    }

    // Eksekusi statement
    if ($insertQuery->execute()) {
        // Redirect ke halaman profil setelah insert berhasil
        header("Location: dashboard.php");
        exit();
    } else {
        // Tampilkan pesan kesalahan jika eksekusi query gagal
        echo "Gagal menyimpan ke database: " . $insertQuery->errorInfo()[2];
        exit();
    }
}
?>
