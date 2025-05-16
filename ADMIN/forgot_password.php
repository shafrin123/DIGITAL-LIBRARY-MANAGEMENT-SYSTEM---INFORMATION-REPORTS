<?php
// Include database connection
include 'connect.php';

// Ensure $connection is defined
if (!isset($connection)) {
    die("❌ Database connection not established. Please check 'connection.php'.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($connection, $_POST['email']);

    // Check if the email exists in the database
    $query = "SELECT * FROM login WHERE email='$email'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // Generate a 10-character reset token
        function generateToken($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $token = '';
            for ($i = 0; $i < $length; $i++) {
                $token .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $token;
        }

        $reset_token = generateToken(10);
        $expiry_time = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token expires in 1 hour

        // Update the database with the reset token
        $update_query = "UPDATE login SET reset_token='$reset_token', reset_token_expiry='$expiry_time' WHERE email='$email'";
        if (mysqli_query($connection, $update_query)) {
            // Send email with reset link
            require 'send_reset_email.php'; // Include the email sending script
            sendPasswordResetEmail($email, $reset_token);
            echo "✅ Password reset link has been sent to your email.";
        } else {
            echo "❌ Error updating token: " . mysqli_error($connection);
        }
    } else {
        echo "❌ Email not found in our records.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
            background:linear-gradient(to right, rgb(255,255,255), rgb(254,215,173));
        }

        /* Form Container */
        .container {
            background:linear-gradient(to right, rgb(255,255,255), rgb(254,215,173));
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        /* Message should come above the form */
        .message {
            padding: 20px;
            border-radius: 5px;
            font-size: 14px;
            order: 1;
            margin-bottom: 20px;
        }

        .container form {
            order: 2;
            width: 100%;
        }

        /* Input Field */
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Button */
        button {
            width: 100%;
            background-color: rgb(109,67, 0);
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

        /* Success & Error Messages */
        .success {
            background-color: #d4edda;
            color: rgb(109,67, 0);
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <p>Enter your email below, and we'll send you a password reset link.</p>
        
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Send Reset Link</button>
        </form>

        <!-- Display success or error messages -->
        <?php if (isset($message)): ?>
            <div class="message <?php echo (strpos($message, '✅') !== false) ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>