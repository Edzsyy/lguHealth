<?php
session_start();
include('../config/dbconn.php');

header("Content-Type: application/json; charset=UTF-8");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id']; // Assuming user is logged in
    $old_password = trim($_POST['old_password'] ?? '');
$new_password = trim($_POST['new_password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');


    // Validate required fields
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    // Validate password length and complexity
    if (strlen($new_password) < 8) {
        echo json_encode(["status" => "error", "message" => "New password must be at least 8 characters long."]);
        exit;
    }

    if ($new_password !== $confirm_password) {
        echo json_encode(["status" => "error", "message" => "New passwords do not match."]);
        exit;
    }

    // Fetch the current password hash from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!$hashed_password) {
        echo json_encode(["status" => "error", "message" => "User not found."]);
        exit;
    }

    // Verify the old password
    if (!password_verify($old_password, $hashed_password)) {
        echo json_encode(["status" => "error", "message" => "Old password is incorrect."]);
        exit;
    }

    // Prevent reusing the old password
    if (password_verify($new_password, $hashed_password)) {
        echo json_encode(["status" => "error", "message" => "New password cannot be the same as the old password."]);
        exit;
    }

    // Hash the new password before updating
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $update_stmt->bind_param("si", $new_hashed_password, $user_id);

    if ($update_stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Password updated successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating password."]);
    }

    $update_stmt->close();
    $conn->close();
}
?>
