<?php  
session_start();
include "db_connection.php";

if (!isset($_SESSION["lecturer_id"])) {
    header("Location: lecturer_login.php");
    exit();
}

$lecturer_id = $_SESSION["lecturer_id"];
$lecturerQuery = $conn->query("SELECT * FROM lecturers WHERE lecturer_id = '$lecturer_id'");
$lecturer = $lecturerQuery->fetch_assoc();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $ic_number = $_POST["ic_number"];
    $phone_number = $_POST["phone_number"];
    $dob = $_POST["dob"];
    $room_number = $_POST["room_number"];

    // Update lecturer's profile
    $updateQuery = $conn->prepare("UPDATE lecturers SET name=?, email=?, ic_number=?, phone_number=?, dob=?, room_number=? WHERE lecturer_id=?");
    $updateQuery->bind_param("sssssss", $name, $email, $ic_number, $phone_number, $dob, $room_number, $lecturer_id);

    if ($updateQuery->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location='lecturer_profile.php';</script>";
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
        input {
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
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($lecturer['name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($lecturer['email']); ?>" required>

            <label for="ic_number">IC Number:</label>
            <input type="text" name="ic_number" id="ic_number" value="<?php echo htmlspecialchars($lecturer['ic_number']); ?>" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" value="<?php echo htmlspecialchars($lecturer['phone_number']); ?>" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" id="dob" value="<?php echo htmlspecialchars($lecturer['dob']); ?>" required>

            <label for="room_number">Room Number:</label>
            <input type="text" name="room_number" id="room_number" value="<?php echo htmlspecialchars($lecturer['room_number']); ?>" required>

            <button type="submit">Update Profile</button>
        </form>

        <a href="lecturer_profile.php" class="back-btn">Back to Profile</a>
    </div>

</body>
</html>
