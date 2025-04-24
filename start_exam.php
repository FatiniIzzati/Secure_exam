<?php
session_start();
include "db_connection.php";

if (!isset($_SESSION["student_id"])) {
    header("Location: student_login.php");
    exit();
}

if (!isset($_GET['exam_code'])) {
    echo "Invalid exam.";
    exit();
}

$exam_code = $_GET['exam_code'];

// Fetch exam details
$examQuery = $conn->prepare("SELECT * FROM exams WHERE exam_code = ?");
$examQuery->bind_param("s", $exam_code);
$examQuery->execute();
$examResult = $examQuery->get_result();

if ($examResult->num_rows == 0) {
    echo "Exam not found.";
    exit();
}

$exam = $examResult->fetch_assoc();

// Fetch exam questions
$questionsQuery = $conn->prepare("SELECT * FROM questions WHERE exam_code = ? ORDER BY exam_code ASC");
$questionsQuery->bind_param("s", $exam_code);
$questionsQuery->execute();
$questionsResult = $questionsQuery->get_result();

// Check if there are any questions
if ($questionsResult->num_rows == 0) {
    echo "<p>No questions found for this exam.</p>";
    exit();
}

$_SESSION['exam_code'] = $exam_code;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($exam['exam_name']); ?> - Exam</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        .question {
            margin-bottom: 15px;
        }
        .options input {
            margin-right: 10px;
        }
        .submit-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2><?php echo htmlspecialchars($exam['exam_name']); ?></h2>
        <p><strong>Exam Code:</strong> <?php echo htmlspecialchars($exam['exam_code']); ?></p>
        <p><strong>Duration:</strong> <?php echo htmlspecialchars($exam['duration']); ?> minutes</p>

        <form action="submit_exam.php" method="POST">
    <?php 
    $question_number = 1;
    while ($question = $questionsResult->fetch_assoc()): 
    ?>
        <div class="question">
            <p><strong><?php echo $question_number . ". " . htmlspecialchars($question['question_text']); ?></strong></p>
            <div class="options">
                <label>
                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="A" required> 
                    <?php echo htmlspecialchars($question['option_a']); ?>
                </label><br>
                <label>
                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="B"> 
                    <?php echo htmlspecialchars($question['option_b']); ?>
                </label><br>
                <label>
                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="C"> 
                    <?php echo htmlspecialchars($question['option_c']); ?>
                </label><br>
                <label>
                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="D"> 
                    <?php echo htmlspecialchars($question['option_d']); ?>
                </label><br>
            </div>
        </div>
    <?php 
    $question_number++;
    endwhile; 
    ?>

    <input type="hidden" name="exam_code" value="<?php echo htmlspecialchars($exam_code); ?>">
    <button type="submit" class="submit-btn">Submit Exam</button>
    <a href="student_dashboard.php" class="back-btn">Back</a>
</form>

    </div>

</body>
</html>
