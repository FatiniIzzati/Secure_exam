<?php
session_start();
include "db_connection.php";

// Ensure the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if exam_code is provided in the URL
if (!isset($_GET['exam_code'])) {
    echo "<script>alert('Invalid request. No exam code provided.'); window.location.href='manage_exams.php';</script>";
    exit();
}

$exam_code = $_GET['exam_code'];

// Fetch the exam details
$sql = "SELECT * FROM exams WHERE exam_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $exam_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Exam not found.'); window.location.href='manage_exams.php';</script>";
    exit();
}

$exam = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_name = $_POST["exam_name"];
    $exam_date = $_POST["exam_date"];
    $exam_time = $_POST["exam_time"];
    $duration = $_POST["duration"];

    // Update the exam details
    $update_sql = "UPDATE exams SET exam_name = ?, exam_date = ?, exam_time = ?, duration = ? WHERE exam_code = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssss", $exam_name, $exam_date, $exam_time, $duration, $exam_code);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Exam updated successfully!'); window.location.href='manage_exams.php';</script>";
    } else {
        echo "<script>alert('❌ Error updating exam.');</script>";
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Exam</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-container {
            text-align: center;
            margin-top: 15px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
        }
        .btn.update { background-color: green; }
        .btn.back { background-color: gray; }
        .btn:hover { opacity: 0.8; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Exam</h2>
    
    <form method="POST">
        <div class="form-group">
            <label>Exam Code (Cannot be changed)</label>
            <input type="text" value="<?php echo htmlspecialchars($exam['exam_code']); ?>" disabled>
        </div>

        <div class="form-group">
            <label>Exam Name</label>
            <input type="text" name="exam_name" value="<?php echo htmlspecialchars($exam['exam_name']); ?>" required>
        </div>

        <div class="form-group">
            <label>Exam Date</label>
            <input type="date" name="exam_date" value="<?php echo htmlspecialchars($exam['exam_date']); ?>" required>
        </div>

        <div class="form-group">
            <label>Exam Time</label>
            <input type="time" name="exam_time" value="<?php echo htmlspecialchars($exam['exam_time']); ?>" required>
        </div>

        <div class="form-group">
            <label>Duration (Minutes)</label>
            <input type="text" name="duration" value="<?php echo htmlspecialchars($exam['duration']); ?>" required>
        </div>

        <div class="btn-container">
            <button type="submit" class="btn update">Update Exam</button>
            <a href="manage_exams.php" class="btn back">Back</a>
        </div>
    </form>
</div>

</body>
</html>
