<?php
require 'vendor/autoload.php';
require 'db_conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $course = $_POST['course'];
    $phone_number = $_POST['phoneNumber'];
    $birthdate = $_POST['birthdate'];
    $verification_code = bin2hex(random_bytes(16));
    $profileImagePath = null;

    if (!empty($_FILES["profileImage"]["name"])) {
        $uploadDir = "profiles/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imageName = time() . '_' . basename($_FILES["profileImage"]["name"]);
        $targetPath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetPath)) {
            $profileImagePath = $targetPath;
        } else {
            http_response_code(400);
            echo json_encode(["res" => "error", "msg" => "Image upload failed"]);
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO user_table (first_name, last_name, email, password, address, gender, course, phone_number, birthdate, user_profile, verification_code) VALUES (:fname, :lname, :email, :password, :address, :gender, :course, :phone_number, :birthdate, :user_profile, :verification_code)");

    $stmt->bindParam(':fname', $fname);
    $stmt->bindParam(':lname', $lname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':course', $course);
    $stmt->bindParam(':phone_number', $phone_number);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->bindParam(':user_profile', $profileImagePath);
    $stmt->bindParam(':verification_code', $verification_code);

    if ($stmt->execute()) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'torresypther@gmail.com';
            $mail->Password = 'tbdn nfdr mqhh vguq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('torresypther@gmail.com', 'Mailer');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Account Verification';
            $mail->Body = 'Click the link to verify your account: <a href="http://localhost/StudentManagementSystem/verify.php?code=' . $verification_code . '">Verify Account</a>';

            $mail->send();
            echo 'Registration successful! Please check your email to verify your account.';
            header('Content-Type: application/json');
            echo json_encode(["res" => "success", "msg" => "Registration successful!"]);
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: Could not register user.";
    }
}
