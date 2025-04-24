<?php
include "db_connection.php";

// Get exam_code from URL if available
$exam_code = isset($_GET["exam_code"]) ? $_GET["exam_code"] : null;

// Fetch available exams
$examQuery = "SELECT exam_code FROM exams";
$result = $conn->query($examQuery);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Questions</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9fbfc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        h2 {
            text-align: center;
            color: #00416a;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        select, input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .question-block {
            background: #eef4ff;
            padding: 15px;
            margin-top: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        button {
            padding: 10px 15px;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        .submit-btn {
            background-color: #007bff;
            color: white;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
        .back-btn {
            background-color: #6c757d;
            color: white;
        }
        .back-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📝 Add Exam Questions</h2>
    <form method="POST" onsubmit="return validateForm();">
    <label>Select Exam:</label>
    <select name="exam_code" required>
        <option value="">-- Select Exam --</option>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <option value="<?php echo $row['exam_code']; ?>" 
                <?php if ($exam_code == $row['exam_code']) echo "selected"; ?>>
                <?php echo $row['exam_code']; ?>
            </option>
        <?php } ?>
    </select><br>
    
        <div id="questions-container">
            <?php for ($i = 1; $i <= 40; $i++) { ?>
                <div class="question-block">
                    <label>Question <?php echo $i; ?></label>
                    <input type="text" name="questions[<?php echo $i; ?>][question_text]" placeholder="Enter the question">
                    <input type="text" name="questions[<?php echo $i; ?>][option_a]" placeholder="Option A">
                    <input type="text" name="questions[<?php echo $i; ?>][option_b]" placeholder="Option B">
                    <input type="text" name="questions[<?php echo $i; ?>][option_c]" placeholder="Option C">
                    <input type="text" name="questions[<?php echo $i; ?>][option_d]" placeholder="Option D">

                    <label>Correct Answer:</label>
                    <select name="questions[<?php echo $i; ?>][correct_answer]">
                        <option value="">--Select--</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
            <?php } ?>
        </div>

        <div class="btn-container">
            <a href="manage_exams.php"><button type="button" class="back-btn">Back</button></a>
            <button type="submit" class="submit-btn">Submit Questions</button>
        </div>
    </form>
</div>
<script>
function validateForm() {
    let questionBlocks = document.querySelectorAll(".question-block");
    let filledCount = 0;

    questionBlocks.forEach(block => {
        let question = block.querySelector("input[name^='questions'][name$='[question_text]']").value;
        let correctAnswer = block.querySelector("select[name^='questions'][name$='[correct_answer]']").value;
        
        if (question.trim() !== "" && correctAnswer.trim() !== "") {
            filledCount++;
        }
    });

    if (filledCount < 15) {
        alert("Please fill at least 15 questions before submitting.");
        return false;
    }

    return true;
}
</script>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_code = $_POST["exam_code"];
    $questions = $_POST["questions"];

    $stmt = $conn->prepare("INSERT INTO questions (exam_code, question_text, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?)");

    foreach ($questions as $q) {
        if (!empty($q["question_text"]) && !empty($q["correct_answer"])) {
            $stmt->bind_param("sssssss", $exam_code, $q["question_text"], $q["option_a"], $q["option_b"], $q["option_c"], $q["option_d"], $q["correct_answer"]);
            $stmt->execute();
        }
    }

    echo "<p style='color: green;'>✅ Questions added successfully!</p>";
    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
