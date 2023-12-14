<?php
// Mulai sesi jika belum dimulai
session_start();

// Hapus semua variabel sesi
$_SESSION = array();

// Jika ingin menghapus cookie sesi juga, gunakan kode berikut:
if (ini_get("session.use_cookies")) {
     $params = session_get_cookie_params();
     setcookie(session_name(), '', time() - 42000,
         $params["path"], $params["domain"],
         $params["secure"], $params["httponly"]
     );
 }

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login atau halaman lain yang sesuai
header("Location: index.php");
exit();
?>
