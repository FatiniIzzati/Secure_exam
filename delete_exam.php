<?php
include "db_connection.php";

if (isset($_GET['exam_code'])) {
    $exam_code = $_GET['exam_code'];

    // Validate if the exam exists
    $checkQuery = "SELECT * FROM exams WHERE exam_code = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $exam_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Invalid exam code. Exam does not exist.'); window.location.href='manage_exams.php';</script>";
        exit();
    }

    // Delete related questions first
    $deleteQuestionsQuery = "DELETE FROM questions WHERE exam_code = ?";
    $stmt = $conn->prepare($deleteQuestionsQuery);
    $stmt->bind_param("s", $exam_code);
    $stmt->execute();

    // Now delete the exam
    $deleteExamQuery = "DELETE FROM exams WHERE exam_code = ?";
    $stmt = $conn->prepare($deleteExamQuery);
    $stmt->bind_param("s", $exam_code);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Exam deleted successfully.'); window.location.href='manage_exams.php';</script>";
    } else {
        echo "<script>alert('❌ Error deleting exam.'); window.location.href='manage_exams.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid exam code. Parameter missing.'); window.location.href='manage_exams.php';</script>";
}
?>
