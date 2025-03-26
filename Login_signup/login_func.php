<?php
require '../db_connection/db.php'; // Include the database connection
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect and sanitize form data
    $email = !empty($_POST['email']) ? $_POST['email'] : NULL;
    $password = !empty($_POST['password']) ? $_POST['password'] : NULL;

    try {
        // Check if the email exists in the database
        $stmt = $connection->prepare("SELECT id, password FROM users WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email); // Bind the email parameter
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Email exists, verify the password
                $stmt->bind_result($userId, $hashedPassword);
                $stmt->fetch();

                if (password_verify($password, $hashedPassword)) {
                    // Password is correct, start a session
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['email'] = $email;

                    echo "Login successful! Redirecting...";
                    header("Location: ../main/main.php");
                    exit();
                } else {
                    // Invalid password
                    echo "Invalid email or password.";
                }
            } else {
                // Email does not exist
                echo "Invalid email or password.";
            }

            $stmt->close(); // Close the statement
        } else {
            die("Error preparing statement: " . $connection->error);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage(); // This will print the exact error message
    }
}
