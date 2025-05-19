<?php
$hostname = "localhost";
$username = "claidicarabas";
$password = "zu888R7u$";     
$dbname = "externe_challenge";

$connection = mysqli_connect($hostname, $username, $password, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}