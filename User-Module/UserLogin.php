<?php
session_name("user_session");
session_start();

$connection = mysqli_connect("localhost:3306", "root", "");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
$db = mysqli_select_db($connection, 'login');

$message = "";


if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sanitized_email = mysqli_real_escape_string($connection, $email);
  $sanitized_password = mysqli_real_escape_string($connection, $password);

  $sql = "SELECT * FROM login WHERE email='$sanitized_email'";
  $result = mysqli_query($connection, $sql);

  if ($result && mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);
      if (password_verify($sanitized_password, $row['password'])) {
          $_SESSION['email'] = $email;
          $_SESSION['name'] = $row['name'];
          header("Location: MAIN copy.php");
          exit();
      } else {
          $message = "Login Failed: Incorrect password.";
      }
  } else {
      $message = "Account does not exist.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="Logins.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="wrapper">
    <form action="UserLogin.php" method="POST">
      <h1>Login</h1>
      <div class="input-box">
        <input type="email" name="email" placeholder="email" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>

      <?php if (isset($msg)) { ?>
    <div class="message-box"><?php echo $msg; ?></div>
<?php } ?>

        <div class="remember-forgot">
        <label><input type="checkbox">Remember Me</label>
        <a href="forgot password.php">Forgot Password</a>
      </div>
      <button type="submit" name="login" value="login" class="btn">Login</button>
      <div class="register-link">
        <p>Dont have an account? <a href="Signup.php">Register</a></p>
      </div>
    </form>
  </div>
</body>
</html>

