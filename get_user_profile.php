<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

require 'db_conn.php'; 

$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare('SELECT first_name, last_name, email, address, gender, birthdate, user_profile FROM user_table WHERE user_id = :user_id');
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $baseFolder = "profiles/";
        $user['profile'] = $user['user_profile'] ? $baseFolder . $user['user_profile'] : $baseFolder . "default.jpg";
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>