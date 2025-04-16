<?php
require '../db_connection/db.php'; // Include database connection
session_start(); // Start the session to check login status

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['email']; // Assuming email is stored in session
} else {
    $username = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gather POST data (excluding the thumbnail for now)
    $projectname = $_POST['projectname'];
    $bedrijf = $_POST['bedrijf'];
    $opdracht = $_POST['opdracht'];
    $programmeertalen = $_POST['programmeertalen'];
    $soort = $_POST['soort'];
    $startdatum = $_POST['startdatum'];
    $einddatum = $_POST['einddatum'];
    $beschrijving = $_POST['beschrijving'];

    // Check if the thumbnail file is uploaded
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        // Get file info
        $fileTmpPath = $_FILES['thumbnail']['tmp_name'];
        $fileName = $_FILES['thumbnail']['name'];
        $fileSize = $_FILES['thumbnail']['size'];
        $fileType = $_FILES['thumbnail']['type'];

        // Get file extension and sanitize the file name
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $sanitizedFileName = preg_replace("/[^a-zA-Z0-9._-]/", "_", $fileName); // Sanitize file name

        // Ensure the file is of an acceptable type (JPG, PNG, GIF, etc.)
        if (!in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
            exit();
        }

        // Define the upload directory
        $uploadDir = '../uploads/';  // Using the correct uploads directory

        // Ensure the directory exists, create if it doesn't
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
        }

        // Define the full file path
        $uploadFilePath = $uploadDir . $sanitizedFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
            // If file is uploaded successfully, store the file path in the database
            $thumbnailPath = $uploadFilePath;
        } else {
            echo "Error uploading file.";
            exit();
        }
    } else {
        // If no file is uploaded, set $thumbnailPath to NULL or handle accordingly
        $thumbnailPath = null;
    }

    // Add the insert query to insert data into the database
    $sql = "INSERT INTO vacatures (title, bedrijf, opdracht, programmeertalen, soort, start_datum, eind_datum, description, thumbnail, creator_email) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        // Bind parameters (including the thumbnail path)
        mysqli_stmt_bind_param($stmt, "ssssssssss", $projectname, $bedrijf, $opdracht, $programmeertalen, $soort, $startdatum, $einddatum, $beschrijving, $thumbnailPath, $username);

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
?>

<script>
    setTimeout(function() {
        window.location.href = '../main/main.php';
    }, 3000); // Redirect after 3 seconds
</script>
