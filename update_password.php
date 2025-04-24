<?php
include "db_connection.php";
include 'navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Determine the user type and update the respective table
    $tables = ["students", "lecturers"];
    $updated = false;

    foreach ($tables as $table) {
        $stmt = $conn->prepare("UPDATE $table SET password=? WHERE user_id=?");
        $stmt->bind_param("ss", $hashed_password, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $updated = true;
            break;
        }
    }

    if ($updated) {
        echo "Password updated successfully. <a href='login.php'>Login</a>";
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
