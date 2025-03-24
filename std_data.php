<?php
include_once 'db_conn.php';

try{
    $query = "SELECT * FROM student_data";
    $statement = $conn->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
}catch (PDOException $e){
    echo json_encode(['error' => $e->getMessage()]);
}
