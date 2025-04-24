<?php
session_start();
include "db_connection.php";

if (!isset($_SESSION["otp_email"]) || !isset($_SESSION["otp_student_id"])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
    $student_id = $_SESSION["otp_student_id"];

    $stmt = $conn->prepare("UPDATE students SET password = ? WHERE student_id = ?");
    $stmt->bind_param("ss", $new_password, $student_id);
    $stmt->execute();

    // Clear OTP session data
    unset($_SESSION["otp"]);
    unset($_SESSION["otp_email"]);
    unset($_SESSION["otp_student_id"]);

    echo "<p style='color:green;'>✅ Password changed successfully. You can now <a href='student_login.php'>login</a>.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>🔒 Reset Your Password</h2>
    <form method="post">
        <input type="password" name="new_password" placeholder="Enter New Password" required><br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
