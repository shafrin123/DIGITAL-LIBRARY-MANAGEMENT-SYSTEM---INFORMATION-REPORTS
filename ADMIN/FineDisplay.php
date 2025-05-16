<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Dash.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Admin Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h3 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
        text{
            text-align: center;
            margin-left: 50%;
        }
    </style>
    
</head>
<body> 
    <!-- Include Boxicons -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="logo-name"></div>
        <div class="menu-items">
            <ul class="nav-links">
            <li><a href="Dash.php"><i class="bx bx-home"></i><span class="link-name">Dashboard</span></a></li>
                <li><a href="Student Reg.php"><i class="bx bx-user-plus"></i><span class="link-name">Student Registration</span></a></li>
                <li><a href="Staff.php"><i class="bx bx-user"></i><span class="link-name">Staff Registration</span></a></li>
                <li><a href="Book Reg.php"><i class="bx bx-book-add"></i><span class="link-name">Book Registration</span></a></li>
                <li><a href="BookAvail.php"><i class="bx bx-book"></i><span class="link-name">Book Availability</span></a></li>
                <li><a href="Bookissue.php"><i class="bx bx-book-reader"></i><span class="link-name">Book Issue</span></a></li>
                <li><a href="BookReturn.php"><i class="bx bx-file"></i><span class="link-name">Book Return</span></a></li>
                <li><a href="Book Report.php"><i class="bx bx-file"></i><span class="link-name">Book Report</span></a></li>
                <li><a href="Student Info.php"><i class="bx bx-group"></i><span class="link-name">Student Info</span></a></li>
                <li><a href="Staff Info.php"><i class="bx bx-id-card"></i><span class="link-name">Staff Info</span></a></li>
                <li><a href="Book Info.php"><i class="bx bx-id-card"></i><span class="link-name">Book Info</span></a></li>
                <li><a href="FineDisplay.php"><i class="bx bx-money"></i><span class="link-name">Fine Details</span></a></li>
                <li>
                    <a href="prebooking.php">
                        <i class="bx bx-notification"></i>
                        <span class="link-name">Notification</span>
                        <span class="badge" id="notificationCount" style="display: none;">0</span>
                    </a>
                </li>
               
                <li><a href="profile.php"><i class="bx bx-user-circle"></i><span class="link-name">My Account</span></a></li>
            </ul>
        </div>
        <i class="bx bx-menu sidebar-toggle"></i>
    </nav>
    <section class="dashboard">
    <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Fine Details</span>
                </div>
               
            </div>
         
    </section>

</body>
</html>

<?php
include 'db_connection.php';

$sql = "SELECT 
            CASE 
                WHEN receiver = 'student' THEN student_name 
                ELSE staff_name 
            END AS receiver_name, 
            book_name, 
            due_date, 
            fine_amount,
            status
        FROM book_issues 
        WHERE fine_amount > 0";

$result = mysqli_query($conn, $sql);

echo "<h3>📢 Overdue Books & Fines</h3>";


// Fine per day
$finePerDay = 1;

// Fetch issued books
$sql = "SELECT * FROM book_issues";
$result = $conn->query($sql);


echo "<table style='border-collapse: collapse; width: 80%; margin: 20px auto; text-align: left;margin-left:18%;'>
<tr style='background-color: #f2f2f2;'>
    <th style='padding: 10px; border: 1px solid #ddd;'>Book ID</th>
    <th style='padding: 10px; border: 1px solid #ddd;'>User ID</th>
    <th style='padding: 10px; border: 1px solid #ddd;'>Due Date</th>
    <th style='padding: 10px; border: 1px solid #ddd;'>Return Date</th>
    <th style='padding: 10px; border: 1px solid #ddd;'>Days Late</th>
    <th style='padding: 10px; border: 1px solid #ddd;'>Fine (₹)</th>
</tr>";

while($row = $result->fetch_assoc()) {
    $dueDate = new DateTime($row['due_date']);
    $returnDate = $row['return_date'] ? new DateTime($row['return_date']) : new DateTime(); // Today if not returned

    $interval = $dueDate->diff($returnDate);
    $daysLate = ($returnDate > $dueDate) ? $interval->days : 0;
    $fine = $daysLate * $finePerDay;

    echo "<tr>
        <td style='padding: 10px; border: 1px solid #ddd;'>{$row['id']}</td>
        <td style='padding: 10px; border: 1px solid #ddd;'>{$row['student_name']}</td>
        <td style='padding: 10px; border: 1px solid #ddd;'>{$row['due_date']}</td>
        <td style='padding: 10px; border: 1px solid #ddd;'>" . ($row['return_date'] ?? 'Not Returned') . "</td>
        <td style='padding: 10px; border: 1px solid #ddd;'>{$daysLate}</td>
        <td style='padding: 10px; border: 1px solid #ddd; color: red;'>₹{$fine}</td>
    </tr>";
}

echo "</table>";

mysqli_close($conn);
?>