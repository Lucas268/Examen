<?php
        require '../db_connection/db.php'
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="auth.css">
    <link rel="icon" type="image/x-icon" href="../Icon.png">
</head>
<body>
    <div class="auth-container">

        <h2>Login</h2>
            <form method="POST" id="signupForm" action="login_func.php">
                <div class="form-group">
                    <label for="email">Email</label>
                    <label>(Gebruik je vista email)</label><br>
                    <input type="text" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="password">Wachtwoord</label><br>
                    <input type="password" id="password" name="password"><br>
                    <a href="sign_up.php">Nog geen account?</a><br><br>
                    
                </div>

            <button type="submit">Login</button>
            </form>
    </div>
</body>
</html>
