
<?php 
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php'; // For PHPMailer
include "db_connection.php";



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST["student_id"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();

        if (password_verify($password, $student["password"])) {
            // ✅ Generate OTP
            $otp = rand(100000, 999999);
            $_SESSION["otp"] = $otp;
            $_SESSION["student_id"] = $student["student_id"];
            $_SESSION["student_name"] = $student["name"];
            $_SESSION["student_email"] = $student["email"];
        
            // ✅ Send OTP via Email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'onlineexaminationuptm@gmail.com';
                $mail->Password = 'mfxz nadh fvmp whwh';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
        
                $mail->setFrom('onlineexaminationuptm@gmail.com', 'Secure Exam System');
                $mail->addAddress($student["email"]);
                $mail->isHTML(true);
                $mail->Subject = "Your OTP Code for Login";
                $mail->Body = "Hello <strong>{$student["name"]}</strong>,<br><br>Your OTP is: <h2>$otp</h2><br>This code is valid for a few minutes only.<br><br>Secure Exam System";
        
                $mail->send();
        
                // ✅ Proper Redirect to OTP Page
                header("Location: verify_otp.php");
                exit();
        
            } catch (Exception $e) {
                $error_message = "❌ Failed to send OTP. Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            $error_message = "❌ Incorrect password. Please try again!";
        }
    } else {
        $error_message = "❌ Student ID not found!";
    }

    $stmt->close();
}
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            width: 40%;
            margin: 80px auto;
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            border: 2px solid #00416a;
        }
        .container h2 {
            color: #00416a;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .container input[type="text"],
        .container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .container button {
            width: 90%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .container button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
        .forgot-link {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #6f42c1;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📚 Student Login Portal 🎓</h2>

    <!-- Display error messages -->
    <?php if (!empty($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- Login Form -->
    <form action="student_login.php" method="POST">
        <input type="text" name="student_id" placeholder="👤 Enter Your Student ID" required>
        <input type="password" name="password" placeholder="🔒 Enter Your Password" required>
        <button type="submit">✅ Login</button>
    </form>

    <a href="forgot_password.php" class="forgot-link">❓ Forgot Password?</a>
    <p class="info">🔑 Default Password: <b>student123</b></p> </div>
</div>

</body>
</html>