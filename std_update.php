<?php
include_once "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST["student_id"];
    $fname = htmlspecialchars(trim($_POST["fname"]));
    $lname = htmlspecialchars(trim($_POST["lname"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $gender = htmlspecialchars(trim($_POST["gender"]));
    $course = htmlspecialchars(trim($_POST["course"]));
    $address = htmlspecialchars(trim($_POST["address"]));
    $birthdate = trim($_POST["birthdate"]);
    $profileImagePath = null;

    try {

        $query = "SELECT profile FROM student_data WHERE student_id = :student_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":student_id", $student_id, PDO::PARAM_INT);
        $stmt->execute();
        $existingProfile = $stmt->fetch(PDO::FETCH_ASSOC)["profile"];


        if (!empty($_FILES["profileImage"]["name"])) {
            $uploadDir = "profiles/";
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $imageName = time() . '_' . basename($_FILES["profileImage"]["name"]);
            $targetPath = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetPath)) {
                $profileImagePath = $targetPath;


                if (!empty($existingProfile) && file_exists($existingProfile)) {
                    unlink($existingProfile);
                }
            } else {
                http_response_code(400);
                echo json_encode(["res" => "error", "msg" => "Image upload failed"]);
                exit;
            }
        } else {
            $profileImagePath = $existingProfile;
        }

        $query = "UPDATE student_data SET 
            first_name = :first_name,
            last_name = :last_name,
            email = :email,
            gender = :gender,
            course = :course,
            address = :address,
            birthdate = :birthdate,
            profile = :profile_image
            WHERE student_id = :student_id";

        $statement = $conn->prepare($query);
        $statement->bindParam(":student_id", $student_id, PDO::PARAM_INT);
        $statement->bindParam(":first_name", $fname, PDO::PARAM_STR);
        $statement->bindParam(":last_name", $lname, PDO::PARAM_STR);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->bindParam(":gender", $gender, PDO::PARAM_STR);
        $statement->bindParam(":course", $course, PDO::PARAM_STR);
        $statement->bindParam(":address", $address, PDO::PARAM_STR);
        $statement->bindParam(":birthdate", $birthdate, PDO::PARAM_STR);
        $statement->bindParam(":profile_image", $profileImagePath, PDO::PARAM_STR);

        if ($statement->execute()) {
            echo json_encode(["res" => "success"]);
        } else {
            http_response_code(500);
            echo json_encode(["res" => "error", "msg" => "Student update failed"]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["res" => "error", "msg" => $e->getMessage()]);
    }
}
