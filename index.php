<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            text-align: center;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #00416a; /* Navy Blue */
            padding: 10px 20px;
            color: white;
        }
        header img {
            height: 50px;
        }
        header h1 {
            margin: 0;
            font-size: 20px;
        }
        .container {
    width: 60%;
    margin: auto;
    padding: 25px;
    background: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Smooth shadow for elegance */
    border-radius: 15px; /* Rounded edges for a friendly look */
    margin-top: 50px;
    text-align: center;
    border: 2px solid #00416a; /* Navy blue border for a neat look */
}

.container h2 {
    font-size: 24px;
    color: #00416a; /* Navy blue for title */
    margin-bottom: 10px;
}

.container p {
    font-size: 18px;
    color: #555555; /* Neutral text for balance */
    margin-bottom: 20px;
}

.btn-container {
    display: flex;
    justify-content: center;
    gap: 15px; /* Space between buttons */
    flex-wrap: wrap; /* Make it responsive for smaller screens */
}

.btn {
    display: inline-block;
    width: 30%;
    min-width: 150px;
    padding: 15px;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    color: white;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    text-align: center;
    transition: background-color 0.3s ease, transform 0.2s ease; /* Subtle animations */
}

.student-btn {
    background: #00416a; /* Navy Blue */
}

.lecturer-btn {
    background: #28a745; /* Green */
}

.admin-btn {
    background: #6c757d; /* Gray */
}

.btn:hover {
    transform: scale(1.05); /* Slight zoom on hover */
    opacity: 0.9; /* Subtle dim effect */
}

    </style>
</head>
<body>



<div class="container">
    <h2>🎓 Welcome to Secure Online Examination System 💻</h2>
    <p>Please select your role to continue:</p>

    <!-- Login Buttons -->
    <div class="btn-container">
        <a href="student_login.php" class="btn student-btn">📚 STUDENT LOGIN</a>
        <a href="lecturer_login.php" class="btn lecturer-btn">👩‍🏫 LECTURER LOGIN</a>
        <a href="admin_login.php" class="btn admin-btn">🛠️ ADMIN LOGIN</a>
    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br>
<footer>
    <p>© 2025 [University Poly-Tech Malaysia]. All rights reserved.</p>
</footer>

</body>
</html>
