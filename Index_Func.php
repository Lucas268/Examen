<?php
require '../database/db.php';
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login_signup/login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_email = $_SESSION['email'];

    $vacature_id = $_POST['vacature_id'];

    $query = "INSERT INTO inschrijvingen (user_email, vacature_id) VALUES (?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("si", $user_email, $vacature_id);

    if ($stmt->execute()) {
        echo "Je bent succesvol ingeschreven!";
    } else {
        echo "Er is iets fout gegaan. Probeer het later opnieuw.";
    }

    $stmt->close();
    $connection->close();
}
