<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password (often empty for XAMPP)
$dbname = "exam";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist and select it
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!$conn->query($sql_create_db)) {
    die("Error creating database: " . $conn->error);
}
$conn->select_db($dbname);
?>