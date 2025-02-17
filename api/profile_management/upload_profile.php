<?php
include('../config/session_start.php');
header('Content-Type: application/json');
include('../config/dbconn.php');

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $target_dir = "../uploads/";
    
    // Ensure the uploads directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["profile_pic"]["name"]);
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_file_name = "profile_" . time() . "_" . $user_id . "." . $file_ext;
    $target_file = $target_dir . $new_file_name;
    $file_type = $_FILES["profile_pic"]["type"];
    $allowed_types = ["image/jpeg", "image/png", "image/jpg"];

    // Check if file type is allowed
    if (!in_array($file_type, $allowed_types)) {
        echo json_encode(["success" => false, "message" => "Only JPG, JPEG, and PNG files are allowed."]);
        exit();
    }

    // Move the uploaded file
    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        // Update database with new file name
        $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE user_id = ?");
        $stmt->bind_param("si", $new_file_name, $user_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Profile picture updated successfully!", "file" => $new_file_name]);
        } else {
            echo json_encode(["success" => false, "message" => "Database update failed."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Failed to upload file."]);
    }

    $conn->close();
}
?>
