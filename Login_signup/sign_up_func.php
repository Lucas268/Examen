<?php
require '../db_connection/db.php'; // Ensure the database connection is included

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure data is coming through
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        echo json_encode(['success' => false, 'error' => 'Missing email or password']);
        exit;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email pattern
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@vistacollege\.nl$/", $email)) {
        echo json_encode(['success' => false, 'error' => 'Invalid email format. Please use @vistacollege.nl']);
        exit;
    }

    // Check if email already exists
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

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query to insert the user
    $query = "INSERT INTO users (email, password, role) VALUES (?, ?, 0)";
    $stmt = mysqli_prepare($connection, $query);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => 'Database prepare statement failed']);
        exit;
    }

    // Bind the parameters and execute the query
    mysqli_stmt_bind_param($stmt, 'ss', $email, $hashed_password);
    $result = mysqli_stmt_execute($stmt);

    // Check if insertion was successful
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to insert data: ' . mysqli_error($connection)]);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
    header("Location: ../Login_signup/login.php");
}
?>
<script>
    setTimeout(function() {
        window.location.href = '../main/main.php';
    }, 3000); // 3000 milliseconds = 3 seconds
</script>
