<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // or your SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@gmail.com'; // use your email
    $mail->Password = 'your_app_password'; // app password (not your actual Gmail password)
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('your_email@gmail.com', 'Secure Exam System');
    $mail->addAddress($_SESSION['email']);
    $mail->isHTML(true);
    $mail->Subject = 'Your OTP Code';
    $mail->Body    = 'Hello Student,<br>Your OTP is: <b>' . $_SESSION['otp'] . '</b><br>This OTP will expire in 5 minutes.';

    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
