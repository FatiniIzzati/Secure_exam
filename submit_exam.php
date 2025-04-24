<?php
session_start();
include "db_connection.php"; // Ensure this file correctly connects to your database

// Check if the student is logged in
if (!isset($_SESSION["student_id"])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION["student_id"];

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["exam_code"]) && isset($_POST["answer"])) {
    $exam_code = $_POST["exam_code"];
    $answers = $_POST["answer"]; // Associative array [question_id => selected_answer]

    // Process each answer
    foreach ($answers as $question_id => $selected_answer) {
        // Get the correct answer from the database based on question_id
        $query = $conn->prepare("SELECT correct_answer FROM questions WHERE question_id = ?");
        $query->bind_param("i", $question_id);
        $query->execute();
        $result = $query->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $correct_answer = $row["correct_answer"];

            // Check if the selected answer is correct
            $is_correct = ($selected_answer == $correct_answer) ? 1 : 0;

            // Insert student's answer into the database
            $insertQuery = $conn->prepare("INSERT INTO student_answers (student_id, exam_code, question_id, selected_answer, is_correct) VALUES (?, ?, ?, ?, ?)");
            $insertQuery->bind_param("ssisi", $student_id, $exam_code, $question_id, $selected_answer, $is_correct);
            $insertQuery->execute();
        }
    }

    // Redirect to a confirmation page or dashboard
    header("Location: student_dashboard.php?message=Exam submitted successfully");
    exit();
} else {
    echo "Invalid request!";
}
?>
