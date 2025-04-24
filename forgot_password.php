<?php
session_start();
include "db_connection.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $email = $_POST["email"];

    // Check if student exists
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ? AND email = ?");
    $stmt->bind_param("ss", $student_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION["otp"] = $otp;
        $_SESSION["otp_email"] = $email;
        $_SESSION["otp_student_id"] = $student_id;

        // Send OTP via email
        $subject = "Your OTP Code for Password Reset";
        $messageBody = "Hi, your OTP code is: $otp. It is valid for 5 minutes.";
        $headers = "From: examportal@uptm.edu.my";

        if (mail($email, $subject, $messageBody, $headers)) {
            header("Location: verify_otp.php");
            exit();
        } else {
            $message = "❌ Failed to send OTP. Please try again.";
        }
    } else {
        $message = "❌ Student ID or Email not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>🔐 Forgot Password - Request OTP</h2>
    <?php if ($message): ?>
        <p style="color:red;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="student_id" placeholder="Enter Student ID" required><br>
        <input type="email" name="email" placeholder="Enter Email" required><br>
        <button type="submit">Send OTP</button>
    </form>
</body>
</html>
