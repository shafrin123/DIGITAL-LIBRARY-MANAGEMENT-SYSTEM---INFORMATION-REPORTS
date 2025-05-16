<?php
include 'db_connect.php'; // Database connection

$message = ""; // Initialize message variable
$message_type = ""; // Initialize message type

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $access_no = $_POST['access_no'];
    $book_name = $_POST['book_name'];
    $author_name = $_POST['author_name'];
    $receiver = $_POST['receiver'];
    $issued_date = $_POST['issued_date'];
    $due_date = $_POST['due_date'];
    $return_date = NULL;
    $status = 'issued';

    // Student Details
    $student_name = $_POST['student_name'] ?? NULL;
    $class = $_POST['class'] ?? NULL;
    $year = $_POST['year'] ?? NULL;
    $student_id = $_POST['student_id'] ?? NULL;
    $contact = $_POST['contact'] ?? NULL;

    // Staff Details
    $staff_name = $_POST['staff_name'] ?? NULL;
    $department = $_POST['department'] ?? NULL;

    // Check if the book is available
    $check_query = "SELECT avail_quantity FROM booksss WHERE access_no = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $access_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    if ($book === NULL) {
        $message = "❌ Book Not Found!";
        $message_type = "error";
    } elseif ($book['avail_quantity'] > 0) {

        // Insert book issue record
        $issue_query = "INSERT INTO book_issues (access_no, book_name, author_name, receiver, student_name, class, year, student_id, contact, staff_name, department, issued_date, due_date, return_date, status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($issue_query);
        $stmt->bind_param("sssssssssssssss", $access_no, $book_name, $author_name, $receiver, $student_name, $class, $year, $student_id, $contact, $staff_name, $department, $issued_date, $due_date, $return_date, $status);
        $stmt->execute();

        // Update available quantity
        $update_query = "UPDATE booksss SET avail_quantity = avail_quantity - 1 WHERE access_no = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("s", $access_no);
        $stmt->execute();

        $message = "✅ Book Issued Successfully!";
        $message_type = "success";
    } else {
        $message = "❌ Book Not Available!";
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Bookissue.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Book Issue Form</title>
    <style>
        /* Message styling */
        .message-container {
            width: 100%;
            margin-bottom: 15px;
        }

        .message {
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
            font-weight: bold;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
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
       
       
        <img src="images/profile.jpg" alt="">
    </div>
 
           
    <!-- Message Display Section -->
    <?php if (!empty($message)): ?>
        <div class="message-container">
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        </div>
    <?php endif; ?>

    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <div class="container">
        <header>
            <h1>Book Issue</h1>
        </header>
        <form method="POST">
            <div class="form first">
                <div class="fields">
                    <div class="input-field">
                        <label>Book Accession No:</label>
                        <input type="text" name="access_no" required>
                    </div>
                    <div class="input-field">
                        <label>Book Name:</label>
                        <input type="text" name="book_name" required>
                    </div>

                    <div class="input-field">
                        <label>Author Name:</label>
                        <input type="text" name="author_name" required>
                    </div>
                    <div class="input-field">
                        <label>Receiver:</label>
                        <select id="receiver" name="receiver" onchange="toggleFields()" required>
                            <option value="">Select</option>
                            <option value="student">Student</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    <div id="studentFields">
                        <div class="input-field">
                            <label>Student Name:</label>
                            <input type="text" name="student_name">
                        </div>
                        <div class="input-field">
                            <label>Class:</label>
                            <select id="class" name="class" onchange="updateYearOptions()">
                                <option value="ug">UG</option>
                                <option value="pg">PG</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Year:</label>
                            <select id="year" name="year">
                                <!-- Options will be populated based on the selected class -->
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Student ID:</label>
                            <input type="text" name="student_id">
                        </div>
                        <div class="input-field">
                            <label>Contact:</label>
                            <input type="text" name="contact">
                        </div>
                    </div>
                    <div id="staffFields">
                        <div class="input-field">
                            <label>Staff Name:</label>
                            <input type="text" name="staff_name">
                        </div>
                        <div class="input-field">
                            <label>Department:</label>
                            <input type="text" name="department">
                        </div>
                    </div>
                    <div class="input-field">
                        <label>Issued Date:</label>
                        <input type="date" name="issued_date" required>
                    </div>
                    <div class="input-field">
                        <label>Due Date:</label>
                        <input type="date" name="due_date" required>
                    </div>
                </div>
                <div class="buttons">
                    <button type="submit">
                        <span class="btnText">Issue Book</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Sidebar Toggle for Shrinking the Sidebar
const sidebarToggle = document.querySelector('.sidebar-toggle');
const sidebar = document.querySelector('.sidebar');

sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('shrink');
});




        function toggleFields() {
            var receiverType = document.getElementById("receiver").value;
            document.getElementById("studentFields").style.display = receiverType === "student" ? "flex" : "none";
            document.getElementById("staffFields").style.display = receiverType === "staff" ? "flex" : "none";
        }

        function updateYearOptions() {
            var classType = document.getElementById("class").value;
            var yearSelect = document.getElementById("year");
            yearSelect.innerHTML = ""; // Clear previous options

            if (classType === "ug") {
                var ugOptions = ["1st BSc", "2nd BSc", "3rd BSc"];
                ugOptions.forEach(function(option) {
                    var opt = document.createElement("option");
                    opt.value = option.toLowerCase().replace(/\s+/g, "_");
                    opt.innerHTML = option;
                    yearSelect.appendChild(opt);
                });
            } else if (classType === "pg") {
                var pgOptions = ["1st MSc", "2nd MSc"];
                pgOptions.forEach(function(option) {
                    var opt = document.createElement("option");
                    opt.value = option.toLowerCase().replace(/\s+/g, "_");
                    opt.innerHTML = option;
                    yearSelect.appendChild(opt);
                });
            }
        }

        window.onload = function() {
            toggleFields(); // Ensure the correct fields are displayed based on the receiver
            updateYearOptions(); // Ensure the year options are populated based on the class
        };
    </script>
   
</body>
</html>
