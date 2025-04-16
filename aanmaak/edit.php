<?php
session_start();
require '../db_connection/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['email'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $bedrijf = $_POST['bedrijf'];
    $soort = $_POST['soort'];
    $programmeertalen = $_POST['programmeertalen'];
    $start_datum = $_POST['start_datum'];
    $eind_datum = $_POST['eind_datum'];
    $description = $_POST['description'];

    // Check ownership
    $stmt = $connection->prepare("SELECT creator_email FROM vacatures WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($creator_email);
    $stmt->fetch();
    $stmt->close();

    if ($_SESSION['email'] !== $creator_email) {
        die("Unauthorized.");
    }

    // Update the database
    $stmt = $connection->prepare("UPDATE vacatures SET title = ?, bedrijf = ?, soort = ?, programmeertalen = ?, start_datum = ?, eind_datum = ?, description = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $title, $bedrijf, $soort, $programmeertalen, $start_datum, $eind_datum, $description, $id);

    if ($stmt->execute()) {
        header("Location: ../main/main.php");
        exit();
    } else {
        echo "Update failed.";
    }
}
?>
