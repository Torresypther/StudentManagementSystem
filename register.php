<?php
require 'vendor/autoload.php'; // Load PHPMailer
require 'db_conn.php'; // Include your database connection file

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
    $phone_number = $_POST['phone_number'];
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

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO user_table (first_name, last_name, email, password, address, gender, course, phone_number, birthdate, user_profile, verification_code, is_verified) VALUES (:fname, :lname, :email, :password, :address, :gender, :course, :phone_number, :birthdate, :user_profile, :verification_code)");

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
        // Send verification email
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'cosepcarljoshua@gmail.com'; // SMTP username
            $mail->Password = 'iwqk rfng wrmn bftq'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('cosepcarljoshua@gmail.com', 'Mailer');
            $mail->addAddress($email); // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Account Verification';
            $mail->Body    = 'Click the link to verify your account: <a href="http://localhost/prelim_crud/verify.php?code=' . $verification_code . '">Verify Account</a>';

            $mail->send();
            echo 'Registration successful! Please check your email to verify your account.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: Could not register user.";
    }
}
?>
