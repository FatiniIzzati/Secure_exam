<?php
session_start();
include "db_connection.php";

if (!isset($_SESSION["student_id"])) {
    header("Location: student_login.php");
    exit();
}

// Get current date & time
$current_date = date("Y-m-d");
$current_datetime = date("Y-m-d H:i:s");

// Fetch exams
$todayExamQuery = $conn->query("SELECT * FROM exams WHERE exam_date = '$current_date' ORDER BY exam_time ASC");
$allExamQuery = $conn->query("SELECT * FROM exams ORDER BY exam_date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Exams</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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
        .section-title {
            text-align: left;
            color: #00416a;
            margin-bottom: 10px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #00416a;
            color: white;
        }
        .btn {
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        .btn-disabled {
            background-color: #ccc;
            color: #666;
            cursor: not-allowed;
            pointer-events: none;
            text-decoration: none;
        }
        .back-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #17a2b8;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }
        .back-btn:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📆 Available Today (<?php echo date("l, F j, Y"); ?>)</h2>

    <!-- Today's exams -->
    <p class="section-title">Exams Scheduled for Today:</p>
    <table>
        <thead>
            <tr>
                <th>Exam Code</th>
                <th>Exam Name</th>
                <th>Time</th>
                <th>Duration</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($todayExamQuery->num_rows > 0): ?>
                <?php while ($exam = $todayExamQuery->fetch_assoc()): ?>
                    <?php
                    $exam_datetime = $exam["exam_date"] . " " . $exam["exam_time"];
                    $buttonClass = "btn";
                    $buttonText = "Start";
                    $buttonDisabled = false;

                    if ($current_datetime > $exam_datetime) {
                        $buttonClass = "btn-disabled";
                        $buttonText = "Expired";
                        $buttonDisabled = true;
                    }
                    ?>
                    <tr>
                        <td><?php echo $exam["exam_code"]; ?></td>
                        <td><?php echo $exam["exam_name"]; ?></td>
                        <td><?php echo $exam["exam_time"]; ?></td>
                        <td><?php echo $exam["duration"]; ?> min</td>
                        <td>
                            <?php if ($buttonDisabled): ?>
                                <span class="<?php echo $buttonClass; ?>"><?php echo $buttonText; ?></span>
                            <?php else: ?>
                                <a href="start_exam.php?exam_code=<?php echo urlencode($exam['exam_code']); ?>" class="<?php echo $buttonClass; ?>"><?php echo $buttonText; ?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No exams scheduled for today.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- All exams -->
    <p class="section-title">All Upcoming Exams:</p>
    <table>
        <thead>
            <tr>
                <th>Exam Code</th>
                <th>Exam Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Duration</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($exam = $allExamQuery->fetch_assoc()): ?>
                <?php
                $exam_datetime = $exam["exam_date"] . " " . $exam["exam_time"];
                $buttonClass = "btn";
                $buttonText = "Start";
                $buttonDisabled = false;

                if ($current_datetime > $exam_datetime) {
                    $buttonClass = "btn-disabled";
                    $buttonText = "Expired";
                    $buttonDisabled = true;
                }
                ?>
                <tr>
                    <td><?php echo $exam["exam_code"]; ?></td>
                    <td><?php echo $exam["exam_name"]; ?></td>
                    <td><?php echo $exam["exam_date"]; ?></td>
                    <td><?php echo $exam["exam_time"]; ?></td>
                    <td><?php echo $exam["duration"]; ?> min</td>
                    <td>
                        <?php if ($buttonDisabled): ?>
                            <span class="<?php echo $buttonClass; ?>"><?php echo $buttonText; ?></span>
                        <?php else: ?>
                            <a href="start_exam.php?exam_code=<?php echo urlencode($exam['exam_code']); ?>" class="<?php echo $buttonClass; ?>"><?php echo $buttonText; ?></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="student_dashboard.php" class="back-btn">Back</a>
</div>

</body>
</html>
