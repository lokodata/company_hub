<?php

$hostname = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "employeedb";

$conn = mysqli_connect($hostname, $dbuser, $dbpassword, $dbname);

// check connection
if ($conn -> connect_error) {
    die("Something went wrong. Connection error: " . $conn->connect_error);
}

?>