<?php
require '../database/db.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['email'];
} else {
    $username = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectname = $_POST['projectnaam'];
    $bedrijf = $_POST['bedrijf'];
    $opdracht = $_POST['opdracht'];
    $programmeertalen = $_POST['programmeertalen'];
    $startdatum = $_POST['startdatum'];
    $einddatum = $_POST['einddatum'];
    $beschrijving = $_POST['beschrijving'];

    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['thumbnail']['tmp_name'];
        $fileName = $_FILES['thumbnail']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $sanitizedFileName = preg_replace("/[^a-zA-Z0-9._-]/", "_", $fileName);

        if (!in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
            exit();
        }

        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $webPath = '/uploads/' . $sanitizedFileName;
        $fullPath = $uploadDir . $sanitizedFileName;

        if (move_uploaded_file($fileTmpPath, $fullPath)) {
            $thumbnailPath = $webPath; // Use web path for DB
        } else {
            echo "Error uploading file.";
            exit();
        }
    } else {
        $thumbnailPath = null;
    }

    $sql = "INSERT INTO vacatures (title, bedrijf, opdracht, programmeertalen, start_datum, eind_datum, description, thumbnail, creator_email) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssss", $projectname, $bedrijf, $opdracht, $programmeertalen, $startdatum, $einddatum, $beschrijving, $thumbnailPath, $username);

        if (mysqli_stmt_execute($stmt)) {
            echo "Opdracht submitted successfully!";
            echo "<p>Redirecting in 5 seconds...</p>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = '../main-pagina/index.php';
                    }, 5000);
                  </script>";
        } else {
            echo "Error executing query: " . mysqli_error($connection);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query: " . mysqli_error($connection);
    }
}
?>
