<?php
require '../db_connection/db.php'; // Include your database connection
session_start(); // Start the session to check login status

if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect them to the login page
    header("Location: ../../login_signup/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the logged-in user's email from the session
    $user_email = $_SESSION['email'];

    // Get the vacature ID from the POST data
    $vacature_id = $_POST['vacature_id'];

    // Insert the user's sign-up into the database
    $query = "INSERT INTO inschrijvingen (user_email, vacature_id) VALUES (?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("si", $user_email, $vacature_id);

    if ($stmt->execute()) {
        echo "Je bent succesvol ingeschreven!";
    } else {
        echo "Er is iets fout gegaan. Probeer het later opnieuw.";
    }

    // Close the statement and connection
    $stmt->close();
    $connection->close();
}

