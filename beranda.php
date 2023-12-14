<?php
session_start(); // Memulai sesi

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect ke halaman login jika pengguna belum login
    exit();
}

// Ambil nama pengguna dari sesi
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Halaman Beranda</title>
</head>

<body>
    <h2>Selamat Datang, <?php echo $username; ?>!</h2>
    <p>Ini adalah halaman beranda setelah login.</p>
    <a href="logout.php">Logout</a> <!-- Tautan untuk logout -->
</body>

</html>
