<?php
require '../database/db.php'; 
require 'accountaanmaak_func.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Aanmaken</title>
    <link rel="stylesheet" href="./aanmaak.css">
</head>
<body>
    <div class="container">
        <h1><strong>Account Aanmaken</strong></h1>
        <form action="accountaanmaken.php" method="POST">
            <div class="form-group">
                <p style="color: #ffffff;">Registreer met je vista email</p>
                <input type="email" id="email" name="email" class="input-field" placeholder="Voer je email in" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" class="input-field" placeholder="Voer je wachtwoord in" required>
            </div>
            <div class="form-group">
                <input type="password" id="confirm-password" name="confirm-password" class="input-field" placeholder="Bevestig je wachtwoord" required>
            </div>
            <div class="form-group">
                <button type="submit" class="submit-button">Account Aanmaken</button>
            </div>
        </form>
        <div class="links">
            <a href="/inlog-pagina/inlog.php">Terug naar inloggen</a>
        </div>
    </div>
</body>
</html>
