<?php
$hostname = "localhost";
$username = "root";
$password = "extern";     
$dbname = "extern_challenge";

$connection = mysqli_connect($hostname, $username, $password, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}