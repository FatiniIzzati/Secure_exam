<?php  
session_start();
include "db_connection.php";

if (!isset($_SESSION["student_id"])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION["student_id"];
$studentQuery = $conn->query("SELECT * FROM students WHERE student_id = '$student_id'");
$student = $studentQuery->fetch_assoc();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $ic_number = $_POST["ic_number"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $address = $_POST["address"];
    $programme_code = $_POST["programme_code"];

    // Update student's profile
    $updateQuery = $conn->prepare("UPDATE students SET name=?, email=?, ic_number=?, phone=?, dob=?, address=?, programme_code=? WHERE student_id=?");
    $updateQuery->bind_param("sssssssi", $name, $email, $ic_number, $phone, $dob, $address, $programme_code, $student_id);

    if ($updateQuery->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location='student_profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
        }
        .container {
            background: white;
            padding: 30px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 50%;
            text-align: left;
        }
        h2 {
            text-align: center;
            color: #00416a;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
            color: #555;
        }
        input, textarea {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            background: #0056b3;
            transform: scale(1.05);
        }
        .back-btn {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #007bff;
            text-align: center;
        }
        .back-btn:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Profile</h2>
        <form method="post">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>

            <label for="ic_number">IC Number:</label>
            <input type="text" name="ic_number" id="ic_number" value="<?php echo htmlspecialchars($student['ic_number']); ?>" required>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" id="dob" value="<?php echo htmlspecialchars($student['dob']); ?>" required>

            <label for="address">Address:</label>
            <textarea name="address" id="address" required><?php echo htmlspecialchars($student['address']); ?></textarea>

            <label for="programme_code">Programme Code:</label>
            <input type="text" name="programme_code" id="programme_code" value="<?php echo htmlspecialchars($student['programme_code']); ?>" required>

            <button type="submit">Update Profile</button>
        </form>

        <a href="student_profile.php" class="back-btn">Back to Profile</a>
    </div>

</body>
</html>
