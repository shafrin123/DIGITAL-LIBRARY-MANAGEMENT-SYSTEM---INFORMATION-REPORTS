<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "login"; // Change this if your DB name is different

$conn = new mysqli($host, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fine rate per day
$fine_per_day = 1.00;

// Today's date
$today = date('Y-m-d');

// Get all books that are still issued
$sql = "SELECT id, due_date FROM book_issues WHERE status = 'issued'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $due_date = $row['due_date'];

        // Check if due_date is in the past
        if ($due_date < $today) {
            // Calculate number of days overdue
            $datetime1 = new DateTime($due_date);
            $datetime2 = new DateTime($today);
            $interval = $datetime1->diff($datetime2);
            $days_overdue = $interval->days;

            $fine = $days_overdue * $fine_per_day;
        } else {
            $fine = 0;
        }

        // Update the fine in the database
        $update_sql = "UPDATE book_issues SET fine_amount = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("di", $fine, $id);
        $stmt->execute();
        $stmt->close();
    }

    echo "✅ Fines calculated and updated.";
} else {
    echo "ℹ️ No issued books found.";
}

$conn->close();
?>
