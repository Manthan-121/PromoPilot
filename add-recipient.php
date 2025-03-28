<?php
include_once("includes/config.php"); // DB connection

$response = ['status' => 'error', 'message' => 'Something went wrong'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Invalid email format.";
    } else {
        $stmt = $conn->prepare("INSERT INTO recipients (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);

        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'Recipient added successfully'];
        } else {
            if ($conn->errno === 1062) {
                $response['message'] = "Email already exists.";
            } else {
                $response['message'] = "Database error: " . $conn->error;
            }
        }
        $stmt->close();
    }
}

header('Content-Type: application/json');
echo json_encode($response);
