<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

$admin_name = $_SESSION["admin_name"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #00416a; /* Navy Blue */
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
            text-decoration: none; /* Remove underline */
            margin: 0 10px;
            font-size: 16px;
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color: #f4f4f4; /* Lighter shade */
        }
        .navbar .logout {
            background-color: #ff4b4b; /* Softer red for logout */
            border-radius: 5px;
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s ease;
        }
        .navbar .logout:hover {
            background-color: #e03e3e;
        }
        .dashboard-container {
            margin: 50px auto;
            width: 80%;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .dashboard-container h2 {
            font-size: 28px;
            color: #00416a; /* Navy Blue */
            margin-bottom: 20px;
        }
        .dashboard-container p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }
        .card-container {
            display: flex;
            justify-content: space-around;
            gap: 20px;
            flex-wrap: wrap;
        }
        .card {
            width: 30%;
            min-width: 250px;
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            cursor: pointer;
            text-decoration: none; /* Ensure cards don't have underline links */
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
            background-color: #d6e0f0; /* Slight hover effect */
        }
        .card h3 {
            font-size: 20px;
            color: #00416a; /* Navy Blue */
            margin-bottom: 10px;
        }
        .card p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">
        <img src="images/uptm_logo.png" alt="University Logo">
    </div>
    <h1>Secure Online Examination System</h1>
    <div>
        <a href="admin_dashboard.php">Home</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</div>

<div class="dashboard-container">
    <h2>🔧 Welcome, <?php echo $admin_name; ?>! ⚙️</h2>
    <p>Here’s what you can do:</p>

    <div class="card-container">
        <a href="manage_user.php" class="card">
            <h3>👥 Manage Users</h3>
            <p>Add, edit, and manage user accounts.</p>
        </a>
        <a href="manage_exams.php" class="card">
            <h3>📝 Manage Exams</h3>
            <p>Create, edit, and manage exams for students.</p>
        </a>
        <a href="settings.php" class="card">
            <h3>⚙️System Settings</h3>
            <p>Customize and update system configurations.</p>
        </a>
    </div>
</div>

</body>
</html>
