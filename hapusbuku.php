<?php
include("config.php");

$user_id = $user['user_id'];

// Penghapusan dari tabel Wishlist
if(isset($_POST['hapus_wishlist'])) {
    $wishlist_id = $_POST['wishlist_id'];

    $query_delete_wishlist = $pdo->prepare("DELETE FROM wishlist WHERE wishlist_id = :wishlist_id");
    $query_delete_wishlist->execute(array(':wishlist_id' => $wishlist_id));

    // Handle tindakan setelah penghapusan wishlist
    // Contoh: Redirect ke halaman setelah penghapusan
    if ($query_delete_wishlist) {
        header("Location: dashboard.php"); 
        exit();
    } else {
        echo "Gagal menghapus dari Wishlist.";
    }
}

// Penghapusan dari tabel On Going
if(isset($_POST['hapus_ongoing'])) {
    $book_id = $_POST['book_id'];

    $query_delete_on_going = $pdo->prepare("DELETE FROM on_going WHERE book_id = :book_id");
    $query_delete_on_going->execute(array(':book_id' => $book_id));

    // Handle tindakan setelah penghapusan on going
    // Contoh: Redirect ke halaman setelah penghapusan
    if ($query_delete_on_going) {
        header("Location: dashboard.php"); 
        exit();
    } else {
        echo "Gagal menghapus dari On Going.";
    }
}

// Penghapusan dari tabel Completed
if(isset($_POST['hapus_completed'])) {
    $book_id = $_POST['book_id'];

    $query_delete_completed = $pdo->prepare("DELETE FROM completed WHERE book_id = :book_id");
    $query_delete_completed->execute(array(':book_id' => $book_id));

    // Handle tindakan setelah penghapusan completed
    // Contoh: Redirect ke halaman setelah penghapusan
    if ($query_delete_completed) {
        header("Location: dashboard.php"); 
        exit();
    } else {
        echo "Gagal menghapus dari Completed.";
    }
}
?>
