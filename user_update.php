<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

require 'db_conn.php'; // Include your database connection

$user_id = $_SESSION['user_id'];

try {
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];

    // Fetch the current profile picture from the database
    $stmt = $conn->prepare("SELECT user_profile FROM user_table WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $currentProfile = $stmt->fetch(PDO::FETCH_ASSOC)['user_profile'];

    // Handle profile picture upload
    $profile_picture = null;
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'profiles/';
        $uploadFile = $uploadDir . basename($_FILES['profileImage']['name']);

        // Move the uploaded file to the profiles directory
        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $uploadFile)) {
            $profile_picture = basename($_FILES['profileImage']['name']);

            // Delete the old profile picture if it exists and is not the default image
            if ($currentProfile && $currentProfile !== 'default.jpg' && file_exists($uploadDir . $currentProfile)) {
                unlink($uploadDir . $currentProfile);
            }
        }
    }

    // Update user information in the database
    $stmt = $conn->prepare("UPDATE user_table SET first_name = :first_name, last_name = :last_name, email = :email, address = :address, gender = :gender, birthdate = :birthdate, user_profile = COALESCE(:profile_picture, user_profile) WHERE user_id = :user_id");
    $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
    $stmt->bindParam(':profile_picture', $profile_picture, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>