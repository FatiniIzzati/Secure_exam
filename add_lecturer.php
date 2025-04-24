<?php
include "db_connection.php";

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lecturer_id = trim($_POST["lecturer_id"]);
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);

    // Default password: lecturer123 (hashed)
    $default_password = "lecturer123";
    $hashed_password = password_hash($default_password, PASSWORD_BCRYPT);

    // Insert lecturer data
    $sql = "INSERT INTO lecturers (lecturer_id, name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $lecturer_id, $name, $email, $hashed_password);

    if ($stmt->execute()) {
        $success_message = "✅ Lecturer added successfully! Default password: lecturer123";
    } else {
        $error_message = "❌ Error adding lecturer! " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Lecturer</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fbfc; /* Soft blue-gray background */
        }
        /* Navbar Styling */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #00416a; /* Navy Blue */
            padding: 10px 20px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .navbar .logo {
            display: flex;
            align-items: center;
        }
        .navbar img {
            height: 40px;
            margin-right: 10px;
        }
        .navbar h1 {
            font-size: 18px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 30px;
            font-size: 16px;
        }
        .navbar a:hover {
            color: #f4f4f4;
        }
        /* Main Content Styling */
        .container {
            margin-top: 100px; /* Prevent overlap with navbar */
            max-width: 600px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        h2 {
            font-size: 24px;
            color: #00416a;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            text-align: left;
            font-weight: bold;
            color: #333;
        }
        input {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }
        button {
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            transform: scale(1.05); /* Interactive hover effect */
        }
        .add-btn {
            background-color: #28a745; /* Green */
            color: white;
        }
        .back-btn {
            background-color: #6c757d; /* Neutral gray */
            color: white;
        }
        .back-btn:hover {
            background-color: #5a6268;
        }
        .success {
            color: green;
            font-size: 16px;
            margin-top: 10px;
        }
        .error {
            color: red;
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Main Content -->
<div class="container">
    <h2>👩‍🏫 Add New Lecturer</h2>
    <?php if ($error_message) echo "<p class='error'>$error_message</p>"; ?>
    <?php if ($success_message) echo "<p class='success'>$success_message</p>"; ?>

    <form action="add_lecturer.php" method="POST">
        <label for="lecturer_id">Lecturer ID:</label>
        <input type="text" name="lecturer_id" id="lecturer_id" placeholder="e.g., L-001" required>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" placeholder="Full Name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="e.g., lecturer@example.com" required>

        <p><small>Default password: <b>lecturer123</b></small></p>

        <button type="submit" class="btn add-btn">Add Lecturer</button>
    </form>
    <br>
    <a href="manage_lecturers.php">
        <button type="button" class="btn back-btn"> Back</button>
    </a>
</div>

</body>
</html>
