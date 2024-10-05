<?php

$database_host = "localhost";
$database_user = "root";
$database_pass = "";
$database_name = "hospital-management-system";
$database_port = 3306;

$conn = mysqli_connect($database_host, $database_user, $database_pass, $database_name, $database_port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
