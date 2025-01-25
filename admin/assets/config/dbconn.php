<?php
$servername = "localhost";  // Change as needed (use IP or domain name for remote server)
$username = "root";
$password = "";
$dbname = "lgu_health";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>