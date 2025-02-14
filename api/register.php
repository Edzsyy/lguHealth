<?php
header("Content-Type: application/json");
include('../api/config/dbconn.php');

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->fullname, $data->email, $data->password)) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$fullname = trim($data->fullname);
$email = trim($data->email);
$password = trim($data->password);
$role = "Client"; // Default role

if (empty($fullname) || empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

// Check if email already exists
$checkEmailQuery = $conn->prepare("SELECT client_id FROM clients WHERE email = ?");
$checkEmailQuery->bind_param("s", $email);
$checkEmailQuery->execute();
$checkEmailQuery->store_result();

if ($checkEmailQuery->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Email already exists"]);
    exit;
}

// Hash the password securely
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user into the database
$insertQuery = $conn->prepare("INSERT INTO clients (full_name, email, password, role) VALUES (?, ?, ?, ?)");
$insertQuery->bind_param("ssss", $fullname, $email, $hashedPassword, $role);

if ($insertQuery->execute()) {
    echo json_encode(["success" => true, "message" => "Registration successful"]);
} else {
    echo json_encode(["success" => false, "message" => "Error during registration"]);
}
?>
