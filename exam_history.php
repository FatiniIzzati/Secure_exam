<?php
session_start();
include "db_connection.php";

if (!isset($_SESSION["student_id"])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION["student_id"];

// Fetch completed exams for the logged-in student (DISTINCT exam_code ensures only unique exams are listed)
$historyQuery = $conn->query("SELECT DISTINCT exams.exam_code, exams.exam_name 
                              FROM student_answers 
                              INNER JOIN exams ON student_answers.exam_code = exams.exam_code 
                              WHERE student_answers.student_id = '$student_id' 
                              ORDER BY exams.exam_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam History</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #00416a;
            color: white;
            padding: 10px 20px;
        }
        .navbar h1 {
            margin: 0;
            font-size: 20px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #00416a;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #00416a;
            color: white;
            font-size: 16px;
            padding: 10px;
        }
        td {
            padding: 10px;
            text-align: center;
        }
        .back-btn {
    display: block; /* Enables centering */
    margin-top: 15px;
    margin-left: auto;
    margin-right: auto;
    padding: 10px 15px; /* Reduced padding for a smaller size */
    background-color: #17a2b8;
    color: white;
    border-radius: 3px; /* Smaller border radius */
    text-decoration: none;
    font-size: 15px; /* Smaller font size */
    text-align: center;
    width: fit-content; /* Shrinks button to fit text */
}

        .back-btn:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>


<div class="container">
    <h2>📜 Completed Exams</h2>
    <table>
        <thead>
            <tr>
                <th>Exam Code</th>
                <th>Exam Name</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($historyQuery->num_rows > 0): ?>
                <?php while ($exam = $historyQuery->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($exam["exam_code"]); ?></td>
                        <td><?php echo htmlspecialchars($exam["exam_name"]); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No completed exams found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div style="text-align: center;">
    <a href="student_dashboard.php" class="back-btn"> Back </a>
</div>


</body>
</html>
