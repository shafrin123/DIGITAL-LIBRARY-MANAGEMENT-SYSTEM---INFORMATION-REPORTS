<?php
include 'connection.php'; // Ensure this file contains $connection

$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'login');


$msg = ""; // Message for feedback

if (isset($_POST['sign'])) { 
    $name = isset($_POST['name']) ? mysqli_real_escape_string($connection, $_POST['name']) : ''; 
    $department = isset($_POST['department']) ? mysqli_real_escape_string($connection, $_POST['department']) : ''; 
    $id = isset($_POST['Id']) ? mysqli_real_escape_string($connection, $_POST['Id']) : ''; 
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($connection, $_POST['phone']) : ''; 
    $mail = isset($_POST['mail']) ? mysqli_real_escape_string($connection, $_POST['mail']) : ''; 

    // Check if staff member already exists
    $sql = "SELECT * FROM staff WHERE email='$mail'";
    $result = mysqli_query($connection, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $msg = "<h3 style='color: red;'>⚠ Staff member already registered!</h3>";
    } else {
        // Insert into staff table
        $query = "INSERT INTO staff (name, department, Id, phone, email) 
                  VALUES ('$name', '$department', '$id', '$phone', '$mail')";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            $msg = "<h3 style='color: green;'>✔ Staff Registered Successfully!</h3>";
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
    
    <link rel="stylesheet" href="Staff.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Staff Register</title>
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

        <!-- Staff Registration Form Start -->
        <div class="container">
            <header>Staff Registration</header>
            <?php echo $msg; ?> <!-- Display error/success message -->
            <form action="Staff.php" method="POST">
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
                                <label>Staff Id*</label>
                                <input type="text" name="department" placeholder="Enter department" required>
                            </div>
                            <div class="input-field">
                                <label>Phone Number*</label>
                                <input type="text" name="phone" placeholder="Enter phone number" required>
                            </div>
                            <div class="input-field">
                                <label>Email*</label>
                                <input type="email" name="mail" placeholder="Enter email address" required>
                            </div>
                        </div>
                    </div>
                       
                    <div class="buttons">
                        <button type="submit" name="sign">Register</button>
                        <button type="reset">Clear</button>
                    </div>
                </div>
            </form>
        </div>
        </section>
        <!-- Staff Registration Form End -->
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
nav{
    width: 100%;
    height: 10vh;
    position: sticky;
}

.logo {
    padding-left: 20px;
    float: left;
    padding-top: 10px;
    margin-top: 5px;
    width: 100px; /* Set the desired width */
    height: auto; /* Maintain aspect ratio */
}

.nav-container .links {
    display: flex;
    gap: 3rem;
    align-items: center;
}
.nav-container .links a{
    position: relative;
    font-size: 1.2rem;
    color: black;
    text-decoration: none;
    font-weight: 500;
    transform: 0.3s linear;
}
.nav-container .links a::before{
    position: absolute;
    content: "";
    bottom: -3px;
    left: 0;
    width: 0%;
    height: 3px;
    background-color: rgb(109,67, 0);
    transition: 0.2s linear;
}
.nav-container .links a:hover::before{
    width: 100%;
}

@media (max-width:884px) {
    body{
        overflow-y: visible;
    }
 
    .nav-container .links{
        display: none;
    }
  
    
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
        
    
    <script src="JAVA.js"></script>
</body>
</html>
