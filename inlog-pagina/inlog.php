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
    <style>
        body {
            background-color: #d3d3d3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #2f5d5d;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }

        .container h2 {
            color: #ffffff;
            margin-bottom: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .form-group label {
            color: #ffffff;
            font-size: 0.9rem;
        }

        .input-field {
            padding: 0.5rem;
            border: none;
            border-radius: 20px;
            background-color: #d3cfcf;
            text-align: center;
        }

        .submit-button {
            padding: 0.7rem;
            border: none;
            border-radius: 20px;
            background-color: #d3cfcf;
            color: #2f5d5d;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
        }

        .submit-button:hover {
            background-color: #c2baba;
        }

        .links {
            margin-top: 1rem;
        }

        .links a {
            color: #ffffff;
            font-size: 0.8rem;
            text-decoration: none;
            display: block;
            margin-top: 0.5rem;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
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
