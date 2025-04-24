<?php
include("db_connection.php"); // Ensure this file exists and connects to MySQL properly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are set
    if (isset($_POST["admin_id"], $_POST["name"], $_POST["email"], $_POST["password"])) {
        
        // Retrieve form data
        $admin_id = $_POST["admin_id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // Prepare SQL statement
        $sql = "INSERT INTO admin (admin_id, name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $admin_id, $name, $email, $password);

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
    <title>Admin Register</title>
</head>
<body>

<h2>Admin Registration</h2>

<form action="admin_register.php" method="post">
    <label for="admin_id">Admin ID:</label>
    <input type="text" id="admin_id" name="admin_id" required><br><br>

    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Register</button>
</form>

</body>
</html>
