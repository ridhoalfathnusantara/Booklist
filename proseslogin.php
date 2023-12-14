<?php


// Lakukan koneksi ke database PostgreSQL
$dbconn = pg_connect("host=localhost dbname=basdat user=postgres password=roufth29")
    or die('Koneksi gagal: ' . pg_last_error());

// Ambil nilai dari form login
$username = $_POST['username'];
$pw = $_POST['pw'];

// Query untuk memeriksa kecocokan informasi login
$query = "SELECT * FROM users WHERE username='$username' AND pw='$pw'";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Periksa apakah query mengembalikan baris data
if (pg_num_rows($result) > 0) {
    // Login berhasil
    // Lakukan penanganan sesuai kebutuhan, seperti mengatur session atau mengizinkan akses ke halaman tertentu.

    // Contoh: Set session atau cookie untuk menyimpan informasi login
    session_start();
    $_SESSION['username'] = $username;
    

    // Redirect ke halaman dashboard setelah login berhasil
    header("Location: dashboard.php");
    exit();
} else {
    // Login gagal
    echo "Login gagal. Silakan coba lagi.";
}

// Bebaskan hasil query dan tutup koneksi
pg_free_result($result);
pg_close($dbconn);
?>
