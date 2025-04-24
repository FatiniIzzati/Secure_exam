<?php
session_start();
include "db_connection.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Sorting logic
$orderBy = isset($_GET['sort']) ? $_GET['sort'] : 'exam_date';
$orderDirection = isset($_GET['dir']) && $_GET['dir'] == 'desc' ? 'DESC' : 'ASC';

// Search logic
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination setup
$limit = 10; // Exams per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total exams for pagination
$totalExamsQuery = "SELECT COUNT(*) AS total FROM exams WHERE exam_name LIKE '%$search%' OR exam_code LIKE '%$search%'";
$totalExamsResult = $conn->query($totalExamsQuery);
$totalExams = $totalExamsResult->fetch_assoc()['total'];
$totalPages = ceil($totalExams / $limit);

// Fetch exams with search, sorting, and pagination
$sql = "SELECT * FROM exams 
        WHERE exam_name LIKE '%$search%' OR exam_code LIKE '%$search%'
        ORDER BY $orderBy $orderDirection
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Reverse sort direction for the next click
$nextDirection = ($orderDirection == 'ASC') ? 'desc' : 'asc';

// Function to determine exam status
function getExamStatus($exam_date) {
    return (strtotime($exam_date) > time()) ? "<span style='color: green;'>Upcoming</span>" : "<span style='color: red;'>Completed</span>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exams</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fbfc; /* Soft background */
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            text-align: center;
        }
        h2 {
            color: #00416a;
            font-size: 28px;
        }
        .search-bar input {
            width: calc(100% - 110px); /* Stretch input to fill */
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-bar button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #0056b3;
        }
        .button-container {
            display: flex;
            justify-content: space-evenly;
            margin: 20px 0;
        }
        .button-container a {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 16px;
        }
        .button-container .btn.add {
            background-color: #28a745;
        }
        .button-container .btn.view {
            background-color: #ffc107;
            color: #333;
        }
        .button-container a:hover {
            opacity: 0.9;
        }
        .exam-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .exam-table th, .exam-table td {
            padding: 10px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .exam-table th {
            background-color: #00416a;
            color: white; /* White text for titles */
            cursor: pointer;
        }
        .exam-table th a {
            color: white; /* Remove underline and make text white */
            text-decoration: none;
        }
        .exam-table th a:hover {
            text-decoration: none; /* No underline on hover */
        }
        .exam-table td:nth-child(5) {
            font-weight: bold;
        }
        .exam-table tr:hover {
            background-color: #f1f1f1;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            padding: 8px 15px;
            margin: 0 5px;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: #007bff;
            color: white;
        }
        .pagination a.active {
            background-color: #0056b3;
        }
        .pagination a:hover {
            background-color: #004999;
        }
        .btn.action {
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            margin: 2px;
        }
        .btn.edit {
            background-color: #007bff;
        }
        .btn.delete {
            background-color: #dc3545;
        }
        .btn.edit:hover, .btn.delete:hover {
            opacity: 0.8;
        }
        .back-button {
            display: inline-block;
            margin: 20px auto;
            padding: 12px 20px;
            background-color: #6c757d;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📚 Manage Exams</h2>

    <!-- Search Bar -->
    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="🔍 Search by Exam Code or Name" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Action Buttons -->
    <div class="button-container">
        <a href="add_exam.php" class="btn add">➕ Add New Exam</a>
        <a href="add_question.php" class="btn view">Add Questions</a>
        <a href="view_exams.php" class="btn view">View All Exams</a>
    </div>

    <!-- Exams Table -->
    <table class="exam-table">
        <thead>
            <tr>
                <th><a href="?sort=exam_code&dir=<?php echo $nextDirection; ?>&search=<?php echo $search; ?>">Exam Code</a></th>
                <th><a href="?sort=exam_name&dir=<?php echo $nextDirection; ?>&search=<?php echo $search; ?>">Exam Name</a></th>
                <th><a href="?sort=exam_date&dir=<?php echo $nextDirection; ?>&search=<?php echo $search; ?>">Date</a></th>
                <th><a href="?sort=exam_time&dir=<?php echo $nextDirection; ?>&search=<?php echo $search; ?>">Time</a></th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['exam_code']; ?></td>
                <td><?php echo $row['exam_name']; ?></td>
                <td><?php echo $row['exam_date']; ?></td>
                <td><?php echo $row['exam_time']; ?></td>
                <td><?php echo getExamStatus($row['exam_date']); ?></td>
                <td>
                    <a href="edit_exam.php?exam_code=<?php echo $row['exam_code']; ?>" class="btn action edit">Edit</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
       

    </table>
  <!-- Pagination -->
  <div class="pagination">
        <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>&sort=<?php echo $orderBy; ?>&dir=<?php echo $orderDirection; ?>&search=<?php echo $search; ?>">« Previous</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>&sort=<?php echo $orderBy; ?>&dir=<?php echo $orderDirection; ?>&search=<?php echo $search; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page + 1; ?>&sort=<?php echo $orderBy; ?>&dir=<?php echo $orderDirection; ?>&search=<?php echo $search; ?>">Next »</a>
        <?php endif; ?> <br><br>
        <a href="admin_dashboard.php" class="back-button">Back</a>

    </div>
</div>


</body>
</html>
   