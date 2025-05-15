<?php
require 'db_conn.php';

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    // Fetch all students from the user_table
    $students_stmt = $conn->prepare("SELECT user_id, CONCAT(first_name, ' ', last_name) AS full_name FROM user_table WHERE is_verified = 1 AND is_admin = 0");
    $students_stmt->execute();
    $students = $students_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch assigned student IDs for the given task
    $assigned_stmt = $conn->prepare("SELECT student_id FROM task_assignments WHERE task_id = ?");
    $assigned_stmt->execute([$task_id]);
    $assigned_students = $assigned_stmt->fetchAll(PDO::FETCH_COLUMN);

    // Mark students as assigned
    foreach ($students as &$student) {
        $student['is_assigned'] = in_array($student['user_id'], $assigned_students);
    }

    // Return the students with assignment status as a JSON response
    echo json_encode($students);
} else {
    echo json_encode([]);
}
?>