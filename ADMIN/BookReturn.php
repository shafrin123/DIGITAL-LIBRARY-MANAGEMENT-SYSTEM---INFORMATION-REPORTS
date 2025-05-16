<?php
include 'db_connect.php'; // Include your database connection file

$message = ""; // To display messages after book return

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $access_no = $_POST['access_no'];
    $return_date = $_POST['return_date'];  // Manual return date entered by user

    // Ensure return date is entered manually
    if (empty($return_date)) {
        $message = "<div class='error-message animate-message'>❌ Return date must be entered manually!</div>";
    } else {
        // Check if the book was issued and is still not returned
        $check_query = "SELECT access_no FROM book_issues WHERE access_no = ? AND status = 'issued'";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $access_no);
        $stmt->execute();
        $result = $stmt->get_result();
        $issue = $result->fetch_assoc();

        if ($issue) {
            // Update book issue table with return date and change status to 'returned'
            $update_issue_query = "UPDATE book_issues SET return_date = ?, status = 'returned' WHERE access_no = ?";
            $stmt = $conn->prepare($update_issue_query);
            $stmt->bind_param("ss", $return_date, $access_no);
            $stmt->execute();

            // Increase available quantity in the books table
            $update_book_query = "UPDATE booksss SET avail_quantity = avail_quantity + 1 WHERE access_no = ?";
            $stmt = $conn->prepare($update_book_query);
            $stmt->bind_param("s", $access_no);
            $stmt->execute();

            $message = "<div class='success-message animate-message'>✅ Book Returned Successfully!</div>";
        } else {
            $message = "<div class='error-message animate-message'>❌ Invalid Return Request! Book is either not issued or already returned.</div>";
        }
    }
}

// Fetch issued books to display in the table
$issued_books_query = "SELECT * FROM book_issues WHERE status = 'issued'";
$issued_books = $conn->query($issued_books_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Book</title>
    <link rel="stylesheet" href="BookReturn.css"> <!-- External CSS file (optional) -->
    <style>
        
        /* General Page Styling */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            background: linear-gradient(to right, rgb(255,255,255), rgb(254,215,173));
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 500px;
            animation: fadeIn 0.8s ease-in-out;
            margin-top: 200px;
            margin-left: 350px;
        }

        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .input-container {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #00f2fe;
          
        }

        button {
            width: 100%;
            padding: 12px;
            background:rgb(109,67, 0);
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 6px;
            transition: 0.3s;
        }

        button:hover {
            background: rgb(109,67, 0);
            transform: translateY(-2px);
            box-shadow:  linear-gradient(to right, rgb(255,255,255), rgb(254,215,173));
        }

        .table-container {
            margin-top: 30px;
            width: 90%;
            max-width: 1000px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            margin-left: 150px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #4facfe;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        tr:hover {
            background: #d1ecf1;
            transition: 0.3s;
        }

        .success-message, .error-message {
            font-size: 16px;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            display: inline-block;
            font-weight: bold;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
                <li><a href="staffinf"><i class="bx bx-id-card"></i><span class="link-name">Staff Info</span></a></li>
                <li><a href="Book Info.php"><i class="bx bx-id-card"></i><span class="link-name">Book Info</span></a></li>
                <li><a href="fine-details.php"><i class="bx bx-money"></i><span class="link-name">Fine Details</span></a></li>
                <li><a href="profile.php"><i class="bx bx-notification"></i><span class="link-name">Notification</span></a></li>
                <li><a href="profile.php"><i class="bx bx-user-circle"></i><span class="link-name">My Account</span></a></li>
            </ul>
        </div>
        <i class="bx bx-menu sidebar-toggle"></i>
    </nav>

    <section class="dashboard">
        <div class="top">
           
           
            <img src="images/profile.jpg" alt="">
        </div>

    <div class="container">
        <h2>Return Book</h2>
        <?= $message; ?> <!-- Display success/error message -->

        <form action="" method="POST">
            <div class="input-container">
                <label>Access No</label>
                <input type="text" name="access_no" required>
            </div>

            <div class="input-container">
                <label>Return Date</label>
                <input type="date" name="return_date" required>
            </div>

            <button type="submit">Return Book</button>
        </form>
    </div>

    <!-- Issued Books Table -->
    <div class="table-container">
        <h2>Issued Books</h2>
        <table>
            <tr>
                <th>Access No</th>
                <th>Book Name</th>
                <th>Issued To</th>
                <th>Issued Date</th>
                <th>Due Date</th>
            </tr>
            <?php if ($issued_books->num_rows > 0): ?>
                <?php while ($row = $issued_books->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['access_no'] ?></td>
                        <td><?= $row['book_name'] ?></td>
                        <td><?= $row['receiver'] == 'student' ? $row['student_name'] : $row['staff_name'] ?></td>
                        <td><?= $row['issued_date'] ?></td>
                        <td><?= $row['due_date'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No issued books found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <script>
        // Sidebar Toggle for Shrinking the Sidebar
const sidebarToggle = document.querySelector('.sidebar-toggle');
const sidebar = document.querySelector('.sidebar');

sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('shrink');
});

// Dark Mode Toggle
const darkModeToggle = document.getElementById('dark-mode-toggle');
const body = document.body;

darkModeToggle.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
});
    </script>
   

</body>
</html>
