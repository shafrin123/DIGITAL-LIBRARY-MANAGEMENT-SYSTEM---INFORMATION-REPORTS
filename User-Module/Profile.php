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
              <p style="font-size: 28px;">welcome User !!!</p> 
               
              <br>
              <div class="info" style="padding-left:10px;">
              <p style="">Name  :<?php echo"". $_SESSION['username'] ;?> </p><br>
             
              
              
              <div style="text-align: center;">
                <a href="Logout.php" style="margin-top: 6px; border-radius: 5px; background-color:rgb(109,67, 0); color: white; padding-left: 10px; padding-right: 10px;">Logout</a>
            
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