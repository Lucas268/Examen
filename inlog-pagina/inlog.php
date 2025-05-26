<?php
require '../database/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="inlog.css">

</head>
<body>
    <div class="container">
        <h2><strong>LOGIN</strong></h2>
        <form action="inlog_func.php" method="POST">
            <div class="form-group">
                <p style="color: #ffffff;">Login met je vista email</p>
                <input type="email" id="email" name="email" required class="input-field" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" required class="input-field" placeholder="Wachtwoord">
            </div>
            <div class="form-group">
                <button type="submit" class="submit-button">LOGIN</button>
            </div>
        </form>
        <div class="links">
            <a href="#">Wachtwoord vergeten?</a>
            <a href="/accountaanmaak/accountaanmaken.php">Account aanmaken</a>
        </div>
    </div>
</body>
</html>
