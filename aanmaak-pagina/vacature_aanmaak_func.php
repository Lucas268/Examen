<?php
require '../database/db.php';
session_start();


if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['email']; 
} else {
    $username = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectname = $_POST['projectname'];
    $bedrijf = $_POST['bedrijf'];
    $opdracht = $_POST['opdracht'];
    $codetaal = $_POST['codetaal'];
    $soort = $_POST['soort'];
    $startdatum = $_POST['startdatum'];
    $einddatum = $_POST['einddatum'];
    $beschrijving = $_POST['beschrijving'];

    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['thumbnail']['tmp_name'];
        $fileName = $_FILES['thumbnail']['name'];
        $fileSize = $_FILES['thumbnail']['size'];
        $fileType = $_FILES['thumbnail']['type'];


        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $sanitizedFileName = preg_replace("/[^a-zA-Z0-9._-]/", "_", $fileName); // Sanitize file name

        if (!in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
            exit();
        }

        $uploadDir = '../uploads/';  

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
        }

        $uploadFilePath = $uploadDir . $sanitizedFileName;

        if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
            $thumbnailPath = $uploadFilePath;
        } else {
            echo "Error uploading file.";
            exit();
        }
    } else {
        $thumbnailPath = null;
    }

    $sql = "INSERT INTO vacatures (title, bedrijf, opdracht, codetaal, soort, start_datum, eind_datum, description, thumbnail, creator_email) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssssss", $projectname, $bedrijf, $opdracht, $codetaal, $soort, $startdatum, $einddatum, $beschrijving, $thumbnailPath, $username);

        if (mysqli_stmt_execute($stmt)) {
            echo "Opdracht submitted successfully!";
        } else {
            echo "Error executing query: " . mysqli_error($connection);
            file_put_contents('error_log.txt', "Error executing query: " . mysqli_error($connection) . "\n", FILE_APPEND);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query: " . mysqli_error($connection);
        file_put_contents('error_log.txt', "Error preparing query: " . mysqli_error($connection) . "\n", FILE_APPEND);
    }
}
