<?php
// This file should be run once, or included only when table setup is needed.

function createTables($conn) {
    // Create teachers table
    $sql_create_teachers_table = "
    CREATE TABLE IF NOT EXISTS teachers (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        teacher_id VARCHAR(50) UNIQUE NOT NULL,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        designation VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    if ($conn->query($sql_create_teachers_table) === FALSE) {
        error_log("Error creating teachers table: " . $conn->error);
        die("Error setting up the database. Please check server logs.");
    }

    // Create students table
    $sql_create_students_table = "
    CREATE TABLE IF NOT EXISTS students (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        student_id VARCHAR(50) UNIQUE NOT NULL,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        teacher_id INT(6) UNSIGNED,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL
    )";
    if ($conn->query($sql_create_students_table) === FALSE) {
        error_log("Error creating students table: " . $conn->error);
        die("Error setting up the database. Please check server logs.");
    }
}
?>