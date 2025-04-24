<?php
include "db_connection.php";

// Fetch exams with questions
$sql = "SELECT e.exam_code, e.exam_name, q.question_text 
        FROM exams e 
        LEFT JOIN questions q ON e.exam_code = q.exam_code 
        ORDER BY e.exam_code";

$result = $conn->query($sql);

$exams = [];
while ($row = $result->fetch_assoc()) {
    $exams[$row['exam_code']]['exam_name'] = $row['exam_name'];
    if (!empty($row['question_text'])) {
        $exams[$row['exam_code']]['questions'][] = $row['question_text'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Exams</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fbfc; /* Soft background */
        }
        /* Navbar Styling */
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }
        .navbar {
            width: 100%;
            background-color: #00416a; /* Navy Blue */
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        .navbar .logo {
            display: flex;
            align-items: center;
        }
        .navbar img {
            height: 50px; /* Original logo size */
            margin-right: 10px;
        }
        .navbar h1 {
            margin: 0;
            font-size: 20px; /* Original title font size */
        }
        .navbar a {
            color: white;
            text-decoration: none; /* Remove underline */
            margin: 0 30px; /* Space between links */
            font-size: 16px; /* Link font size */
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color: #f4f4f4; /* Lighter shade for hover */

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
        .exam-container {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            background: #f1f1f1;
            margin-bottom: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        .exam-container p {
            font-size: 18px;
            font-weight: bold;
        }
        .dropdown-content {
            display: none;
            margin-top: 10px;
            padding-left: 20px;
        }
        .dropdown-content ol {
            margin: 0;
            padding: 0;
        }
        button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .back-button {
            display: block;
            margin: 20px auto;
            padding: 12px 20px;
            background-color: #6c757d;
            color: white;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
    <script>
        function toggleDropdown(examCode) {
            var content = document.getElementById("questions_" + examCode);
            content.style.display = (content.style.display === "none" || content.style.display === "") ? "block" : "none";
        }
    </script>
</head>
<body>

<!-- Main Content -->
<div class="container">
    <h2>📚 All Exams</h2>

    <?php foreach ($exams as $exam_code => $exam) { ?>
        <div class="exam-container">
            <p><?php echo $exam['exam_name']; ?> (Code: <?php echo $exam_code; ?>)</p>
            <button onclick="toggleDropdown('<?php echo $exam_code; ?>')">Show Questions</button>
            <div id="questions_<?php echo $exam_code; ?>" class="dropdown-content">
                <ol>
                    <?php if (!empty($exam['questions'])) { 
                        foreach ($exam['questions'] as $index => $question) { ?>
                            <li><?php echo $question; ?></li>
                        <?php } 
                    } else { ?>
                        <li>No questions added yet.</li>
                    <?php } ?>
                </ol>
            </div>
        </div>
    <?php } ?>

    <a href="admin_dashboard.php" class="back-button">⬅ Back</a>
</div>

</body>
</html>
