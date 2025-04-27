<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

require 'db_conn.php';

try {
    $task_name = $_POST['task_name'];
    $task_desc = $_POST['description'];
    $task_deadline = $_POST['duedate'];
    $task_status = 'pending';
    $assigned_students_raw = $_POST['assigned_students']; // Comma-separated user IDs

    // Step 1: Insert into tasks table
    $stmt = $conn->prepare("INSERT INTO tasks (task_name, task_desc, task_deadline, task_status) VALUES (:task_name, :description, :due_date, :task_status)");
    $stmt->execute([
        ':task_name' => $task_name,
        ':description' => $task_desc,
        ':due_date' => $task_deadline,
        ':task_status' => $task_status
    ]);

    $task_id = $conn->lastInsertId(); // Ensure this retrieves the correct task_id

    // Step 2: Parse and validate assigned student IDs
    $student_ids = array_filter(array_map('trim', explode(',', $assigned_students_raw)), 'is_numeric');

    if (empty($student_ids)) {
        echo json_encode(['success' => false, 'message' => 'No valid student IDs provided']);
        exit();
    }

    // Step 3: Validate students and prepare batch insert
    $valid_student_ids = [];
    $placeholders = [];
    $params = [];

    foreach ($student_ids as $index => $student_id) {
        $stmt = $conn->prepare("SELECT user_id FROM user_table WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $student_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $valid_student_ids[] = $student_id;
            $placeholders[] = "(:task_id, :student_id_$index)";
            $params[":student_id_$index"] = $student_id;
        }
    }

    if (empty($valid_student_ids)) {
        echo json_encode(['success' => false, 'message' => 'No valid students found']);
        exit();
    }

    // Batch insert task assignments
    $params[':task_id'] = $task_id;
    $sql = "INSERT INTO task_assignments (task_id, student_id) VALUES " . implode(', ', $placeholders);
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    echo json_encode([
        'res' => 'success',
        'msg' => 'Task assigned successfully',
        'assigned_students' => $valid_student_ids
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
