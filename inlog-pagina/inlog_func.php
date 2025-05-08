<?php
require '../database/db.php'; 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = !empty($_POST['email']) ? $_POST['email'] : NULL;
    $password = !empty($_POST['password']) ? $_POST['password'] : NULL;

    try {
        $stmt = $connection->prepare("SELECT id, password FROM users WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($userId, $hashedPassword);
                $stmt->fetch();

                if (password_verify($password, $hashedPassword)) {
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['email'] = $email;

                    error_log("✅ Login successful for $email");
                    header("Location: /main-pagina/index.php");
                    exit();
                } else {
                    echo "Invalid email or password.";
                }
            } else {
                echo "Invalid email or password.";
            }
            $stmt->close();
        } else {
            die("Error preparing statement: " . $connection->error);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}