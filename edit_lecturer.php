<?php
include "db_connection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch lecturer details
if (isset($_GET['id'])) {
    $lecturer_id = $_GET['id'];
    $sql = "SELECT * FROM lecturers WHERE lecturer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $lecturer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $lecturer = $result->fetch_assoc();
}

// Update lecturer details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lecturer_id = $_POST["lecturer_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];

    $sql = "UPDATE lecturers SET name = ?, email = ? WHERE lecturer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $lecturer_id);

    if ($stmt->execute()) {
        echo "<script>alert('Lecturer updated successfully!'); 
              window.location.href='manage_lecturers.php';</script>";
    } else {
        echo "<script>alert('Error updating lecturer!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Lecturer</title>
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
    <h2>📋 Edit Lecturer Information</h2>
    <form action="edit_lecturer.php?id=<?php echo $lecturer['lecturer_id']; ?>" method="POST">
        <input type="hidden" name="lecturer_id" value="<?php echo htmlspecialchars($lecturer['lecturer_id']); ?>">

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($lecturer['name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($lecturer['email']); ?>" required>

        <button type="submit" class="update-btn">Update Lecturer</button>
    </form>
    <br>
    <a href="manage_lecturers.php">
        <button type="button" class="back-btn">Back</button>
    </a>
</div>

</body>
</html>
