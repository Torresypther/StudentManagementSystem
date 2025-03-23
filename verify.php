<?php
require 'db_conn.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $stmt = $conn->prepare("UPDATE students_table SET verification_code = NULL WHERE verification_code = :code");
    $stmt->bindParam(':code', $code);

    if ($stmt->execute() && $stmt->rowCount() > 0) {
        // echo "Your account has been verified!";
        header("Location: login.html?message=verified");
        exit();
    } else {
        echo "Invalid or expired verification code.";
    }
}
?>
