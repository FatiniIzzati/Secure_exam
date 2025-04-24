<?php 
// Ensure session is started only once
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #00416a; /* Navy Blue */
            padding: 10px 20px;
        }
        .navbar .logo {
            display: flex;
            align-items: center;
        }
        .navbar img {
            height: 50px;
        }
        .navbar h1 {
            margin: 0;
            font-size: 20px;
            color: white;
            text-align: center;
            flex-grow: 1; /* Push the title to the center */
        }
        .navbar .links {
            display: flex;
            align-items: center;
            margin-left: auto; /* Push links to the right */
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color: #f4f4f4; /* Slightly lighter shade */
        }
        .navbar .logout {
            background-color: #ff4b4b; /* Softer red for logout button */
            border-radius: 5px;
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s ease;
        }
        .navbar .logout:hover {
            background-color: #e03e3e; /* Darker shade on hover */
        }
    </style>
</head>
<body>

<div class="navbar">
    <!-- Logo on the far left -->
    <div class="logo">
        <img src="images/uptm_logo.png" alt="University Logo">
    </div>

    <!-- Title centered -->
    <h1>Secure Online Examination System</h1>

    <!-- Links on the far right -->
    <div class="links">
        <a href="index.php">Home</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php" class="logout">Logout</a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
