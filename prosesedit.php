<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: user.php");
    exit();
}

$pdo = new PDO('pgsql:host=localhost;dbname=basdat', 'postgres', 'roufth29');

$username = $_SESSION['username'];

// Ambil data pengguna sebelum diedit
$statement = $pdo->prepare("SELECT fullname, email, username FROM users WHERE username = :username");
$statement->execute(array(':username' => $username));
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Pengguna tidak ditemukan";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangani perubahan yang dikirim dari form edit profil

    $newFullname = $_POST['fullname'];
    $newEmail = $_POST['email'];
    $newUsername = $_POST['username'];

    // Lakukan validasi jika diperlukan sebelum melakukan perubahan pada database
    // Misalnya, pastikan tidak ada field yang kosong atau lakukan validasi lainnya

    // Update data pengguna ke database
    $updateQuery = "UPDATE users SET fullname = :fullname, email = :email, username = :new_username WHERE username = :username";
    $statement = $pdo->prepare($updateQuery);

    $statement->execute(array(
        ':fullname' => $newFullname,
        ':email' => $newEmail,
        ':new_username' => $newUsername,
        ':username' => $username
    ));

    // Redirect ke halaman profil setelah update
    header("Location: user.php");
    exit();
}
?>