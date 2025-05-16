<?php
include 'db_connection.php';  // Include the database connection file

$today = date('Y-m-d');  // Get today's date
$fine_per_day = 10;  // Fine amount per day for overdue books

// Update fine for overdue books that are still issued
$sql = "UPDATE books_issued 
        SET fine_amount = (DATEDIFF('$today', due_date) * $fine_per_day) 
        WHERE due_date < '$today'  // Only overdue books
        AND return_date IS NULL  // Books that have not been returned
        AND status = 'Issued'";  // Books that are still issued

// Execute the update query and check if it was successful
if (mysqli_query($conn, $sql)) {
    echo "Fine updated successfully.";
} else {
    echo "Error updating fine: " . mysqli_error($conn);  // Error message if the query fails
}

mysqli_close($conn);  // Close the database connection

/*
LearnWebCoding
-Command-line PHP execution
-Command-line MySQL execution
-Command line Databse Backup and restore in MySQL
-Database backup script in PHP
-Setup Cron Job in Windows using task schedular
*/

*****Execute php*****
php filename.php;

*****Database backup***** *
C:\xampp\mysql\bin\mysqldump.exe -uroot pagination >
d:\tutorials\command-line\pagination_db_backup.sql

*****Database Restore*****
mysql -uroot cmddb <
?>