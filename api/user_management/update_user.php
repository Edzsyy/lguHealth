<?php
session_start();
header('Content-Type: application/json');
include('../config/dbconn.php');

// Get raw input data
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (!isset($data["userId"], $data["userName"], $data["userEmail"], $data["userRole"])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$userId = intval($data["userId"]);
$userName = trim($data["userName"]);
$userEmail = trim($data["userEmail"]);
$userRole = trim($data["userRole"]);
$userPassword = isset($data["userPassword"]) && !empty($data["userPassword"]) ? trim($data["userPassword"]) : null;

// Check if email is already taken by another user
$checkEmailQuery = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
$checkStmt = $conn->prepare($checkEmailQuery);
$checkStmt->bind_param("si", $userEmail, $userId);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Email is already taken by another user"]);
    exit;
}
$checkStmt->close();

try {
    if ($userPassword) {
        // Hash the new password
        $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE users SET user_name = ?, email = ?, role = ?, password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssssi", $userName, $userEmail, $userRole, $hashedPassword, $userId);
    } else {
        // Update without changing password
        $updateQuery = "UPDATE users SET user_name = ?, email = ?, role = ? WHERE user_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssi", $userName, $userEmail, $userRole, $userId);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update user"]);
    }
    $stmt->close();

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

$conn->close();
?>
