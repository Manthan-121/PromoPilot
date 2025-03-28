<?php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'promopilotdb');
define('DB_USER', 'root');
define('DB_PASS', '');

// Base URL
define('BASE_URL', 'http://localhost/PromoPilot/');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
?>