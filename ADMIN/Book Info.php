<?php
// Database connection (update with your credentials)
$conn = new mysqli("localhost", "root", "", "login");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST["book_id"];
    $condition = $_POST["condition"];
    $admin_approval = isset($_POST["admin_approval"]) ? 1 : 0;

    // Update book condition in the database
    $update_sql = "UPDATE Bookss SET book_condition='$condition', admin_approval='$admin_approval' WHERE id='$book_id'";
    if ($conn->query($update_sql) === TRUE) {
        $message = "Book condition updated successfully.";

        // If damaged or lost, notify responsible user
        if ($condition == "Damaged" || $condition == "Lost") {
            $message .= " Notification sent to: $responsible_user.";
        }
    } else {
        $message = "Error updating record: " . $conn->error;
    }
}

// Fetch books from the database
$result = $conn->query("SELECT * FROM booksss");

// Fetch count of books based on their condition
$condition_counts = [];
$conditions = ["New", "Good", "Fair", "Damaged", "Lost"];
foreach ($conditions as $condition) {
    $count_result = $conn->query("SELECT COUNT(*) AS count FROM Bookss WHERE book_condition = '$condition'");
    $condition_counts[$condition] = $count_result->fetch_assoc()["count"];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Condition Management</title>
    <link rel="stylesheet" href="Book Info.css">
    <style>
        /* Bar graph container styling */
        canvas#conditionChart {
        
            margin: 100px auto;
            max-width: 80%;
            background-color: #f9f9f9;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            
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
        <p class="logo"></p>
        <img src="users.png" alt="">
    </div>
<h2>Update Book Condition</h2>
<p class="message"><?php echo $message; ?></p>

<form method="GET" style="margin-bottom: 20px;">
    <label for="search">Search by Book Name:</label>
    <input type="text" name="search" id="search" placeholder="Enter book name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <button type="submit">Search</button>
    <a href="Book Info.php" style="text-decoration: none;">
        <button type="button">All Books</button>
    </a>
</form>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Access No</th>
            <th>Name</th>
            <th>Author</th>
            <th>Condition</th>
            <th>Issue Count</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $search_query = "";
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $conn->real_escape_string($_GET['search']);
            $search_query = "WHERE name LIKE '%$search%'";
        }

        $all_books_result = $conn->query("SELECT * FROM Bookss $search_query");
        while ($book = $all_books_result->fetch_assoc()) {
            // Fetch issue count for the current book
            $access_no = $book["access_no"];
            $issue_count_result = $conn->query("SELECT COUNT(*) AS issue_count FROM book_issues WHERE access_no = '$access_no'");
            $issue_count = $issue_count_result->fetch_assoc()["issue_count"];
        ?>
            <tr>
                <td><?php echo $book["access_no"]; ?></td>
                <td><?php echo $book["name"]; ?></td>
                <td><?php echo $book["author"]; ?></td>
                <td><?php echo $book["book_condition"]; ?></td>
                <td><?php echo $issue_count; ?></td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="book_id" value="<?php echo $book["id"]; ?>">
                        <select name="condition" required>
                            <option value="New">New</option>
                            <option value="Good">Good</option>
                            <option value="Fair">Fair</option>
                            <option value="Damaged">Damaged</option>
                            <option value="Lost">Lost</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
document.getElementById("condition").addEventListener("change", function() {
    var approvalDiv = document.getElementById("adminApproval");
    if (this.value === "Damaged" || this.value === "Lost") {
        approvalDiv.style.display = "block";
    } else {
        approvalDiv.style.display = "none";
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<h2>Book Condition Distribution</h2>
<canvas id="conditionChart" width="400" height="200"></canvas>
<script>
    const ctx = document.getElementById('conditionChart').getContext('2d');
    const conditionChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($condition_counts)); ?>,
            datasets: [{
                label: 'Number of Books',
                data: <?php echo json_encode(array_values($condition_counts)); ?>,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>

<?php $conn->close(); ?>
