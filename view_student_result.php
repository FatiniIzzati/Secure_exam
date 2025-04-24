<?php
session_start();
include "db_connection.php";

// Check if user is a lecturer
if (!isset($_SESSION["lecturer_id"])) {
    header("Location: lecturer_login.php");
    exit();
}

// Get selected exam code if any
$selected_exam = isset($_GET['exam_code']) ? $_GET['exam_code'] : '';

// Fetch distinct exam codes for dropdown
$exam_query = "SELECT DISTINCT exam_code FROM student_answers";
$exam_result = $conn->query($exam_query);

// Only fetch student results if an exam code is selected
$results = [];
if (!empty($selected_exam)) {
    $sql = "SELECT student_id, exam_code, SUM(is_correct) AS correct_answers, COUNT(*) AS total_questions 
            FROM student_answers 
            WHERE exam_code = ?
            GROUP BY student_id, exam_code";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selected_exam);
    $stmt->execute();
    $results = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Results</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fbfc; /* Soft blue-gray background */
        }

        .container {
            margin-top: 80px;
            max-width: 900px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Elegant shadow */
            margin-left: auto;
            margin-right: auto;
        }

        h2 {
            text-align: center;
            color: #00416a;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }

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
            background-color: #00416a;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .no-results {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }

        .back-btn {
            display: block;
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
    <h2>📊 View Results</h2>

    <!-- Dropdown Form -->
    <form method="GET" action="">
        <label for="exam_code">Select Exam Code:</label>
        <select name="exam_code" id="exam_code" onchange="this.form.submit()">
            <option value="">-- Select Exam Code --</option>
            <?php while ($exam = $exam_result->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($exam['exam_code']); ?>" 
                    <?php echo ($selected_exam == $exam['exam_code']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($exam['exam_code']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php if (!empty($selected_exam)): ?>
        <?php if ($results->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Student ID</th>
                    <th>Exam Code</th>
                    <th>Correct Answers</th>
                    <th>Total Questions</th>
                    <th>Score (%)</th>
                </tr>

                <?php while ($row = $results->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['exam_code']); ?></td>
                    <td><?php echo $row['correct_answers']; ?></td>
                    <td><?php echo $row['total_questions']; ?></td>
                    <td><?php echo round(($row['total_questions'] > 0 ? ($row['correct_answers'] / $row['total_questions']) * 100 : 0), 2); ?>%</td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="no-results">No results found for exam code <strong><?php echo htmlspecialchars($selected_exam); ?></strong>.</p>
        <?php endif; ?>
    <?php endif; ?>

    <a href="lecturer_dashboard.php">
        <button class="back-btn">Back </button>
    </a>
</div>

</body>
</html>
