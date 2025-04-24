<?php 
session_start();
include "db_connection.php"; // Ensure database connection is correct

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = trim($_POST["admin_id"]);
    $password = trim($_POST["password"]);

    // Fetch admin data from database
    $sql = "SELECT * FROM admin WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Check if password is hashed or stored as plain text
            if (password_verify($password, $row["password"]) || $password === $row["password"]) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);

                // Set session variables
                $_SESSION["admin_id"] = $row["admin_id"];
                $_SESSION["admin_name"] = $row["name"];

                // Redirect to admin dashboard
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $error_message = "❌ Incorrect password. Please try again!";
            }
        } else {
            $error_message = "❌ Admin ID not found!";
        }

        $stmt->close();
    } else {
        $error_message = "❌ Database error. Please try again later.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4; /* Soft background */
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
            background-color:rgb(238, 12, 201); /* Blue button for admin */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .container button:hover {
            background-color:rgb(238, 12, 201);
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
        .info {
            color: #00416a;
            font-size: 14px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🔒 Admin Login Portal 🔑</h2>

    <!-- Display error messages -->
    <?php if (!empty($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- Login Form -->
    <form action="admin_login.php" method="POST">
        <input type="text" name="admin_id" placeholder="👤 Enter Your Admin ID" required>
        <input type="password" name="password" placeholder="🔒 Enter Your Password" required>
        <button type="submit">✅ Login</button>
    </form>

    
</div>

</body>
</html>
