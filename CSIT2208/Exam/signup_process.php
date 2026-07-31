<?php
include 'db_connect.php'; // Include the database connection file
include 'db_setup.php';   // Include the table creation logic

// Call the function to ensure tables exist before processing any form data
createTables($conn);

// Function to send a JSON response and exit
function json_response($message = null, $code = 200) {
    header_remove();
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode(['message' => $message]);
    exit();
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['form_type'])) {
        json_response("Form type not specified.", 400);
    }

    $form_type = $_POST['form_type'];

    if ($form_type == 'student_signup') {
        // Basic Server-side Validation
        if (empty($_POST['student-name']) || empty($_POST['student-email']) || empty($_POST['student-id']) || empty($_POST['student-password']) || empty($_POST['student-teacher'])) {
            json_response("All fields are required.", 400);
        }
        if (!filter_var($_POST['student-email'], FILTER_VALIDATE_EMAIL)) {
            json_response("Invalid email format.", 400);
        }

        $name = $_POST['student-name'];
        $email = $_POST['student-email'];
        $student_id = $_POST['student-id'];
        $password = $_POST['student-password'];
        $teacher_fk_id = $_POST['student-teacher'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO students (name, email, student_id, password, teacher_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $name, $email, $student_id, $hashed_password, $teacher_fk_id);

        if ($stmt->execute()) {
            json_response("Student registered successfully!");
        } else {
            error_log("Student signup error: " . $stmt->error);
            // Check for duplicate entry
            if ($stmt->errno == 1062) {
                json_response("This email or ID is already registered.", 409);
            }
            json_response("An error occurred during registration.", 500);
        }
        $stmt->close();

    } elseif ($form_type == 'teacher_signup') {
        // Basic Server-side Validation
        if (empty($_POST['teacher-name']) || empty($_POST['teacher-email']) || empty($_POST['teacher-id']) || empty($_POST['teacher-designation'])|| empty($_POST['teacher-password'])) {
            json_response("All fields are required.", 400);
        }
        if (!filter_var($_POST['teacher-email'], FILTER_VALIDATE_EMAIL)) {
            json_response("Invalid email format.", 400);
        }

        $name = $_POST['teacher-name'];
        $email = $_POST['teacher-email'];
        $teacher_id = $_POST['teacher-id'];
        $designation = $_POST['teacher-designation'];
        $password = $_POST['teacher-password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO teachers (name, email, teacher_id, designation, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $teacher_id, $designation, $hashed_password);

        if ($stmt->execute()) {
            json_response("Teacher registered successfully!");
        } else {
            error_log("Teacher signup error: " . $stmt->error);
            if ($stmt->errno == 1062) {
                json_response("This email or ID is already registered.", 409);
            }
            json_response("An error occurred during registration.", 500);
        }
        $stmt->close();
    }
} else {
    // If the request method is not POST, it's not allowed.
    // Redirect back to the signup page.
    header("Location: signup.html");
    exit();
}

$conn->close();
?>