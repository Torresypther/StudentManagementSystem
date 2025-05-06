<?php
require 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['task_id']) && isset($_GET['user_id'])) {
    $task_id = $_GET['task_id'];
    $user_id = $_GET['user_id'];

    try {
        $stmt = $conn->prepare("SELECT t.task_name, t.task_deadline, t.task_desc, ta.submitted_file, ta.task_status
                    FROM tasks t
                    INNER JOIN task_assignments ta ON t.task_id = ta.task_id
                    WHERE ta.task_id = :task_id AND ta.student_id = :user_id");
        $stmt->bindParam(':task_id', $task_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($task) {
            echo json_encode([
                "success" => true,
                "task_name" => $task['task_name'],
                "task_deadline" => $task['task_deadline'],
                "task_desc" => $task['task_desc'],
                "task_status" => $task['task_status'],
                "submitted_file" => $task['submitted_file'],
            ]);
        } else {
            echo json_encode(["success" => false, "msg" => "Task not found."]);
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(["success" => false, "msg" => "Database error."]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "Invalid request."]);
}