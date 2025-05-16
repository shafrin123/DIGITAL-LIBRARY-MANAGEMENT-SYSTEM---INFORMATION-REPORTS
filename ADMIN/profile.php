<?php
session_start(); // Ensure the session is started before accessing session variables

if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = ""; // Set a default value or redirect the user
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="stylesheet" href="profile.css">

    <!-- <title>Document</title> -->
  


</head>
<body>
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
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

<script src="JAVA.js"></script>

    <div class="profile">
    <!-- <section class="cover" >
        
        </section>
     -->
        <div class="profilebox" >
          
            <img src="admin.png" alt="" style=< width: 90px;
            height: 90px;
            border-radius:50% ;  
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding-top: 10px;
            border: 1px solid #ffff; 
            >
            <br> 
              <p style="font-size: 28px;">welcome Admin !!!</p> 
               
              <br>
              <div class="info" style="padding-left:10px;">
              <p style="">Name  :<?php echo"". $_SESSION['username'] ;?> </p><br>
             
              
              
              <div style="text-align: center;">
                <a href="Logout.php" style="margin-top: 6px; border-radius: 5px; background-color:rgb(109,67, 0); color: white; padding-left: 10px; padding-right: 10px;">Logout</a>
                <br><p>Don't have an account? <a href="singup.php">Register</a></p>
              </div>
              <br>
              <br>     
    </table>
         </div>
   </div>          
        </div>

    </div>

</body>
</html>