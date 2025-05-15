<?php
session_start(); // Start the session
require 'db_conn.php'; // Include your database connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        // Query to check if the user exists and get is_admin
        $stmt = $conn->prepare("SELECT user_id, password, is_admin FROM user_table WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Store user_id and is_admin in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['is_admin'] = $user['is_admin']; // Store is_admin in session

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