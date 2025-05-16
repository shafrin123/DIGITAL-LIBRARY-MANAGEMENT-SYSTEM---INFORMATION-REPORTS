<?php
include 'connect.php';
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'login');

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($connection, $_GET['token']);
    
    // Validate token
    $sql = "SELECT * FROM login WHERE reset_token='$token'";
    $result = mysqli_query($connection, $sql);
    $user = mysqli_fetch_assoc($result);

    if (!$user || strtotime($user['reset_token_expiry']) < time()) {
        echo "<script>alert('Invalid or expired token!'); window.location='signin.php';</script>";
        exit();
    }

    $email = $user['email']; // Store email for later use
} else {
    echo "<script>alert('No token provided'); window.location='signin.php';</script>";
    exit();
}

if (isset($_POST['reset'])) {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password and clear token
        $update_query = "UPDATE login SET password='$hashed_password', reset_token=NULL, reset_token_expiry=NULL WHERE email='$email'";
        mysqli_query($connection, $update_query);

        echo "<script>alert('Password reset successful! Please login.'); window.location='signin.php';</script>";
    } else {
        echo "<script>alert('Passwords do not match');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        /* Global Styles */
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
           
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, rgb(255,255,255), rgb(254,215,173));
        }

        /* Form Container */
        .container {
            background: linear-gradient(to right, rgb(255,255,255), rgb(254,215,173));
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        /* Input Fields */
        .input {
            text-align: left;
            margin-bottom: 15px;
        }

        .textlabel {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Button */
        .btn {
            margin-top: 10px;
        }

        button {
            width: 100%;
            background-color:  rgb(109,67, 0);
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(109,67, 0);
        }

    </style>
</head>
<body>
    <div class="container">
        <p class="logo"> Admin<b style="color: rgb(109,67, 0);">!!</b></p>
        <h2>Reset Password</h2>
        <form action="" method="POST">
            <div class="input">
                <label class="textlabel" for="password">New Password</label>
                <input type="password" id="password" name="password" required/>
            </div>

            <div class="input">
                <label class="textlabel" for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required/>
            </div>

            <div class="btn">
                <button type="submit" name="reset">Reset Password</button>
            </div>
        </form>
    </div>
</body>
</html>