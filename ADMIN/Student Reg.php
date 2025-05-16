<?php
include 'connection.php'; // Ensure this file contains $connection

$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'login');

$msg = ""; // Message for feedback

if (isset($_POST['sign'])) { 
    $name = isset($_POST['name']) ? mysqli_real_escape_string($connection, $_POST['name']) : ''; 
    $department = isset($_POST['department']) ? mysqli_real_escape_string($connection, $_POST['department']) : ''; 
    $id = isset($_POST['id']) ? mysqli_real_escape_string($connection, $_POST['id']) : ''; 
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($connection, $_POST['phone']) : ''; 
    $mail = isset($_POST['mail']) ? mysqli_real_escape_string($connection, $_POST['mail']) : ''; 
    $class = isset($_POST['class']) ? mysqli_real_escape_string($connection, $_POST['class']) : ''; 
    $year = isset($_POST['year']) ? mysqli_real_escape_string($connection, $_POST['year']) : ''; 

    // Check if student already exists
    $sql = "SELECT * FROM stureg WHERE mail='$mail'";
    $result = mysqli_query($connection, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $msg = "<h3 style='color: red;'>⚠ Student already registered!</h3>";
    } else {
        // Insert into student table
        $query = "INSERT INTO stureg (name, department, id, phone, mail, class, year) 
                  VALUES ('$name', '$department', '$id', '$phone', '$mail', '$class', '$year')";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            $msg = "<h3 style='color: green;'>✔ Student Registered Successfully!</h3>";
        } else {
            $msg = "<h3 style='color: red;'>❌ Data not saved. Error: " . mysqli_error($connection) . "</h3>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Student Reg.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Student Register</title>
</head>
<body> 
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <!-- Sidebar (Same as before) -->
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

        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
        <!-- Student Registration Form Start -->
        <div class="container">
            <header>Student Registration</header>
            <?php echo $msg; ?> <!-- Display error/success message -->
            <form action="Student Reg.php" method="POST">
                <div class="form first">
                    <div class="details personal">
                        <span class="title"></span>
                        <div class="fields">
                            <div class="input-field">
                                <label>Full Name*</label>
                                <input type="text" name="name" placeholder="Enter full name" required>
                            </div>

                            <div class="input-field">
                                <label>Department*</label>
                                <input type="text" name="department" placeholder="Enter department" required>
                            </div>
                            <div class="input-field">
                                <label>Student Id*</label>
                                <input type="text" name="id" placeholder="Enter student ID" required>
                            </div>
                            <div class="input-field">
                                <label>Phone Number*</label>
                                <input type="text" name="phone" placeholder="Enter phone number" required>
                            </div>
                            <div class="input-field">
                                <label>Email*</label>
                                <input type="email" name="mail" placeholder="Enter email address" required>
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
        <!-- Options will be populated dynamically -->
    </select>
</div>

<script>
    function updateYearOptions() {
        // Get the selected class
        const selectedClass = document.getElementById("class").value;

        // Get the year dropdown
        const yearDropdown = document.getElementById("year");

        // Clear existing options
        yearDropdown.innerHTML = "";

        // Define year options based on the selected class
        let years = [];
        if (selectedClass === "ug") {
            years = ["1st", "2nd", "3rd"]; // UG has 3 years
        } else if (selectedClass === "pg") {
            years = ["1st", "2nd"]; // PG has 2 years
        }

        // Add the new options to the year dropdown
        years.forEach(year => {
            const option = document.createElement("option");
            option.value = year;
            option.textContent = year;
            yearDropdown.appendChild(option);
        });
    }

    // Call the function initially to populate the year dropdown based on the default class
    updateYearOptions();
</script>
                    </div>
                       
                    <div class="buttons">
                        <button type="submit" name="sign">Register</button>
                        <button type="reset">Clear</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Student Registration Form End -->

        
        
    
    <script src="JAVA.js"></script>
</body>
</html>