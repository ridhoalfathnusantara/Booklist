<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

$username = $_SESSION['username'];

$pdo = new PDO('pgsql:host=localhost;dbname=basdat', 'postgres', 'roufth29');
$statement = $pdo->prepare("SELECT user_id FROM users WHERE username = :username");
$statement->execute(array(':username' => $username));
$user = $statement->fetch(PDO::FETCH_ASSOC);

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
          <h2>Selamat datang, <?php echo $_SESSION['username']; ?>!</h2>
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
              <input type="text" class="inputText mr_1" id="querySearch" placeholder="Cari Buku ..." name="querySearch" hidden>
              <button class="buttonSearchBook" type="submit" id="buttonSearch" hidden>
                  <ion-icon name="search" ></ion-icon>
              </button>
            </div>
          </div>
        </section>
        <!-- Form Buku -->
        <section>
          
            <form id="formBuku" action="tambahwishlist.php" method="POST">
              <h2>Form Buku</h2>
              <input type="hidden" id="bukuId" name="wishlist_id" />
              <div class="formGrouping">
                <label>Judul Buku</label>
                <input type="text" class="inputText" id="inputJudulBuku" name="judulbuku" required />
              </div>
              <div class="formGrouping">
                <label>Penulis</label>
                <input type="text" class="inputText" id="inputPenulisBuku" name="penulis" required />
              </div>
              <div class="formGrouping">
                <label>Tahun Terbit</label>
                <input type="number" class="inputText" id="inputTahunTerbit" name="tahunterbit" required />
              </div>
              <div class="formGrouping">
                <label>Penerbit</label>
                <input type="text" class="inputText" id="inputPenerbit" name="penerbit" required />
              </div>
              <div class="formGrouping">
                <label hidden>Sudah Selesai Dibaca </label>
                <input type="checkbox" class="custom" id="inputBukuSelesaiBaca"  hidden/>
              </div>
              <div class="formGrouping">
                <label for="priorityWishlist">Prioritas</label>
                <select id="priorityWishlist" class="prioritySelect" name="skalaprioritas">
                  <option value="low">low</option>
                  <option value="mid">mid</option>
                  <option value="high">high</option>
                </select>
              </div>
              <div class="mt_1 textRight">
                <button id="buttonDiscard" class="button buttonHapus" type="button" hidden>
                  Tutup
                </button>
                <button class="button buttonSimpan" type="submit" name="simpan">
                  Simpan
                </button>
              </div>
            </form>
          </div>
        </section>
        <!-- List Buku 1 wihlist-->
        <section>
                <div class="table1-section">
                  <h2>Wishlist</h2>
                  <table border="1" action="on_going.php">
                    <thead>
                      <tr>
                        <th width="300">Judul Buku</th>
                        <th width="150">Penulis</th>
                        <th width="100">Tahun Terbit</th>
                        <th width="100">Penerbit</th>
                        <th width="100">Skala Prioritas</th>
                        <th width="200">Tindakan</th>
                      </tr>
                   </thead>
                   <tbody>
                   <?php
                      $user_id = $user['user_id'];

                      $query = $pdo->prepare("SELECT * FROM wishlist WHERE user_id = :user_id");
                      $query->execute(array(':user_id' => $user_id));
                        
                      while($data = $query->fetch(PDO::FETCH_ASSOC)){
                          echo "<tr>";
                          echo "<td>".$data['judulbuku']."</td>";
                          echo "<td>".$data['penulis']."</td>";
                          echo "<td>".$data['tahunterbit']."</td>";
                          echo "<td>".$data['penerbit']."</td>";
                          echo "<td>".$data['skalaprioritas']."</td>";
                          echo "<td>";
                          echo "<form action='editbuku.php' method='GET'>";
                          echo "<input type='hidden' name='wishlist_id' value='".$data['wishlist_id']."'>";
                          echo "<input type='submit' class='edit' value='Edit' name='editbuku'><br>";
                          echo "</form>";
                          echo "<form action='hapusbuku.php' method='POST'>";
                          echo "<input type='hidden' name='wishlist_id' value='".$data['wishlist_id']."'>";
                          echo "<input type='submit' class='hapus' value='Hapus' name='hapus_wishlist'><br>";
                          echo "</form>";
                          echo "<form action='on_going.php' method='POST'>";
                          echo "<input type='hidden' name='wishlist_id' value='".$data['wishlist_id']."'>";
                          echo "<input type='submit' class='submit' value='On Going' name='ongoing'>";  
                          echo "</form>";
                          echo "</td>";
                          echo "</tr>";
                          }
                          ?>
                    </tbody>
                  </table>
                </div>
        </section> 

        <!-- List Buku 2 ongoing-->
        <section>
                <div class="table2-section">
                  <h2>On Going</h2>
                  <table border="1">
                    <thead>
                      <tr>
                        <th width="300">Judul Buku</th>
                        <th width="150">Penulis</th>
                        <th width="100">Tahun Terbit</th>
                        <th width="100">Penerbit</th>
                        <th width="100">Halaman</th>
                        <th width="200">Tindakan</th>
                      </tr>
                   </thead>
                   <tbody>
                   <?php
                       $user_id = $user['user_id']; 

                       $query = $pdo->prepare("SELECT * FROM on_going WHERE user_id = :user_id");
                       $query->execute(array(':user_id' => $user_id));

                        while($data = $query->fetch(PDO::FETCH_ASSOC)){
                         echo "<tr>";
                         echo "<td>".$data['judulbuku']."</td>";
                         echo "<td>".$data['penulis']."</td>";
                         echo "<td>".$data['tahunterbit']."</td>";
                         echo "<td>".$data['penerbit']."</td>";
                         echo "<td>".$data['halaman']."</td>";
                         echo "<td>";
                         echo "<form action='editongoing.php' method='GET'>";
                         echo "<input type='hidden' name='book_id' value='".$data['book_id']."'>";
                         echo "<input type='submit' class='edit' value='Edit' name='editongoing'><br>";
                         echo "</form>";
                         echo "<form action='hapusbuku.php' method='POST'>";
                          echo "<input type='hidden' name='book_id' value='".$data['book_id']."'>";
                          echo "<input type='submit' value='Hapus' name='hapus_ongoing'><br>";
                          echo "</form>";  
                         echo "<form action='completed.php' method='POST'>";
                         echo "<input type='hidden' name='book_id' value='".$data['book_id']."'>";
                         echo "<input type='submit' value='completed' name='completed'>";  
                         echo "</form>";
                         echo "</td>";
                         echo "</tr>";
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
        </section> 

        <!-- List Buku 3 completed-->
        <section>
                <div class="table3-section">
                  <h2>Completed</h2>
                  <table border="1">
                    <thead>
                      <tr>
                        <th width="300">Judul Buku</th>
                        <th width="150">Penulis</th>
                        <th width="150">Tahun Terbit</th>
                        <th width="150">Penerbit</th>
                        <th width="200">Tindakan</th>
                      </tr>
                   </thead>
                   <tbody>
                   <?php
                       $user_id = $user['user_id']; 

                       $query = $pdo->prepare("SELECT * FROM completed WHERE user_id = :user_id");
                       $query->execute(array(':user_id' => $user_id));

                       //buku yang udah dibaca
                       $query_count = $pdo->prepare("SELECT COUNT(*) AS total_completed FROM completed WHERE user_id = :user_id");
                       $query_count->execute(array(':user_id' => $user_id));
                       $result = $query_count->fetch(PDO::FETCH_ASSOC);
                       $total_completed = $result['total_completed'];
       
                        while($data = $query->fetch(PDO::FETCH_ASSOC)){
                         echo "<tr>";
                         echo "<td>".$data['judulbuku']."</td>";
                         echo "<td>".$data['penulis']."</td>";
                         echo "<td>".$data['tahunterbit']."</td>";
                         echo "<td>".$data['penerbit']."</td>";
            
                         echo "<td>";
                         echo "<form action='hapusbuku.php' method='POST'>";
                          echo "<input type='hidden' name='book_id' value='".$data['book_id']."'>";
                          echo "<input type='submit' value='Hapus' name='hapus_completed'><br>"; 
                          echo "</form>";
                        
                         echo "</form>";
                         echo "</td>";
                         echo "</tr>";
                       }
                       
                        

                      ?>
                    </tbody>
                  </table>
                </div>
        </section> 
      </div>
    </main>
    <script src="dashboard.js"></script>
    <script src="chart.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  </body>
</html>




