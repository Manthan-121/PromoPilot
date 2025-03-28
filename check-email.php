<?php
include_once("includes/config.php");

$response = ['exists' => false];

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $excludeId = isset($_POST['excludeId']) ? intval($_POST['excludeId']) : 0;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['invalid'] = true;
    } else {
        if ($excludeId > 0) {
            $stmt = $conn->prepare("SELECT id FROM recipients WHERE email = ? AND id != ?");
            $stmt->bind_param("si", $email, $excludeId);
        } else {
            $stmt = $conn->prepare("SELECT id FROM recipients WHERE email = ?");
            $stmt->bind_param("s", $email);
        }

        $stmt->execute();
        $stmt->store_result();

        $response['exists'] = $stmt->num_rows > 0;
        $stmt->close();
    }
}

header('Content-Type: application/json');
echo json_encode($response);
