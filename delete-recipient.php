<?php
include_once("./includes/config.php");

$response = ['status' => 'error', 'message' => 'Something went wrong'];

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("DELETE FROM recipients WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Recipient deleted'];
    }
    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($response);
