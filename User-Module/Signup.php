<?php
include 'connect.php';
$connection = mysqli_connect("localhost", "root", "", "login");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$msg = ""; // Message for error/success feedback

if (isset($_POST['sign'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Hash the password for security
    $pass = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $sql = "SELECT * FROM logins WHERE username='$username'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $msg = "<h3 style='color: red;'>⚠ Account already exists!</h3>";
    } else {
        // Insert into database
        $query = "INSERT INTO logins (username, password,email) VALUES ('$username', '$pass','$email')";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            header("Location: userlogin.php"); // Redirect to login page
            exit();
        } else {
            $msg = "<h3 style='color: red;'>❌ Data not saved. Try again!</h3>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form | Dan Aleko</title>
    <link rel="stylesheet" href="Logins.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Create your account</h1>
            <?php echo $msg; ?> <!-- Display message here -->
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bxs-email'></i>
            </div>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" name="sign" class="btn">Register</button>
            <div class="register-link">
                <p>Already have an account? <a href="UserLogin.php">Login</a></p>
            </div>
        </form>
    </div>
</body>

</html>