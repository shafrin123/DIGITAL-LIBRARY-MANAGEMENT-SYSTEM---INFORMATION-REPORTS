<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Count pending pre-bookings that are NOT expired
$sql = "SELECT COUNT(*) AS count FROM pre_bookings WHERE status = 'pending' AND expired_at > NOW()";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo $row['count'];

$conn->close();
?>
