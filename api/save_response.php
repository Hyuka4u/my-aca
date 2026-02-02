<?php
// api/save_response.php
header('Content-Type: application/json');
require_once '../lib/functions.php';

$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['response'])) {
    $message = $data['message'] ?? '';
    $response = $data['response']; // 'accept' or 'maybe'

    if (saveMessage($message, $response)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save message']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
}
?>