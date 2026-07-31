<?php
session_start();
include 'db_connect.php';

// If user is not logged in, redirect to login page (assuming index.html has the login form)
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_role = $_SESSION['user_role'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; background-color: #f8f9fa; }
        .container { max-width: 800px; margin: 20px auto; padding: 20px; background: #fff; border: 1px solid #dee2e6; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        h1, h2 { color: #343a40; }
        .user-info { margin-bottom: 20px; padding: 15px; background-color: #e9ecef; border-radius: 5px; }
        .student-list li { background: #f8f9fa; margin-bottom: 8px; padding: 10px; border-radius: 4px; border-left: 3px solid #007bff; }
        ul { list-style-type: none; padding: 0; }
        a.logout { float: right; text-decoration: none; color: #dc3545; }
        hr { margin-top: 20px; margin-bottom: 20px; border: 0; border-top: 1px solid #dee2e6; }
    </style>
</head>
<body>

<div class="container">
    <a href="logout.php" class="logout">Logout</a>
    <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
    <p>Your role: <strong><?php echo ucfirst(htmlspecialchars($user_role)); ?></strong></p>
    <hr>

    <?php if ($user_role == 'student'): ?>
        <h2>Your Dashboard</h2>
        <div class="user-info">
            <?php
            // Fetch student's data and their teacher's name
            $stmt = $conn->prepare("SELECT s.name AS student_name, s.email, s.student_id, t.name AS teacher_name FROM students s LEFT JOIN teachers t ON s.teacher_id = t.id WHERE s.id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($student = $result->fetch_assoc()) {
                echo "<p><strong>Name:</strong> " . htmlspecialchars($student['student_name']) . "</p>";
                echo "<p><strong>Email:</strong> " . htmlspecialchars($student['email']) . "</p>";
                echo "<p><strong>Student ID:</strong> " . htmlspecialchars($student['student_id']) . "</p>";
                echo "<p><strong>Assigned Teacher:</strong> " . ($student['teacher_name'] ? htmlspecialchars($student['teacher_name']) : 'Not Assigned') . "</p>";
            }
            $stmt->close();
            ?>
        </div>

    <?php elseif ($user_role == 'teacher'): ?>
        <h2>Your Dashboard</h2>
        <h3>Students Assigned to You</h3>
        <ul class="student-list">
            <?php
            // Fetch all students assigned to this teacher
            $stmt = $conn->prepare("SELECT name, email, student_id FROM students WHERE teacher_id = ? ORDER BY name");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($student = $result->fetch_assoc()) {
                    echo "<li><strong>" . htmlspecialchars($student['name']) . "</strong> (" . htmlspecialchars($student['student_id']) . ") - " . htmlspecialchars($student['email']) . "</li>";
                }
            } else {
                echo "<li>No students are currently assigned to you.</li>";
            }
            $stmt->close();
            ?>
        </ul>
    <?php endif; ?>
</div>

</body>
</html>