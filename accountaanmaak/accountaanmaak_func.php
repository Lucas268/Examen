<?php
require '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        echo json_encode(['success' => false, 'error' => 'Missing email or password']);
        exit;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!preg_match("/^[a-zA-Z0-9._%+-]+@vistacollege\.nl$/", $email)) {
        echo json_encode(['success' => false, 'error' => 'Invalid email format. Please use @vistacollege.nl']);
        exit;
    }

    $check_query = "SELECT COUNT(*) AS count FROM users WHERE email = ?";
    $check_stmt = mysqli_prepare($connection, $check_query);
    if ($check_stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Database prepare statement failed']);
        exit;
    }

    mysqli_stmt_bind_param($check_stmt, 's', $email);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
        echo json_encode(['successfuly' => false, 'error' => 'Email already exists']);
        mysqli_stmt_close($check_stmt);
        exit;
    }
    mysqli_stmt_close($check_stmt);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (email, password, role) VALUES (?, ?, 0)";
    $stmt = mysqli_prepare($connection, $query);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Database prepare statement failed']);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'ss', $email, $hashed_password);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Start a session and set session variables for the user
        session_start();
        $_SESSION['user_id'] = mysqli_insert_id($connection); // Get the last inserted user ID
        $_SESSION['email'] = $email; // Store email in session

        // Redirect the user to the main page after successful registration
        header("Location: ../index.php");
        exit();
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to insert data: ' . mysqli_error($connection)]);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}
?>
