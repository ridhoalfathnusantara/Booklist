
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

$username = $_SESSION['username'];

$pdo = new PDO('pgsql:host=localhost;dbname=basdat', 'postgres', 'roufth29');
$statement = $pdo->prepare("SELECT user_id, fullname, email, username FROM users WHERE username = :username");
$statement->execute(array(':username' => $username));
$user = $statement->fetch(PDO::FETCH_ASSOC);

$user_id = $user['user_id']; 

// Count books in Wishlist
$query_count_wishlist = $pdo->prepare("SELECT COUNT(*) AS total_wishlist FROM wishlist WHERE user_id = :user_id");
$query_count_wishlist->execute(array(':user_id' => $user_id));
$result_wishlist = $query_count_wishlist->fetch(PDO::FETCH_ASSOC);
$total_wishlist = $result_wishlist['total_wishlist'];

// Count books in On Going
$query_count_ongoing = $pdo->prepare("SELECT COUNT(*) AS total_ongoing FROM on_going WHERE user_id = :user_id");
$query_count_ongoing->execute(array(':user_id' => $user_id));
$result_ongoing = $query_count_ongoing->fetch(PDO::FETCH_ASSOC);
$total_ongoing = $result_ongoing['total_ongoing'];

// Count books in Completed
$query_count_completed = $pdo->prepare("SELECT COUNT(*) AS total_completed FROM completed WHERE user_id = :user_id");
$query_count_completed->execute(array(':user_id' => $user_id));
$result_completed = $query_count_completed->fetch(PDO::FETCH_ASSOC);
$total_completed = $result_completed['total_completed'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <div class="container">
        <h2>Data Pengguna</h2>
        <div class="user-info">
            <h2><?php echo $user['fullname']; ?></h2>
            <p>Email: <?php echo $user['email']; ?></p>
            <p>Username: <?php echo $user['username']; ?></p>
        </div>
        <div class="edit-user">
            <button onclick="window.location.href='edituser.php'">Edit Profile</button>
        </div>
        <div class="back-btn">
            <iconify-icon icon="icon-park:back" width="35" height="35" onclick="window.location.href='dashboard.php'"></iconify-icon>
        </div>
        <div class="logout-btn">
            <iconify-icon icon="majesticons:logout" width="35" height="35" onclick="window.location.href='logout.php'"></iconify-icon>
        </div>
            <p>User Activity</p>
            <!-- Display Book Counts -->
            <div class="user-activity">
                <p>Jumlah buku yang ingin dibaca: <?php echo $total_wishlist; ?></p>
                <p>Jumlah buku yang sedang dibaca <?php echo $total_ongoing; ?></p>
                <p>Jumlah buku yang selesai dibaca <?php echo $total_completed; ?></p>
            </div>

        </div>
    </div>
    </div>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>
</html>

