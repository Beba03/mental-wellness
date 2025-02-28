<?php
session_start(); // No need for session_status check since we want it to always start

include 'database.php';

header('Content-Type: application/json');

// Log session details for debugging
error_log("log_mood.php - Session ID: " . session_id());
error_log("log_mood.php - Session data: " . print_r($_SESSION, true));

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['id'];

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['mood']) || !isset($data['date'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit();
}

$mood = $data['mood'];
$comment = $data['comment'] ?? '';
$date = $data['date'];

$stmt = $conn->prepare("INSERT INTO moods (user_id, mood, comment, date) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $user_id, $mood, $comment, $date);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$stmt->close();
$conn->close();
?>