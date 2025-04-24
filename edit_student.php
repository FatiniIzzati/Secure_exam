<?php
include "db_connection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch student details
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
}

// Update student details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $ic_number = $_POST["ic_number"];
    $programme_code = $_POST["programme_code"];

    $sql = "UPDATE students SET name = ?, email = ?, ic_number = ?, programme_code = ? WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $ic_number, $programme_code, $student_id);

    if ($stmt->execute()) {
        echo "<script>alert('Student updated successfully!'); 
              window.location.href='manage_students.php';</script>";
    } else {
        echo "<script>alert('Error updating student!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fbfc; /* Soft blue-gray background */
        }
        .container {
            margin-top: 100px; /* Space for fixed navbar */
            max-width: 600px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Elegant shadow */
            margin-left: auto;
            margin-right: auto;
        }
        h2 {
            font-size: 24px;
            color: #00416a; /* Navy Blue */
            margin-bottom: 20px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
            color: #333;
            text-align: left;
        }
        input {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
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
            transform: scale(1.05);
        }
        .update-btn {
            background-color: #007bff; /* Blue */
            color: white;
        }
        .back-btn {
            background-color: #6c757d; /* Neutral gray */
            color: white;
        }
        .back-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<!-- Content -->
<div class="container">
    <h2>📋 Edit Student Information</h2>
    <form action="edit_student.php?id=<?php echo $student['student_id']; ?>" method="POST">
        <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>

        <label for="ic_number">IC Number:</label>
        <input type="text" name="ic_number" id="ic_number" value="<?php echo htmlspecialchars($student['ic_number']); ?>" required>

        <label for="programme_code">Programme Code:</label>
        <input type="text" name="programme_code" id="programme_code" value="<?php echo htmlspecialchars($student['programme_code']); ?>" required>

        <button type="submit" class="update-btn">Update Student</button>
    </form>
    <br>
    <a href="manage_students.php">
        <button type="button" class="back-btn">Back</button>
    </a>
</div>

</body>
</html>
