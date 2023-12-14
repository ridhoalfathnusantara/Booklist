<?php



include("config.php");

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: user.php");
    exit();
}
$username = $_SESSION['username'];



$pdo = new PDO('pgsql:host=localhost;dbname=basdat', 'postgres', 'roufth29');
$statement = $pdo->prepare("SELECT fullname, email, username FROM users WHERE username = :username");
$statement->execute(array(':username' => $username));
$user = $statement->fetch(PDO::FETCH_ASSOC);

?>  

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <link rel="stylesheet" href="edituser.css">
</head>
<body>
  <div class="container">
  <h2>Edit Profile</h2>
     <form method="post" action="prosesedit.php">
        <label for="fullname">Fullname:</label>
        <input type="text" id="fullname" name="fullname" value="<?php echo $user['fullname']; ?>"><br><br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>"><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br><br>
        <div class="btn-edit">
          <input type="submit" value="Update Profile">
        </div>
  </form>
  </div>
</body>
</html>

