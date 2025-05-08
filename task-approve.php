<?php
require 'db_conn.php';

header('Content-Type: application/json');

if (isset($_POST['assignment_id']) && isset($_POST['status'])) {
    $assignment_id = intval($_POST['assignment_id']);
    $status = $_POST['status'];
    echo json_encode([
        'assignment_id' => $assignment_id,
        'status' => $status
    ]);
    $task_status_value = ($status == 1) ? 'approved' : 'pending';

    try {
        $stmt = $conn->prepare("UPDATE task_assignments SET task_status = :task_status WHERE assignment_id = :assignment_id");
        $stmt->bindParam(':task_status', $task_status_value, PDO::PARAM_STR);
        $stmt->bindParam(':assignment_id', $assignment_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Task status updated successfully.',
                'new_status' => $task_status_value
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update task status.'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Assignment ID and status are required.'
    ]);
}
