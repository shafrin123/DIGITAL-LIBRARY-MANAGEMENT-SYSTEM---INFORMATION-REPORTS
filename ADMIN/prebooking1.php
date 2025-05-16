<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookingId = $_POST['booking_id'];

    // Mark booking as seen
    $stmt = $conn->prepare("UPDATE pre_bookings SET status = 'seen' WHERE id = ?");
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// Redirect back to admin page
header("Location: dash.php");
exit();
?>
