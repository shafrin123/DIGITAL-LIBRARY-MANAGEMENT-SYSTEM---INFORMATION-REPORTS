<?php
date_default_timezone_set('Asia/Kolkata'); // Set timezone

// Database credentials
$host = "localhost";
$user = "root";  // Change if needed
$password = "";  // Change if needed
$database = "login"; // Change to your database name
$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ===================== 1. CHECK OVERDUE BOOKS & ADD FINES =====================
$fine_per_day = 10; // Fine amount per day
$current_date = date("Y-m-d");

$sql = "SELECT * FROM book_issues WHERE return_date < '$current_date' AND status = 'Issued'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $user_id = $row['student_id'];
    $book_id = $row['id'];
    $return_date = $row['return_date'];

    // Calculate overdue days and fine amount
    $days_overdue = (int) ceil((strtotime($current_date) - strtotime($return_date)) / (60 * 60 * 24));
    if ($days_overdue > 0) {
        $fine_amount = $days_overdue * $fine_per_day;

        // Update the fine in the database
        $update_query = "UPDATE book_issues SET fine_amount = '$fine_amount' WHERE id = '$book_id' AND student_id = '$user_id'";
        if (!mysqli_query($conn, $update_query)) {
            echo "Error updating fine for Book ID: $book_id, Student ID: $user_id - " . mysqli_error($conn);
        }

        // Send notification to user
        //mysqli_query($conn, "INSERT INTO notifications (user_id, message) VALUES ('$user_id', 'Your book (ID: $book_id) is overdue! Fine amount: ₹$fine_amount')");
    }
}

// ===================== 2. DATABASE BACKUP =====================
$backup_folder = __DIR__ . "/sql_backup/"; // Existing backup folder
$additional_backup_folder = "C:/xampp/htdocs/data_backup/"; // New backup folder

// Ensure both backup folders exist
if (!file_exists($backup_folder)) {
    mkdir($backup_folder, 0777, true);
}
if (!file_exists($additional_backup_folder)) {
    mkdir($additional_backup_folder, 0777, true);
}

// Backup file name
$backup_file = "backup_" . date("Y-m-d_H-i-s") . ".sql";

// Run mysqldump command for the first backup folder
$command1 = "mysqldump --host=$host --user=$user --password=$password $database > \"$backup_folder$backup_file\"";
exec($command1, $output1, $return_var1);

// Run mysqldump command for the additional backup folder
$command2 = "mysqldump --host=$host --user=$user --password=$password $database > \"$additional_backup_folder$backup_file\"";
exec($command2, $output2, $return_var2);

if ($return_var1 === 0 && $return_var2 === 0) { // Check return status for both backups
    echo "✅ Fine updated & Backup successful: $backup_folder$backup_file and $additional_backup_folder$backup_file";
} else {
    echo "❌ Backup failed!";
}

// Close the database connection
mysqli_close($conn);
?>