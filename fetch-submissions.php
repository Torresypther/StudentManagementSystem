<?php
require 'db_conn.php';

if (isset($_GET['task_id'])) {
    $task_id = intval($_GET['task_id']);

    $stmt = $conn->prepare("
        SELECT 
            CONCAT(u.first_name, ' ', u.last_name) AS full_name,
            ta.completed_on AS completed_at,
            ta.submitted_file
        FROM task_assignments ta
        JOIN user_table u ON ta.student_id = u.user_id
        WHERE ta.task_id = :task_id
    ");
    $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            'submissions' => $submissions,
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error fetching submissions.',
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Task ID is required.',
    ]);
}
?>