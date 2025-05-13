<?php
require 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $duedate = $_POST['duedate'];
    $assigned_students = $_POST['assigned_students'];
    $assigned_students_array = explode(',', $assigned_students);

    try {
        // Update the task details
        $stmt = $conn->prepare("UPDATE tasks SET task_name = ?, task_desc = ?, task_deadline = ? WHERE task_id = ?");
        $stmt->execute([$task_name, $description, $duedate, $task_id]);

        // Delete all previous assigned students
        $conn->prepare("DELETE FROM task_assignments WHERE task_id = ?")->execute([$task_id]);

        // Insert new assigned students
        $stmt = $conn->prepare("INSERT INTO task_assignments (task_id, student_id) VALUES (?, ?)");
        foreach ($assigned_students_array as $student_id) {
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
