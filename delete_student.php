<?php
include "db_connection.php";
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $sql = "DELETE FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);

    if ($stmt->execute()) {
        echo "<script>alert('Student deleted successfully!'); window.location.href='manage_students.php';</script>";
    } else {
        echo "<script>alert('Error deleting student!');</script>";
    }
}
?>
