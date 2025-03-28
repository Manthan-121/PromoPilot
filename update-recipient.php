<?php
include_once("includes/config.php");

$response = ['status' => 'error', 'message' => 'Invalid request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email format';
    } else {
        $stmt = $conn->prepare("UPDATE recipients SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $id);

        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'Recipient updated'];
        }
        $stmt->close();
    }
}

header('Content-Type: application/json');
echo json_encode($response);
