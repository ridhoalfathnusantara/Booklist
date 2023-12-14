<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="registrasi.css">
</head>
<body>

    <div class="container">
        <h2>Welcome</h2>
        <div>
        <form action="prosesregistrasi.php" method="post">
            <div class="inputfield">    
                    <input type="text" id="email" name="email" placeholder="Email" required>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    <input type="text" id="fullname" name="fullname" placeholder="Fullname" required>
                    <input type="password" id="pw" name="pw" placeholder="Password" required>
            </div>
            <input type="submit" value="Register" name="register">
        </form>
        </div>
    </div>

</body>
</html>
