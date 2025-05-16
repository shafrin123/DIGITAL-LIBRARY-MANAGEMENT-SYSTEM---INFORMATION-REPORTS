<?php
session_start();
include 'connect.php';

$today = date('Y-m-d');
$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session

$sql = "SELECT books.title AS book_title, books_issued.due_date 
        FROM books_issued 
        JOIN books ON books_issued.book_id = books.id
        WHERE books_issued.student_id = '$user_id'
        AND books_issued.due_date <= DATE_ADD('$today', INTERVAL 3 DAY)
        AND books_issued.status = 'Issued'";

$result = mysqli_query($conn, $sql);

echo "<h3>📢 Your Due Date Alerts</h3>";
if (mysqli_num_rows($result) > 0) {
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        $due_date = $row['due_date'];
        $alert_msg = ($due_date < $today) ? "❌ Overdue!" : "⚠ Due Soon!";
        echo "<li>{$row['book_title']} (Due: <b style='color:red;'>$due_date</b>) - $alert_msg</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No books due soon.</p>";
}

mysqli_close($conn);
if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('📢 You have books due soon! Check your notifications.');</script>";

    // Send email notification
    $to = $_SESSION['user_email']; // Assuming user email is stored in session
    $subject = "Library Due Date Alert";
    $message = "You have books that are due soon. Please check your library account for details.";
    $headers = "From: library@yourdomain.com";

    mail($to, $subject, $message, $headers);
}
?>