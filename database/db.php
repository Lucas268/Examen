<?php
$hostname = "localhost";
$username = "root";
$password = "Mellewessels1";     
$dbname = "extern_challenge";

$connection = mysqli_connect($hostname, $username, $password, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}