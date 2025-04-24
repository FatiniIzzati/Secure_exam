<?php
include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_code = trim($_POST["exam_code"]);
    $exam_name = trim($_POST["exam_name"]);
    $exam_date = $_POST["exam_date"];
    $exam_time = $_POST["exam_time"];
    $duration = trim($_POST["duration"]);

    // Check if exam code already exists
    $checkQuery = "SELECT * FROM exams WHERE exam_code = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $exam_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p class='error'>❌ Exam Code already exists! Please use a different code.</p>";
    } else {
        // Insert the exam
        $sql = "INSERT INTO exams (exam_code, exam_name, exam_date, exam_time, duration) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $exam_code, $exam_name, $exam_date, $exam_time, $duration);

        if ($stmt->execute()) {
            echo "<p class='success'>✅ Exam added successfully! (Code: $exam_code)</p>";
        } else {
            echo "<p class='error'>❌ Error: " . $stmt->error . "</p>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Exam</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fbfc; /* Soft blue-gray background */
        }
        /* Navbar Styling */
        .navbar {
            position: fixed; /* Keeps navbar at the top */
            top: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #00416a; /* Navy Blue */
            padding: 10px 20px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            z-index: 1000; /* Ensures navbar stays on top */
        }
        .navbar .logo {
            display: flex;
            align-items: center;
        }
        .navbar img {
            height: 50px; /* Logo size */
            margin-right: 10px;
        }
        .navbar h1 {
            flex-grow: 1;
            text-align: center;
            margin: 0;
            font-size: 18px; /* Title font size */
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 30px; /* Space between links */
            font-size: 16px; /* Link font size */
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color: #e6e6e6; /* Slightly lighter on hover */
        }
        /* Main Container Styling */
        .container {
            margin-top: 100px; /* Prevent overlap with navbar */
            width: 90%;
            max-width: 600px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for container */
            text-align: center;
            margin-left: auto;
            margin-right: auto; /* Centers the container */
        }
        h2 {
            font-size: 24px;
            color: #00416a; /* Navy blue for headings */
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        input {
            padding: 12px 15px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            transform: scale(1.05); /* Slight hover effect */
        }
        .add-btn {
            background-color: #28a745; /* Green for add exam button */
            color: white;
        }
        .back-btn {
            background-color: #6c757d; /* Neutral gray for back button */
            color: white;
        }
        .back-btn:hover {
            background-color: #5a6268;
        }
        .error {
            color: red;
            font-size: 16px;
            margin-top: 10px;
        }
        .success {
            color: green;
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>




<!-- Main Content -->
<div class="container">
    <h2>➕ Add New Exam</h2>
    <form method="POST">
        <input type="text" name="exam_code" placeholder="Exam Code (e.g. EX-101)" required>
        <input type="text" name="exam_name" placeholder="Exam Name" required>
        <input type="date" name="exam_date" required>
        <input type="time" name="exam_time" required>
        <input type="text" name="duration" placeholder="Duration (e.g. 60 minutes)" required>
        <button type="submit" class="add-btn">Add Exam</button>
    </form>
    <br>
    <a href="manage_exams.php">
        <button class="back-btn"> Back</button>
    </a>
</div>

</body>
</html>
