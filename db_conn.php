<?php

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
