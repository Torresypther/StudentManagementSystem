<?php
session_start(); // Start the session
require 'db_conn.php'; // Include your database connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        // Query to check if the user exists
        $stmt = $conn->prepare("SELECT user_id, password FROM user_table WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Store user_id in session
            $_SESSION['user_id'] = $user['user_id'];

            echo json_encode(['res' => 'success', 'msg' => 'Login successful']);
        } else {
            echo json_encode(['res' => 'error', 'msg' => 'Invalid email or password']);
        }
    } catch (PDOException $e) {
        echo json_encode(['res' => 'error', 'msg' => $e->getMessage()]);
    }
} else {
    echo json_encode(['res' => 'error', 'msg' => 'Invalid request method']);
}
?>