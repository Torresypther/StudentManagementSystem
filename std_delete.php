<?php
include_once "db_conn.php";

$query = "DELETE FROM student_data WHERE student_id = " . $_POST["student_id"];
$statement = $conn->prepare($query);
$success = $statement->execute();

if ($success) {
    echo json_encode(["res" => "success"]);
} else {
    echo json_encode(["res" => "error", "msg" => "Product Deletion failed"]);
}
