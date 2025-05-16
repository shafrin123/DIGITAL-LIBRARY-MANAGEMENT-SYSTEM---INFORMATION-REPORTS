<?php
session_start();
include 'connect.php';
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'user');

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sanitized_username = mysqli_real_escape_string($connection, $username); // Fixed variable name
  $sanitized_password = mysqli_real_escape_string($connection, $password);

  $sql = "SELECT * FROM login WHERE username='$sanitized_username'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);

  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($sanitized_password, $row['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['name'] = $row['name'];
        $_SESSION['student_id'] = $row['id']; // Store student_id in session
        header("location:MAIN.php");
        exit;
      } else {
        echo "<h1><center>Login Failed: Incorrect password</center></h1>";
      }
    }
  } else {
    echo "<h1><center>Account does not exist</center></h1>";
  }
}
?>