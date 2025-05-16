<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include sidebar


// Get new pre-booking requests
$sql = "SELECT * FROM pre_bookings WHERE status = 'pending' ORDER BY created_at DESC";
$result = $conn->query($sql);

echo "<h2>New Pre-Booking Requests</h2>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='message-container'>
                <p><strong>{$row['name']} ({$row['user_type']})</strong> requested <b>'{$row['book_name']}'</b> by {$row['author_name']}</p>
                <form method='post' action='mark_seen.php'>
                    <input type='hidden' name='booking_id' value='{$row['id']}'>
                    <button type='submit'>Mark as Seen</button>
                </form>
              </div>";
    }
} else {
    echo "<p class='no-notifications'>No new notifications.</p>";
}

// Fetch feedback data from the 'user' database
$feedback_dbname = "user"; // Updated database name
$feedback_conn = new mysqli($servername, $username, $password, $feedback_dbname);

if ($feedback_conn->connect_error) {
    die("Connection to feedback database failed: " . $feedback_conn->connect_error);
}

$sql_feedback = "SELECT * FROM user_feedback ORDER BY feedback_id DESC";
$result_feedback = $feedback_conn->query($sql_feedback);

echo "<h2>User Feedback</h2>";

if ($result_feedback->num_rows > 0) {
    echo "<table>
            <tr>
               
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
            </tr>";
    while ($row = $result_feedback->fetch_assoc()) {
        echo "<tr>
               
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['message']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='no-feedback'>No feedback available.</p>";
}

$feedback_conn->close();

$conn->close();
?>

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
        .message-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            margin-left: 30%;
            margin-right: 10%;
            background: #f9f9f9;
        }

        h2 {
            margin-top: 50px;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .badge {
            background: red;
            color: white;
            border-radius: 100%;
            padding: 1px 4px;
            font-size: 12px;
            font-weight: bold;
        }

        /* New style for the "No new notifications" paragraph */
        .no-notifications {
            text-align: center;
            color:red;
            font-size: 16px;
            margin-top: 20px;
        }

        /* New style for the "Mark as Seen" button */
        .message-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        .message-container button:hover {
            background-color: #45a049;
        }

        .feedback-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            margin-left: 30%;
            margin-right: 10%;
            background: #f9f9f9;
        }

        .feedback-container p {
            margin: 5px 0;
        }

        .no-feedback {
            text-align: center;
            color: red;
            font-size: 16px;
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 60%;
            margin: 20px auto;
            margin-left: 30%;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        /* Style for the "User Feedback" heading */
        h2:nth-of-type(2) {
            text-align: center;
            color: #007BFF;
            font-size: 24px;
            margin-top: 40px;
            margin-bottom: 20px;
            margin-left: 20%;
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

        <script>
            function updateNotificationCount() {
                fetch('get_notification_count.php')
                    .then(response => response.text())
                    .then(count => {
                        let notificationBadge = document.getElementById("notificationCount");

                        // Show badge only if there are new notifications
                        if (parseInt(count) > 0) {
                            notificationBadge.innerText = count;
                            notificationBadge.style.display = "inline-block";
                        } else {
                            notificationBadge.style.display = "none";
                        }
                    })
                    .catch(error => console.error('Error fetching notification count:', error));
            }

            // Refresh every 5 seconds
            setInterval(updateNotificationCount, 5000);

            // Load count immediately when the page loads
            updateNotificationCount();
        </script>

<script src="JAVA.js"></script>

</body>

</html>