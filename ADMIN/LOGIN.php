<?php
session_start();
include 'connection.php';
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'login');

$msg = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $sql = "SELECT * FROM login WHERE username='$username'";
    $result = mysqli_query($connection, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: Dash.php");
            exit();
        } else {
            $msg = "Incorrect password!";
        }
    } else {
        $msg = "Account does not exist!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <div class="form">
        <h2>Welcome Admin!!</h2>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btnn" name="login">Login</button>
        </form>

        <?php if (!empty($msg)): ?>
            <p style="color:red;"><?= $msg; ?></p>
        <?php endif; ?>

        <p class="link">
            
            <div class="signin-up">
                <center>
                    <p> <a href="forgot_password.php">Forgot Password</a></p></center>
                </div>
        </p>
    </div>
</body>
</html>
