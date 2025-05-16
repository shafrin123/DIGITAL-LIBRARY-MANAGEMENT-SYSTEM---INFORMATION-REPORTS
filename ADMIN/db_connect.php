<?php
$host = "localhost";  // Change if your DB is hosted elsewhere
$user = "root";       // Change to your DB username
$pass = "";           // Change to your DB password
$dbname = "login"; // Change to your DB name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
