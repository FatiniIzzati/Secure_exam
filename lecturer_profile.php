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

$changeMsg = "";

// Handle password change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_password"])) {
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Fetch existing hashed password
    $stmt = $conn->prepare("SELECT password FROM lecturers WHERE lecturer_id = ?");
    $stmt->bind_param("s", $lecturer_id);
    $stmt->execute();
    $stmt->bind_result($stored_password);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($current_password, $stored_password)) {
        if ($new_password === $confirm_password) {
            $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $updateStmt = $conn->prepare("UPDATE lecturers SET password = ? WHERE lecturer_id = ?");
            $updateStmt->bind_param("ss", $new_hashed, $lecturer_id);
            $updateStmt->execute();
            $updateStmt->close();
            $changeMsg = "<span style='color: green;'>Password successfully changed.</span>";
        } else {
            $changeMsg = "<span style='color: red;'>New passwords do not match.</span>";
        }
    } else {
        $changeMsg = "<span style='color: red;'>Current password is incorrect.</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Profile</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #00416a;
            padding: 10px 20px;
            color: white;
        }
        .navbar .logo {
            display: flex;
            align-items: center;
        }
        .navbar img {
            height: 50px;
            margin-right: 10px;
        }
        .navbar h1 {
            flex-grow: 1;
            text-align: center;
            margin: 0;
            font-size: 20px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 16px;
        }
        .navbar a:hover {
            color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
            width: 50%;
            text-align: left;
        }
        h2 {
            text-align: center;
            color: #00416a;
            margin-bottom: 20px;
        }
        .profile-info {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .profile-label {
            font-weight: bold;
            color: #555;
            width: 40%;
        }
        .profile-data {
            color: #333;
            width: 55%;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 18px;
        }
        .btn {
            width: 40%;
            min-width: 120px;
            padding: 8px;
            font-size: 14px;
            font-weight: bold;
            color: white;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            background-color: #28a745;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-back {
            background-color: #17a2b8;
        }
        .btn:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        .btn-back:hover {
            background-color: #138496;
        }
        .empty-data {
            color: #ff4b4b;
            font-style: italic;
        }
        #passwordForm {
            display: none;
            margin-top: 20px;
        }
        #passwordForm input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        #passwordForm input[type="submit"] {
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #passwordForm input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>👤 Your Profile</h2>
    <div class="profile-info">
        <div class="profile-label">Lecturer ID:</div>
        <div class="profile-data"><?php echo htmlspecialchars($lecturer['lecturer_id']); ?></div>
    </div>
    <div class="profile-info">
        <div class="profile-label">Name:</div>
        <div class="profile-data"><?php echo htmlspecialchars($lecturer['name']); ?></div>
    </div>
    <div class="profile-info">
        <div class="profile-label">Email:</div>
        <div class="profile-data"><?php echo htmlspecialchars($lecturer['email']); ?></div>
    </div>
    <div class="profile-info">
        <div class="profile-label">Phone Number:</div>
        <div class="profile-data"><?php echo htmlspecialchars($lecturer['phone_number']) ?: '<span class="empty-data">Not provided</span>'; ?></div>
    </div>
    <div class="profile-info">
        <div class="profile-label">Date of Birth:</div>
        <div class="profile-data"><?php echo htmlspecialchars($lecturer['dob']) ?: '<span class="empty-data">Not provided</span>'; ?></div>
    </div>
    <div class="profile-info">
        <div class="profile-label">Room Number:</div>
        <div class="profile-data"><?php echo htmlspecialchars($lecturer['room_number']) ?: '<span class="empty-data">Not provided</span>'; ?></div>
    </div>
    <div class="profile-info">
        <div class="profile-label">IC Number:</div>
        <div class="profile-data"><?php echo htmlspecialchars($lecturer['ic_number']) ?: '<span class="empty-data">Not provided</span>'; ?></div>
    </div>
    <div class="profile-info">
        <div class="profile-label">Password:</div>
        <div class="profile-data">
            ••••••••
            <button onclick="togglePasswordForm()" style="margin-left: 15px; padding: 5px 10px; cursor: pointer;">Change Password</button>
        </div>
    </div>

    <div id="passwordForm">
        <form method="POST">
            <label>Current Password:</label><br>
            <input type="password" name="current_password" required>
            <label>New Password:</label><br>
            <input type="password" name="new_password" required>
            <label>Confirm New Password:</label><br>
            <input type="password" name="confirm_password" required>
            <br>
            <input type="submit" name="change_password" value="Update Password">
        </form>
        <div style="margin-top: 10px;"><?php echo $changeMsg; ?></div>
    </div>

    <div class="btn-container">
        <a href="edit_lecturer_profile.php" class="btn">✏️ Edit Profile</a>
        <a href="lecturer_dashboard.php" class="btn btn-back">⬅️ Back </a>
    </div>
</div>

<script>
    function togglePasswordForm() {
        var form = document.getElementById("passwordForm");
        form.style.display = form.style.display === "none" ? "block" : "none";
    }
</script>

</body>
</html>
