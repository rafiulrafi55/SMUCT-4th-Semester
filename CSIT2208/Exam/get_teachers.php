<?php
include 'db_connect.php'; // Include the database connection file

header('Content-Type: application/json'); // Set header to return JSON

$teachers = [];
$sql = "SELECT id, name FROM teachers ORDER BY name ASC";

// Use a prepared statement for consistency and security, although not strictly necessary for this simple query.
$result = $conn->query($sql);

// Check for query errors
if ($result === false) {
    http_response_code(500);
    error_log("Error fetching teachers: " . $conn->error);
    echo json_encode(['message' => 'Failed to retrieve teacher data.']);
    $conn->close();
    exit();
}

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }
}

echo json_encode($teachers);

$conn->close();
?>
