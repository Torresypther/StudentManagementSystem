<?php
require 'db_conn.php';

header('Content-Type: application/json');

$user_id = $_GET['user_id'] ?? null;

// Log the received user_id for debugging
error_log("Received user_id: " . ($user_id ?? "null"));

if (!$user_id) {
    echo json_encode([]);
    exit();
}

try {
    $stmt = $conn->prepare("
        SELECT t.task_id, t.task_name, t.task_desc, t.task_deadline, ta.task_status AS task_status
        FROM tasks t
        INNER JOIN task_assignments ta ON t.task_id = ta.task_id
        WHERE ta.student_id = ?
    ");
    $stmt->execute([$user_id]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($tasks);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>