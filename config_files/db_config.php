<?php

$host       = "localhost";
$username   = "root";
$password   = "";
$dbname     = "coldb";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("MYSQL Connection failed: " . $conn->connect_error);
} 

?>