<?php
include "db_connection.php"; // Connect to the database

// Check if admin is logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch current settings from the database
$settings = [];
$result = $conn->query("SELECT * FROM system_settings");
while ($row = $result->fetch_assoc()) {
    $settings[$row['setting_name']] = $row['setting_value'];
}

// Handle form submission to update settings
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_duration = $_POST['exam_duration'];
    $auto_submit = isset($_POST['auto_submit']) ? 'enabled' : 'disabled';
    $randomize_questions = isset($_POST['randomize_questions']) ? 'enabled' : 'disabled';
    $one_time_attempt = isset($_POST['one_time_attempt']) ? 'enabled' : 'disabled';

    // Update settings in the database
    $conn->query("UPDATE system_settings SET setting_value='$exam_duration' WHERE setting_name='exam_duration'");
    $conn->query("UPDATE system_settings SET setting_value='$auto_submit' WHERE setting_name='auto_submit'");
    $conn->query("UPDATE system_settings SET setting_value='$randomize_questions' WHERE setting_name='randomize_questions'");
    $conn->query("UPDATE system_settings SET setting_value='$one_time_attempt' WHERE setting_name='one_time_attempt'");

    header("Location: admin_settings.php?success=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Settings</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fbfc; /* Soft blue-gray for distinct elegance */
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
            padding: 8px 15px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Add subtle shadow */
            z-index: 1000; /* Ensures navbar stays on top of other elements */
        }
        .navbar .logo {
            display: flex;
            align-items: center;
        }
        .navbar img {
            height: 40px; /* Reduced logo size */
            margin-right: 10px;
        }
        .navbar h1 {
            flex-grow: 1;
            text-align: center;
            margin: 0;
            font-size: 18px; /* Slightly smaller font size */
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 8px; /* Reduced margin between links */
            font-size: 15px; /* Slightly smaller font size */
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color: #e6e6e6; /* Slightly lighter shade */
        }
        .navbar .logout {
            background-color: #ff4b4b;
            border-radius: 5px;
            padding: 5px 8px; /* Compact button padding */
            text-decoration: none;
            color: white;
            transition: background-color 0.3s ease;
        }
        .navbar .logout:hover {
            background-color: #e03e3e;
        }
        /* Main Content Styling */
        .container {
            margin-top: 100px; /* Prevent overlap with fixed navbar */
            width: 50%;
            max-width: 800px; /* Restrict maximum width for better centering */
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); /* Softer shadow for distinction */
            text-align: center;
        }
        h2 {
            font-size: 28px;
            color: #00416a; /* Navy Blue for headers */
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            text-align: left;
        }
        label {
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }
        input, select {
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        button {
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            background-color: #0056b3;
            transform: scale(1.05); /* Subtle hover effect */
        }
        .success {
            color: green;
            font-size: 18px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="logo">
        <img src="images/uptm_logo.png" alt="University Logo">
    </div>
    <h1>System Settings</h1>
    <div>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</div>

<!-- Settings Content -->
<div class="container">
    <h2>System Settings</h2>

    <?php if (isset($_GET['success'])) { echo "<p class='success'>Settings Updated Successfully!</p>"; } ?>

    <form method="post">
        <label>Exam Duration (Minutes):</label>
        <input type="number" name="exam_duration" value="<?php echo $settings['exam_duration']; ?>" required>

        <div class="checkbox-group">
            <input type="checkbox" name="auto_submit" <?php if ($settings['auto_submit'] == 'enabled') echo "checked"; ?>>
            <label>Enable Auto-Submission</label>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" name="randomize_questions" <?php if ($settings['randomize_questions'] == 'enabled') echo "checked"; ?>>
            <label>Randomize Question Order</label>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" name="one_time_attempt" <?php if ($settings['one_time_attempt'] == 'enabled') echo "checked"; ?>>
            <label>Allow Only One Attempt per Exam</label>
        </div>

        <button type="submit">Save Settings</button>
    </form>
</div>

</body>
</html>
