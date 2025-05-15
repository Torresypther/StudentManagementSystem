<?php

// $server_name = "sql108.infinityfree.com";
// $username = "if0_38977934";
// $password = "bxso7kyevffTm";
// $db_name = "if0_38977934_task_tracker_db"; 

$server_name = "localhost";
$username = "root";
$password = "";
$db_name = "user_db";

try {
    $conn = new PDO("mysql:host=$server_name;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode((['error' => "Database connection failed: " . $e->getMessage()])));
}
