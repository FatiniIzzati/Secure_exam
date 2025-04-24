<?php 
include "db_connection.php";


if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
        }
        .edit { background-color: #28a745; }
        .edit:hover { background-color: #218838; }
        .delete { background-color: #dc3545; }
        .delete:hover { background-color: #c82333; }
        .add-btn { background-color: #007bff; }
        .add-btn:hover { background-color: #0056b3; }
        .back { background-color: gray; }
        .back:hover { background-color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Students</h2>
        <table>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php
            $sql = "SELECT * FROM students";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['student_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>
                            <a href='edit_student.php?id={$row['student_id']}' class='btn edit'>Edit</a>
                            <a href='delete_student.php?id={$row['student_id']}' class='btn delete' onclick=\"return confirm('Are you sure?');\">Delete</a>
                        </td>
                    </tr>";
            }
            ?>
        </table>
        <br>
        <a href="add_student.php" class="btn add-btn">Add Student</a>
        <a href="manage_user.php" class="btn back">Back</a>
    </div>
</body>
</html>
