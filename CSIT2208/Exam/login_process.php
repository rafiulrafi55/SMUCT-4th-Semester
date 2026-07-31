<?php
session_start(); // Start a session to store user info
include 'db_connect.php';

function json_response($message = null, $code = 200, $redirect = null) {
    header_remove();
    http_response_code($code);
    header('Content-Type: application/json');
    $response = ['message' => $message];
    if ($redirect) {
        $response['redirect'] = $redirect;
    }
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        json_response("Email and password are required.", 400);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check in teachers table first
    $stmt = $conn->prepare("SELECT id, name, password FROM teachers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = 'teacher';
            json_response("Login successful!", 200, "dashboard.php"); // Redirect to a dashboard page
        } else {
            // Don't proceed to check students if email was found but password was wrong
            json_response("Invalid email or password.", 401);
        }
    }

    // If not a teacher or password was wrong, check students table
    $stmt = $conn->prepare("SELECT id, name, password FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = 'student';
            json_response("Login successful!", 200, "dashboard.php"); // Redirect to a dashboard page
        }
    }

    $stmt->close();
    $conn->close();
    json_response("Invalid email or password.", 401);

}
?>