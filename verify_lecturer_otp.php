<?php
session_start();


// If OTP or lecturer email not set, redirect to login
if (!isset($_SESSION["otp"]) || !isset($_SESSION["lecturer_email"])) {
    header("Location: lecturer_login.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = isset($_POST["otp"]) ? trim($_POST["otp"]) : "";


    if ((string)$entered_otp === (string)$_SESSION["otp"]) {

        // OTP correct
        unset($_SESSION["otp"]); // Optional: clear OTP
        header("Location: lecturer_dashboard.php"); // Redirect to dashboard
        exit();
    } else {
        $error = "❌ Incorrect OTP. Please try again!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }
        .container {
            margin-top: 100px;
            width: 40%;
            margin-left: auto;
            margin-right: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            border: 2px solid #00416a;
        }
        input {
            width: 90%;
            padding: 10px;
            font-size: 16px;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        button {
            padding: 12px 30px;
            font-size: 16px;
            background: #00416a;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .error {
            color: red;
        }
        .info {
            margin-bottom: 15px;
            color: green;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🔐 Verify OTP</h2>
    
    <p class="info">OTP has been sent to your email: <b><?php echo $_SESSION["lecturer_email"]; ?></b></p>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post" id="otpForm">
    <div style="display: flex; justify-content: center; gap: 10px;">
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <input type="text" name="otp_digit_<?php echo $i; ?>" maxlength="1" pattern="\d" required 
                   oninput="moveToNext(this, <?php echo $i; ?>)"
                   style="width: 40px; height: 40px; font-size: 20px; text-align: center;">
        <?php endfor; ?>
    </div>
    <input type="hidden" name="otp" id="fullOtp">
    <br>
    <button type="submit">Verify</button>
</form>

<script>
    function moveToNext(current, index) {
        let value = current.value;
        if (value.length === 1 && index < 6) {
            document.querySelector(`input[name=otp_digit_${index + 1}]`).focus();
        }
    }

    document.getElementById("otpForm").addEventListener("submit", function(e) {
        let otp = "";
        for (let i = 1; i <= 6; i++) {
            let digit = document.querySelector(`input[name=otp_digit_${i}]`).value;
            if (!digit.match(/[0-9]/)) {
                e.preventDefault();
                alert("Please enter all 6 digits of the OTP.");
                return;
            }
            otp += digit;
        }
        document.getElementById("fullOtp").value = otp;
    });
</script>

</div>
</body>
</html>
