<?php
include "db_connection.php";

// Check if admin is logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fbfc; /* A soft blue-gray for distinct elegance */
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
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
            padding: 10px 15px; /* Smaller padding for compact size */
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
            margin: 0 10px; /* Reduced margin between links */
            font-size: 16px; /* Slightly smaller font size */
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color: #e6e6e6; /* Slightly lighter shade */
        }
        .navbar .logout {
            background-color: #ff4b4b;
            border-radius: 5px;
            padding: 5px 10px; /* Compact button padding */
            text-decoration: none;
            color: white;
            transition: background-color 0.3s ease;
        }
        .navbar .logout:hover {
            background-color: #e03e3e;
        }
        /* Main Content Styling */
        .manage-users-container {
            margin-top: 80px; /* Adjust for smaller navbar height */
            width: 70%;
            max-width: 800px; /* Restrict maximum width for better centering */
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); /* Softer shadow for distinction */
            text-align: center;
        }
        .manage-users-container h2 {
            font-size: 28px;
            color: #00416a;
            margin-bottom: 10px;
        }
        .manage-users-container p {
            font-size: 18px;
            color: #444;
            margin-bottom: 30px;
        }
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Adaptive grid layout */
            gap: 20px;
        }
        .card {
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Modern shadow */
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px); /* Subtle movement effect */
            background-color: #d6e0f0; /* Soft hover color */
        }
        .card h3 {
            font-size: 20px;
            color: #00416a;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>

<!-- Navbar -->
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
<br><br>
<!-- Manage Users Content -->
<div class="manage-users-container">
    <h2>👥 User Management</h2>
    <p>Choose a category to manage:</p>

    <div class="card-container">
        <!-- Manage Students Card -->
        <a href="manage_students.php" class="card">
            <h3>📘 Students</h3>
            <p>View, edit, and manage student accounts.</p>
        </a>

        <!-- Manage Lecturers Card -->
        <a href="manage_lecturers.php" class="card">
            <h3>👩‍🏫 Lecturers</h3>
            <p>View, edit, and manage lecturer accounts.</p>
        </a>
    </div>
</div>

</body>
</html>
