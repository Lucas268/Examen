<?php
require '../db_connection/db.php'; // Include the database connection
session_start(); // Start the session to check login status

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Login_signup/login.php");
    exit();
}

// Check if the ID is provided via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['opdrachtId'])) {
    $opdrachtId = $_POST['opdrachtId'];

    // Prepare the SQL statement to delete the record
    $stmt = $connection->prepare("DELETE FROM vacatures WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $opdrachtId); // Bind the ID parameter
        if ($stmt->execute()) {
            echo "Opdracht successfully deleted!";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
        $stmt->close(); // Close the statement
    } else {
        die("Error preparing statement: " . $connection->error);
    }
} else {
    echo "Invalid request.";
}
?>
<script>
    setTimeout(function() {
        window.location.href = '../main/main.php';
    }, 3000); // 3000 milliseconds = 3 seconds
</script>
