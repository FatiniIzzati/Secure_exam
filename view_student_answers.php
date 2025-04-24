<?php
session_start();
include "db_connection.php"; // Ensure the database connection is included

// Check if the lecturer is logged in
if (!isset($_SESSION["lecturer_id"])) {
    header("Location: lecturer_login.php");
    exit();
}

// Fetch distinct Exam Codes and Student IDs
$examStudentQuery = "SELECT DISTINCT sa.student_id, sa.exam_code 
                     FROM student_answers sa 
                     JOIN exams e ON sa.exam_code = e.exam_code";
$examStudentResult = $conn->query($examStudentQuery);

// Get selected student ID and exam code from dropdown
$selected_student_id = isset($_POST["student_id"]) ? $_POST["student_id"] : "";

// Fetch answers for the selected student and exam code
$answersQuery = "SELECT sa.student_id, sa.exam_code, q.question_text, 
                 sa.selected_answer, q.correct_answer 
                 FROM student_answers sa
                 JOIN questions q ON sa.question_id = q.question_id";

if (!empty($selected_student_id)) {
    $answersQuery .= " WHERE sa.student_id = ? ORDER BY sa.exam_code, q.question_id";
}

$stmt = $conn->prepare($answersQuery);
if (!empty($selected_student_id)) {
    $stmt->bind_param("s", $selected_student_id);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Student Answers</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fbfc; /* Soft background */
        }

        /* Main Content Styling */
        .container {
            margin-top: 80px; /* Space for navbar */
            max-width: 800px; /* Limit container width */
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Elegant shadow */
            margin-left: auto;
            margin-right: auto; /* Center container */
        }

        h2 {
            text-align: center;
            color: #00416a;
            margin-bottom: 20px;
        }

        /* Dropdown Form */
        form {
            text-align: center;
            margin-bottom: 20px;
        }

        select, button {
            padding: 10px;
            font-size: 16px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }

        button {
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle Shadow */
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #00416a; /* Navy Blue */
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1; /* Light Hover */
        }

        /* Correct and Wrong Answers */
        .correct {
            color: green;
            font-weight: bold;
        }

        .wrong {
            color: red;
            font-weight: bold;
        }

        /* Message */
        .message {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #666;
            margin-top: 20px;
        }

        /* Back Button Styling */
        .back-btn {
            display: block;
            text-align: center;
            margin: 20px auto;
            padding: 12px 20px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .back-btn:hover {
            background-color: #5a6268;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📄 View Student Answers</h2>

    <!-- Dropdown Form -->
    <form method="POST" action="">
        <select name="student_id" id="student_id">
            <option value="">-- Select Student --</option>
            <?php while ($row = $examStudentResult->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['student_id']); ?>" 
                    <?php echo ($selected_student_id == $row['student_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($row['exam_code']) . " - " . htmlspecialchars($row['student_id']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">View Answers</button>
    </form>

    <!-- Show Message if No Student Selected -->
    <?php if (empty($selected_student_id)): ?>
        <p class="message">Select Student</p>
    <?php else: ?>

    <!-- Show Answers -->
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Exam Code</th>
                <th>Question</th>
                <th>Selected Answer</th>
                <th>Correct Answer</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                <td><?php echo htmlspecialchars($row['exam_code']); ?></td>
                <td><?php echo htmlspecialchars($row['question_text']); ?></td>
                <td class="<?php echo ($row['selected_answer'] == $row['correct_answer']) ? 'correct' : 'wrong'; ?>">
                    <?php echo htmlspecialchars($row['selected_answer']); ?>
                </td>
                <td><?php echo htmlspecialchars($row['correct_answer']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php endif; ?>

    
    <!-- Back Button -->
    <a href="lecturer_dashboard.php">
        <button class="back-btn">Back </button>
    </a>
</div>

</body>
</html>
