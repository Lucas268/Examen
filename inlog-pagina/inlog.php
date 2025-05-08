<?php
require '../database/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./inlog.css">
</head>
<body>
    <main id="login-container">
        <section id="group25" class="group25">
            <h1 id="login" class="login">LOGIN</h1>
            <form action="inlog_func.php" method="POST">
                <p id="loginmetjevistaemail" class="loginmetjevistaemail">Login met je vista email</p>
                <label id="wachtwoord" class="wachtwoord" for="email">Email</label>
                <input type="email" id="email" name="email" class="password-input" required>
                <label id="wachtwoord" class="wachtwoord" for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" class="password-input" required>
                <button type="submit" class="rectangle14">Login</button>
            </form>
            <a id="wachtwoordvergeten" class="wachtwoordvergeten" href="#">Wachtwoord vergeten?</a>
            <a id="accountaanmaken" class="accountaanmaken" href="/accountaanmaak/accountaanmaken.php">Account aanmaken</a>
        </section>
    </main>
</body>
</html>
