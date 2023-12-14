<?php
include("config.php");

if (isset($_POST['completed'])) {
    $book_id = $_POST['book_id']; // Menggunakan variabel yang sama

    // Memindahkan data ke tabel on going
    $queryMove = $pdo->prepare("INSERT INTO completed (user_id, judulbuku, penulis, tahunterbit, penerbit) 
                                SELECT user_id, judulbuku, penulis, tahunterbit, penerbit
                                FROM on_going WHERE book_id = :book_id");
    $queryMove->execute(array(':book_id' => $book_id));

    // Menghapus data dari tabel wishlist
    $queryDelete = $pdo->prepare("DELETE FROM on_going WHERE book_id = :book_id");
    $queryDelete->execute(array(':book_id' => $book_id));

    // Redirect kembali ke halaman sebelumnya atau lakukan operasi lain yang diinginkan
    header('Location: dashboard.php');
    exit();
}
?>