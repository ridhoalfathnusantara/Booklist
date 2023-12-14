
<!DOCTYPE html>
<html>
<head>
    <title>Halaman Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="container">
        <h2>Welcome Back</h2>
        <div>
        <form action="proseslogin.php" method="post">
            <div class="inputfield">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    <input type="password" id="pw" name="pw" placeholder="Password" required>
            </div>
            <button class="loginbtn" value ="login">Login</button>
            <div class="buttoncontent">
                <p>Belum punya akun ? </p>
                <a href="registrasi.php" class="signupbtn">Sign Up</a>
          
            </div>
        </form>
        </div>
    </div>
    <div class="icon">
        <img src="booklist.png" alt="booklist">
    </div>
    
    
</body>
</html>
