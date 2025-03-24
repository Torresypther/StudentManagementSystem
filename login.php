<?php

require 'db_conn.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode([
            'res' => 'error',
            'msg' => 'Email and password are required.'
        ]);
        exit;
    }

    try {
        $email = strtolower($email);

        error_log("Received Email: $email");
        error_log("Received Password: $password");

        $stmt = $conn->prepare("SELECT * FROM user_table WHERE LOWER(email) = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        error_log("Fetched User: " . print_r($user, true));

        if ($user) {
            if (password_verify($password, $user['password'])) {
                echo json_encode([
                    'res' => 'success',
                    'msg' => 'Login successful'
                ]);
            } else {
                error_log("Password verification failed for email: $email");
                echo json_encode([
                    'res' => 'error',
                    'msg' => 'Invalid password.'
                ]);
            }
        } else {
            error_log("Email not found: $email");
            echo json_encode([
                'res' => 'error',
                'msg' => 'Email not found.'
            ]);
        }
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        echo json_encode([
            'res' => 'error',
            'msg' => 'Database error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'res' => 'error',
        'msg' => 'Invalid request method.'
    ]);
}