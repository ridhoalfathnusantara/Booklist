<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

$username = $_SESSION['username'];

$pdo = new PDO('pgsql:host=localhost;dbname=basdat', 'postgres', 'roufth29');
$statement = $pdo->prepare("SELECT user_id FROM users WHERE username = :username");
$statement->execute(array(':username' => $username));
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (isset($_GET['wishlist_id'])) {
    $wishlist_id = $_GET['wishlist_id'];
    $query = $pdo->prepare("SELECT * FROM wishlist WHERE wishlist_id = :wishlist_id");
    $query->execute(array(':wishlist_id' => $wishlist_id));
    $book = $query->fetch(PDO::FETCH_ASSOC);
} else {
    // Jika tidak ada ID buku, kembalikan ke halaman dashboard
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengelolaan buku</title>
    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="dashboard.css">
  </head>
  <body>
    <!-- Heading -->
    <header class="__container__">
      <div class="containerFlex flexSpaceBeetwen">
        <div class="flexItem containerFlex">
          <img src="./asset/Logo 1.png" alt="">
          <h1 class="judulBesar">BOOKLIST</h1>
        </div>
        <div class="flexItemtextRight">
          <h2>Edit Buku <?php echo $_SESSION['username']; ?>!</h2>
          <div class="user">
            <a href="user.php">
              <img src="./asset/profile.png"  alt="Profile" class="mr_0" /> 
           </a>
          </div>
        </div>
      </div>
    </header>

    <!-- Main -->
    <main>
      <div class="__container__">
        <!-- Tools -->
        <section>
          <div class="toolBar mt_1 containerFlex flexSpaceBeetwen">
            <div>
             
            </div>
            <div class="toolsBarGroup">
              <input type="text" class="inputText mr_1" id="querySearch" placeholder="Cari Buku ..." hidden>
              <button class="buttonSearchBook" type="button" id="buttonSearch" hidden>
                  <ion-icon name="search"></ion-icon>
              </button>
            </div>
          </div>
        </section>
        <!-- Form Buku -->
        <section>
          <form id="formBuku" action="proseseditbuku.php" method="POST">
              <h2>Form Buku</h2>
              <input type="hidden" id="bukuId" name="wishlist_id"  value="<?php echo $book['wishlist_id']; ?>"/>
              <div class="formGrouping">
                <label>Judul Buku</label>
                <input type="text" class="inputText" id="inputJudulBuku" name="judulbuku"  value="<?php echo $book['judulbuku']; ?>"required />
              </div>
              <div class="formGrouping">
                <label>Penulis</label>
                <input type="text" class="inputText" id="inputPenulisBuku" name="penulis"  value="<?php echo $book['penulis']; ?>"required />
              </div>
              <div class="formGrouping">
                <label>Tahun Terbit</label>
                <input type="number" class="inputText" id="inputTahunTerbit" name="tahunterbit"  value="<?php echo $book['tahunterbit']; ?>"required />
              </div>
              <div class="formGrouping">
                <label>Penerbit</label>
                <input type="text" class="inputText" id="inputPenerbit" name="penerbit"  value="<?php echo $book['penerbit']; ?>"required />
              </div>
              <div class="formGrouping">
                <label hidden>Sudah Selesai Dibaca </label>
                <input type="checkbox" class="custom" id="inputBukuSelesaiBaca"  hidden/>
              </div>
              <div class="formGrouping">
                <label for="priorityWishlist">Prioritas</label>
                <select id="priorityWishlist" class="prioritySelect" name="skalaprioritas"  value="<?php echo $book['skalaprioritas']; ?>">
                  <option value="low">Rendah</option>
                  <option value="medium">Sedang</option>
                  <option value="high">Tinggi</option>
                </select>
              </div>
              <div class="mt_1 textRight">
                <button id="buttonDiscard" class="button buttonHapus" type="button" hidden>
                  Tutup
                </button>
                <button class="button buttonSimpan" type="submit" name="edit">
                  Update
                </button>
              </div>
            </form>
          </div>
        </section>