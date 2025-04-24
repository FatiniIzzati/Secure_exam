<?php
include("db_connection.php"); // Ensure this file exists and connects to MySQL properly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are set
    if (isset($_POST["student_id"], $_POST["name"], $_POST["email"], $_POST["password"])) {
        
        // Retrieve form data
        $student_id = $_POST["student_id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // Prepare SQL statement
        $sql = "INSERT INTO students (student_id, name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $student_id, $name, $email, $password);

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .registration-container {
            width: 50%;
            margin: 80px auto;
            padding: 30px;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Smooth shadow */
            border-radius: 15px;
            border: 2px solid #00416a; /* Navy blue */
            text-align: left;
        }
        .registration-container h2 {
            color: #00416a; /* Navy Blue */
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
        }
        .registration-container label {
            font-size: 16px;
            color: #555;
            display: block;
            margin: 15px 0 5px;
        }
        .registration-container input[type="text"],
        .registration-container input[type="email"],
        .registration-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .btn {
            width: 48%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-register {
            background: #28a745; /* Green */
        }
        .btn-login {
            background: #17a2b8; /* Teal */
        }
        .btn:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }
        .note {
            margin-top: 15px;
            font-size: 14px;
            color: #00416a; /* Navy blue */
            text-align: center;
        }
    </style>
</head>
<body>

<div class="registration-container">
    <h2>📝 Student Registration Portal 🎓</h2>
    
    <!-- Registration Form -->
    <form action="student_register_process.php" method="POST">
        <label for="student_id">📚 Student ID:</label>
        <input type="text" id="student_id" name="student_id" placeholder="Enter your Student ID" required>
        
        <label for="full_name">👤 Full Name:</label>
        <input type="text" id="name" name="full_name" placeholder="Enter your Full Name" required>
        
        <label for="email">📧 Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your Email" required>
        
        <label for="password">🔒 Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your Password" required>
        
        <!-- Buttons -->
        <div class="btn-container">
            <button type="submit" class="btn btn-register">✅ Register</button>
            <button type="button" class="btn btn-login" onclick="window.location.href='student_login.php';">🔑 Login</button>
        </div>
    </form>
    
    <p class="note">🔹 Please use a secure password for registration.</p>
</div>

</body>
</html>
