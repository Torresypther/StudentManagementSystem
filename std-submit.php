<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

require 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'] ?? null;
    $student_id = $_POST['user_id'] ?? null;
    $link = $_POST['link'] ?? null;
    $type = $_POST['type'] ?? null; // Submission type (file or link)
    $sub_status = 'submitted'; // Set submission status to 'submitted'

    if (!$task_id || !$student_id) {
        http_response_code(400);
        echo json_encode(["res" => "error", "msg" => "Invalid task or student ID"]);
        exit();
    }

    $filePath = null;

    // Check if a file is uploaded or a link is provided
    if (!empty($_FILES["student_file"]["name"])) {
        $uploadDir = "std-submissions/";
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                http_response_code(500);
                echo json_encode(["res" => "error", "msg" => "Failed to create upload directory"]);
                exit();
            }
        }

        $fileName = time() . '_' . basename($_FILES["student_file"]["name"]);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["student_file"]["tmp_name"], $targetPath)) {
            $filePath = $targetPath;
        } else {
            http_response_code(400);
            echo json_encode(["res" => "error", "msg" => "File upload failed"]);
            exit();
        }
    } elseif (!empty($link)) {
        // Use the provided link as the file path
        $filePath = $link;
    } else {
        http_response_code(400);
        echo json_encode(["res" => "error", "msg" => "No file or link provided"]);
        exit();
    }

    // Insert file details into the database
    try {
        $conn->beginTransaction();

        // Update submission details
        $stmt = $conn->prepare("UPDATE task_assignments 
                                SET completed_on = NOW(), submission_type = :type, submitted_file = :file_path, submission_status = :sub_status, task_status = 'completed' 
                                WHERE task_id = :task_id AND student_id = :student_id");
        $stmt->bindParam(':task_id', $task_id);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':file_path', $filePath);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':sub_status', $sub_status);

        if ($stmt->execute()) {
            $conn->commit();
            http_response_code(200);
            echo json_encode(["res" => "success", "msg" => "Submission successful"]);
        } else {
            $conn->rollBack();
            http_response_code(500);
            echo json_encode(["res" => "error", "msg" => "Failed to update submission details"]);
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $conn->rollBack();
        http_response_code(500);
        echo json_encode(["res" => "error", "msg" => "Database error: " . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["res" => "error", "msg" => "Invalid request method"]);
}
?>