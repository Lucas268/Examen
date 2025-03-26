<?php
session_start(); // Start the session to access session variables

// Destroy all session data
session_unset(); 
session_destroy(); 

// Redirect to the login page
header("Location: ../../Login_signup/login.php");
exit(); // Ensure no further code is executed after redirect

