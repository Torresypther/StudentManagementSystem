<?php
require 'db_conn.php';

if (isset($_GET['task_id'])) {
    $task_id = intval($_GET['task_id']);

    // Prepare the SQL query to fetch submissions
    $stmt = $conn->prepare("
        SELECT 
            ta.assignment_id AS assignment_id,
            CONCAT(u.first_name, ' ', u.last_name) AS full_name,
            ta.completed_on AS completed_on,
            ta.submission_type AS submission_type,
            ta.submission_status AS submission_status,
            ta.task_status AS task_status,
            ta.submitted_file
        FROM task_assignments ta
        JOIN user_table u ON ta.student_id = u.user_id
        WHERE ta.task_id = :task_id
    ");
    $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($submissions)) {
            echo json_encode([
                'success' => true,
                'submissions' => $submissions,
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No submissions found for this task.',
            ]);
        }
    } catch (Exception $e) {
        error_log("Error fetching submissions: " . $e->getMessage());

        echo json_encode([
            'success' => false,
            'message' => 'An error occurred while fetching submissions.',
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Task ID is required.',
    ]);
}
