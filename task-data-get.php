<?php
require 'db_conn.php';

header('Content-Type: application/json');

try {
    $stmt = $conn->prepare("SELECT * FROM tasks");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>