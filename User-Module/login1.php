<?php
session_name("user_session");
session_start();
include 'connect.php';
$connection = mysqli_connect("localhost", "root", "", "user");
if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['btn'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sanitized_username =  mysqli_real_escape_string($connection, $username);
  $sanitized_password =  mysqli_real_escape_string($connection, $password);
  // $hash=password_hash($password,PASSWORD_DEFAULT);

  $sql = "SELECT * FROM login WHERE username='$sanitized_username'";
  $result = mysqli_query($connection, $sql);
  if (!$result) {
    die("Query failed: " . mysqli_error($connection));
  }
  $num = mysqli_num_rows($result);
  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($sanitized_password, $row['password'])) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $row['name'];
        header("location:home.html");
      } else {
        // echo "<h1><center> Login Failed incorrect password</center></h1>";
      }
    }
  } else {
    echo "<h1><center>Account does not exist</center></h1>";
  }
}
?>