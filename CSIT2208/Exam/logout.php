<?php
session_start(); // Initialize the session

// Unset all of the session variables
$_SESSION = array();

// Destroy the session and redirect to the home page
session_destroy();
header("Location: index.html");
exit();