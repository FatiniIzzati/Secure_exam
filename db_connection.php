<?php include 'navbar.php'; 

$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP has no password
$database = "secure_examination";  // Change to your database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
