<?php
include("config.php");



if (isset($_POST['edit'])) {
    // Ambil data yang dikirim dari form edit
    $book_id = $_POST['book_id'];
    $judulbuku = $_POST['judulbuku'];
    $penulis = $_POST['penulis'];
    $tahunterbit = $_POST['tahunterbit'];
    $penerbit = $_POST['penerbit'];
    $halaman = $_POST['halaman'];

    // Lakukan query untuk memperbarui data buku di database
    $query = $pdo->prepare("UPDATE on_going SET judulbuku = :judulbuku, penulis = :penulis, tahunterbit = :tahunterbit, penerbit = :penerbit, 
                            halaman = COALESCE(halaman, :halaman) WHERE book_id = :book_id");
    
    // Bind parameter ke query
    $query->bindParam(':judulbuku', $judulbuku);
    $query->bindParam(':penulis', $penulis);
    $query->bindParam(':tahunterbit', $tahunterbit);
    $query->bindParam(':penerbit', $penerbit);
    $query->bindParam(':halaman', $halaman);
    $query->bindParam(':book_id', $book_id);

    // Jalankan query
    $query->execute();

    // Periksa apakah query berhasil dijalankan
    if ($query) {
        // Jika berhasil, arahkan pengguna kembali ke halaman yang sesuai atau tampilkan pesan berhasil
        header("Location: dashboard.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan kesalahan atau lakukan tindakan yang sesuai
        echo "Gagal memperbarui buku. Silakan coba lagi.";
    }
}

?>
