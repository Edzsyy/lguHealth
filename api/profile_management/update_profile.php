<?php
include('../config/session_start.php');
header('Content-Type: application/json');
include('../config/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        echo json_encode(["success" => false, "message" => "User not logged in"]);
        exit();
    }

    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';

    // Update user details in the database
    $stmt = $conn->prepare("UPDATE users SET user_name = ?, email = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $fullname, $email, $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Profile updated successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update profile."]);
    }

    $stmt->close();
    $conn->close();
}
?>
