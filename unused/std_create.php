<?php
include_once "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fname = htmlspecialchars(trim($_POST["fname"]));
    $lname = htmlspecialchars(trim($_POST["lname"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $gender = htmlspecialchars(trim($_POST["gender"]));
    $course = htmlspecialchars(trim($_POST["course"]));
    $address = htmlspecialchars(trim($_POST["address"]));
    $birthdate = trim($_POST["birthdate"]);
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

    try {
        $query = "INSERT INTO student_data (first_name, last_name, email, gender, course, address, birthdate, profile) 
                  VALUES (:first_name, :last_name, :email, :gender, :course, :address, :birthdate, :profile_image)";

        $statement = $conn->prepare($query);

        $statement->bindParam(':first_name', $fname, PDO::PARAM_STR);
        $statement->bindParam(':last_name', $lname, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
        $statement->bindParam(':course', $course, PDO::PARAM_STR);
        $statement->bindParam(':address', $address, PDO::PARAM_STR);
        $statement->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
        $statement->bindParam(':profile_image', $profileImagePath, PDO::PARAM_STR);

        if ($statement->execute()) {
            echo json_encode(["res" => "success"]);
        } else {
            http_response_code(500);
            echo json_encode(["res" => "error", "msg" => "Student creation failed"]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["res" => "error", "msg" => $e->getMessage()]);
    }
}
