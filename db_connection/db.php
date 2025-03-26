<?php
$hostname = "localhost";
$username = "extern";
$password = "extern";     
$dbname = "externe_challenge";

$connection = mysqli_connect($hostname, $username, $password, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}





