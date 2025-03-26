<?php
require '../db_connection/db.php'; // Ensure the database connection is included
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="auth.css">
    <link rel="icon" type="image/x-icon" href="../Icon.png">
    
</head>
<body>
    <div class="auth-container">
        <h1>Sign Up</h1>
        <form method="POST" id="signupForm" action="sign_up_func.php"> <!-- Form submits to sign_up_func.php -->
            <div class="form-group">
                <label for="email">Email</label><br><label>Gebruik je vista email</label><br>
                <input type="email" id="email" name="email" required pattern="^[a-zA-Z0-9._%+-]+@vistacollege\.nl$" title="Email must end with @vistacollege.nl">
            </div>
            <div class="form-group">
                <label for="password">Wachtwoord</label><br>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>
