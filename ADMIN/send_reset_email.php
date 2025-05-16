<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function sendPasswordResetEmail($email, $reset_token) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'prathabans428@gmail.com';
        $mail->Password = 'wcmt fccp hpfu bdpc'; // Use App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('prathabans428@gmail.com', 'LIBRARY MANAGEMENT SYSTEM');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';

        $reset_link = "http://localhost/LIBRARY_MANAGEMENT_SYSTEM/reset_password.php?token=" . $reset_token;
        $mail->Body = "<p>Click the following link to reset your password:</p><p><a href='$reset_link'>$reset_link</a></p>";
        $mail->AltBody = "Click the following link to reset your password: $reset_link";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>