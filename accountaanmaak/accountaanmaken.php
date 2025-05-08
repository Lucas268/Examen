<?php
require '../database/db.php';
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
    <main id="login-container">
        <section id="group25" class="group25">
            <h1 id="accountaanmaken" class="login">Account Aanmaken</h1>
            <form action="accountaanmaken.php" method="POST">
                <p id="registreermetjevistaemail" class="loginmetjevistaemail">Registreer met je vista email</p>
                <label for="email" class="wachtwoord">Email</label>
                <input type="email" id="email" name="email" class="password-input" placeholder="Voer je email in" required>
                <label for="password" class="wachtwoord">Wachtwoord</label>
                <input type="password" id="password" name="password" class="password-input" placeholder="Voer je wachtwoord in" required>
                <label for="confirm-password" class="wachtwoord">Bevestig Wachtwoord</label>
                <input type="password" id="confirm-password" name="confirm-password" class="password-input" placeholder="Bevestig je wachtwoord" required>
                <button type="submit" class="rectangle14">Account Aanmaken</button>
            </form>
            <a id="terugnaarinloggen" class="wachtwoordvergeten" href="/inlog-pagina/inlog.php">Terug naar inloggen</a>
        </section>
    </main>
</body>
</html>
