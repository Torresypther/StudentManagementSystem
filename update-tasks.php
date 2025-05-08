<?php
require 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $duedate = $_POST['duedate'];
    $assigned_students = $_POST['assigned_students']; // Comma-separated student IDs
    $assigned_students_array = explode(',', $assigned_students);

    try {
        // Update the task details
        $stmt = $conn->prepare("UPDATE tasks SET task_name = ?, task_desc = ?, task_deadline = ? WHERE task_id = ?");
        $stmt->execute([$task_name, $description, $duedate, $task_id]);

        // Fetch existing assigned students
        $existing_stmt = $conn->prepare("SELECT student_id FROM task_assignments WHERE task_id = ?");
        $existing_stmt->execute([$task_id]);
        $existing_students = $existing_stmt->fetchAll(PDO::FETCH_COLUMN);

        // Merge existing and new assigned students
        $merged_students = array_unique(array_merge($existing_students, $assigned_students_array));

        // Update assigned students
        $conn->prepare("DELETE FROM task_assignments WHERE task_id = ?")->execute([$task_id]);
        $stmt = $conn->prepare("INSERT INTO task_assignments (task_id, student_id) VALUES (?, ?)");
        foreach ($merged_students as $student_id) {
            $stmt->execute([$task_id, $student_id]);
        }

        echo json_encode(['success' => true, 'message' => 'Task updated successfully.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to update task: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>