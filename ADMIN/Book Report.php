<?php 
session_start(); 
include 'connect.php'; // Ensure this file contains $connection

// Fetch book categories and counts from the database
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($connection, $_GET['search']);
    $query = "SELECT category, count FROM report WHERE category LIKE '%$searchQuery%'";
} else {
    $query = "SELECT category, count FROM report";
}

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Prepare data for the chart
$bookData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bookData[$row['category']] = $row['count'];
}

// Encode labels and values for Chart.js
$labels = json_encode(array_keys($bookData));  
$values = json_encode(array_values($bookData)); 

// Handle form submission to insert data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newCategory = mysqli_real_escape_string($connection, $_POST['category']);
    $newCount = intval($_POST['count']);

    if (!empty($newCategory) && $newCount > 0) {
        $insertQuery = "INSERT INTO report (category, count) VALUES ('$newCategory', '$newCount')";
        if (!mysqli_query($connection, $insertQuery)) {
            die("Insert failed: " . mysqli_error($connection));
        }
        header("Location: " . $_SERVER['PHP_SELF']); // Refresh page after insertion
        exit();
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Book Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Enable Scrolling */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-y: auto; /* Enables vertical scrolling */
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            min-height: 100vh; /* Ensures full height */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 20px;
        }

        /* Compact Search Bar */
        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .search-box {
            width: 250px;
            padding: 8px;
            border: 2px solid #007BFF;
            border-radius: 20px;
            outline: none;
            font-size: 14px;
        }

        .search-btn {
            background-color: #007BFF;
            border: none;
            color: white;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 20px;
            margin-left: 8px;
        }

        .search-btn:hover {
            background-color: #0056b3;
        }

        /* Small-sized Form */
        .form-container {
            max-width: 300px;
            margin: 0 auto 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container h3 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .form-container input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-container button {
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 14px;
            border-radius: 5px;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        .chart-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        /* Smaller chart boxes */
        .chart-box {
            width: 80%;
            max-width: 400px; /* Reduced width */
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
        }

        canvas {
            max-width: 100%;
            height: 180px !important; /* Reduced height */
        }

        @media (max-width: 768px) {
            .chart-box {
                width: 90%;
                max-width: 300px; /* Smaller for mobile */
            }

            canvas {
                height: 150px !important; /* Reduce height further on mobile */
            }
        }
    </style>
</head>
<body>
        <!-- Include Boxicons -->
        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <!-- Inserted Sidebar -->
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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

*{
    padding: 0;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
}
html{
    overflow-x: hidden;
}
body{
    width: 100%;
    height: 100vh;
    overflow: hidden;
    overflow-y: auto;
   
    background: linear-gradient(to right, rgb(255,255,255), rgb(254,215,173));
}

/* Global Styles */
* {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
}






/* Sidebar Styles */
.sidebar {
    width: 250px;
    height: 100vh;
    background-color: transparent;
    position: fixed;
    top: 0;
    left: 0;
    padding: 10px;
    transition: width 0.3s ease;
}

.sidebar.shrink {
    width: 70px; /* Shrink the sidebar */
}

.sidebar .logo-name {
    font-size: 24px;
    font-weight: 600;
    color: #fff;
    text-align: center;
    margin-bottom: 10px;
}

.sidebar .menu-items {
    margin-top: 20px;
}

.sidebar .nav-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar .nav-links li {
    margin-bottom: 15px;
}

.sidebar .nav-links li a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: black;
    padding: 5px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.sidebar .nav-links li a i {
    font-size: 20px;
    margin-right: 10px;
}

.sidebar .nav-links li a .link-name {
    font-size: 16px;
}

.sidebar.shrink .nav-links li a .link-name {
    display: none; /* Hide text in links when sidebar is shrunk */
}

.sidebar-toggle {
    font-size: 30px;
    color: black;
    cursor: pointer;
    position: absolute;
    top: 2%;
    right: -50px; /* Position hamburger icon to the right of sidebar */
    transform: translateY(-50%);
    border: none;
    padding: 10px;
    border-radius: 50%;
}

/* Responsive for Sidebar and Top Navbar */
@media screen and (max-width: 768px) {
    .top-nav-container .top-nav-links {
        display: none;
    }

    .sidebar {
        left: 0;
        top: 0;
        width: 250px;
    }

    .sidebar.shrink {
        width: 70px;
    }
}

</style>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <p class="logo"></p>
            <img src="users.png" alt="">
        </div>
    <!-- End Sidebar insertion -->

<div class="container">
    <h2>Library Book Report</h2>

    <!-- Compact Search Bar -->
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" class="search-box" placeholder="Search category..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <!-- Small Form for Adding Data -->
    <div class="form-container">
        <h3>Add New Category</h3>
        <form method="POST" action="">
            <input type="text" name="category" placeholder="Enter Category" required>
            <input type="number" name="count" placeholder="Enter Count" required>
            <button type="submit">Add</button>
        </form>
    </div>

    <div class="chart-container">
        <!-- Pie Chart -->
        <div class="chart-box">
            <h3>Pie Chart - Book Categories</h3>
            <canvas id="bookPieChart"></canvas>
        </div>

        <!-- Bar Chart -->
        <div class="chart-box">
            <h3>Bar Chart - Book Count</h3>
            <canvas id="bookBarChart"></canvas>
        </div>
    </div>
</div>
</section>
<script>
    var labels = <?php echo $labels; ?>;
    var values = <?php echo $values; ?>;

    var backgroundColors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#9C27B0', 
        '#FF5722', '#00BCD4', '#8BC34A', '#FFC107', '#795548'
    ];

    new Chart(document.getElementById('bookPieChart'), {
        type: 'pie',
        data: { labels: labels, datasets: [{ data: values, backgroundColor: backgroundColors.slice(0, labels.length) }] },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    new Chart(document.getElementById('bookBarChart'), {
        type: 'bar',
        data: { labels: labels, datasets: [{ label: 'highest Number of Books', data: values, backgroundColor: backgroundColors.slice(0, labels.length) }] },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
</script>

</body>
</html>