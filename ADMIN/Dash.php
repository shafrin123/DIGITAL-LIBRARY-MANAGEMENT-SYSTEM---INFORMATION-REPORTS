<?php
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'login');
include "connection.php";
include 'db_connect.php'; // Include database connection

// Ensure the correct database is selected
$conn->select_db('login'); // Replace with the correct database name

// Function to fetch data from the database
function fetchData($conn, $query) {
    $result = $conn->query($query);
    return $result ? $result->fetch_assoc() : null;
}

// Fetch total books
$total_books_query = "SELECT SUM(avail_quantity) as total_books FROM booksss";
$total_books_result = fetchData($conn, $total_books_query);
$total_books = $total_books_result['total_books'] ?? 0;

// Fetch total books issued
$total_issued_query = "SELECT COUNT(*) as total_issued FROM book_issues WHERE status = 'issued'";
$total_issued_result = fetchData($conn, $total_issued_query);
$total_issued = $total_issued_result['total_issued'] ?? 0;

// Fetch total books returned
$total_returned_query = "SELECT COUNT(*) as total_returned FROM book_issues WHERE status = 'returned'";
$total_returned_result = fetchData($conn, $total_returned_query);
$total_returned = $total_returned_result['total_returned'] ?? 0;

// Fetch data for the chart
$query = "SELECT 
            CASE 
                WHEN receiver = 'staff' THEN receiver 
                ELSE CONCAT(receiver, ' (', class, ' - ', year, ')') 
            END AS receiver_class_year, 
            COUNT(*) AS total_issues 
          FROM book_issues 
          GROUP BY receiver, class, year 
          ORDER BY receiver, class, FIELD(year, '1st', '2nd', '3rd')";
$result = $conn->query($query);

$receiverClassYears = [];
$issueCounts = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $receiverClassYears[] = ucfirst($row['receiver_class_year']); // Capitalize receiver, class, and year
        $issueCounts[] = $row['total_issues'];
    }
} else {
    die("Query failed: " . $conn->error);
}

// Ensure there is data for the chart
if (empty($receiverClassYears) || empty($issueCounts)) {
    $receiverClassYears = ["No Data"];
    $issueCounts = [0];
}

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
        .badge {
            background: red;
            color: white;
            border-radius: 50%;
            padding: 3px 8px;
            font-size: 12px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
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
                    <span class="text">Dashboard</span>
                </div>
                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-thumbs-up"></i>
                        <span class="text">Total Books</span>
                        <?php echo $total_books; ?>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-comments"></i>
                        <span class="text">Book Issued</span>
                        <?php echo $total_issued; ?>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-share"></i>
                        <span class="text">Book Returned</span>
                        <?php echo $total_returned; ?>
                    </div>
                
                </div>
            </div>

            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Analytics</span>
                </div>
                <div class="activity-data">
                    <div class="data names"></div>
                    <canvas id="analyticsPieChart" width="400" height="400"></canvas>
                </div>
            </div>

            <!-- Bar Chart for Books Issued Analytics -->
            <div class="activity">
                <div class="title">
                    <i class="uil uil-chart"></i>
                    <span class="text">Books Issued Analytics</span>
                </div>
                <div style="width: 80%; margin: 0 auto;">
                    <canvas id="booksIssuedChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        
        // Data for the pie chart
        const totalBooks = <?php echo $total_books; ?>;
        const totalIssued = <?php echo $total_issued; ?>;
        const totalReturned = <?php echo $total_returned; ?>;

        // Get the canvas element
        const ctx = document.getElementById('analyticsPieChart').getContext('2d');

        // Create the pie chart
        const analyticsPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Total Books', 'Books Issued', 'Books Returned'],
                datasets: [{
                    label: 'Book Analytics',
                    data: [totalBooks, totalIssued, totalReturned],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Book Analytics'
                    }
                }
            }
        });

        // Data for the books issued bar chart
        const booksIssuedCtx = document.getElementById('booksIssuedChart').getContext('2d');
        const booksIssuedChart = new Chart(booksIssuedCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($receiverClassYears); ?>,
                datasets: [{
                    label: 'Books Issued by Receiver, Class, and Year',
                    data: <?php echo json_encode($issueCounts); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Books Issued by Receiver, Class, and Year'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
       
        // Update notification count
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




</body>
</html>