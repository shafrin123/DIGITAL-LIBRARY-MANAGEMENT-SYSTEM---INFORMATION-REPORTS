<?php
include 'connection.php';
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
    $sql = "SELECT * FROM login WHERE username='$username'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $msg = "<h3 style='color: red;'>⚠ Account already exists!</h3>";
    } else {
        // Insert into database
        $query = "INSERT INTO login (username, password,email) VALUES ('$username', '$pass','$email')";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            header("Location: LOGIN.php"); // Redirect to login page
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
    <title>Register</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>

    <div class="container">
        <div class="regform">
            <form action="" method="POST">
                <p class="logo">Library <b style="color: #06C167;">System</b></p>
                <p id="heading">Create your account</p>

                <?php if (!empty($msg)) echo $msg; ?> <!-- Show error/success messages -->
                <div class="input">
                     <label class="textlabel" for="email">Email</label>
                     <input type="email" id="email" name="email" required />
                     </div>

                <!-- Username -->
                <div class="input">
                    <label class="textlabel" for="username">Username</label>
                    <input type="text" id="username" name="username" required />
                </div>

                <!-- Password -->
                <label class="textlabel" for="password">Password</label>
                <div class="password">
                    <input type="password" name="password" id="password" required />
                    <i class="uil uil-eye-slash showHidePw" id="showpassword"></i>                
                </div>
                

                <!-- Submit Button -->
                <div class="btn">
                    <button type="submit" name="sign">Register</button>
                </div>

                <div class="signin-up">
                    <p>Already have an account? <a href="LOGIN.php">Login</a></p>
                </div>
            </form>
        </div>
    </div>

   
</body>
</html>
