<?php
include("config.php");

if (isset($_POST['ongoing'])) {
    $wishlist_id = $_POST['wishlist_id']; // Menggunakan variabel yang sama

    // Memindahkan data ke tabel on going
    $queryMove = $pdo->prepare("INSERT INTO on_going (user_id, judulbuku, penulis, tahunterbit, penerbit) 
                                SELECT user_id, judulbuku, penulis, tahunterbit, penerbit
                                FROM wishlist WHERE wishlist_id = :wishlist_id");
    $queryMove->execute(array(':wishlist_id' => $wishlist_id));

    // Menghapus data dari tabel wishlist
    $queryDelete = $pdo->prepare("DELETE FROM wishlist WHERE wishlist_id = :wishlist_id");
    $queryDelete->execute(array(':wishlist_id' => $wishlist_id));

    // Redirect kembali ke halaman sebelumnya atau lakukan operasi lain yang diinginkan
    header('Location: dashboard.php');
    exit();
}
?>
