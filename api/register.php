<?php
header("Content-Type: application/json");
include('./config/dbconn.php');
include('log_functions.php');  // Include the log function file

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->fullname, $data->email, $data->password)) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$username = trim($data->fullname);  // Fullname should be assigned to $username
$email = trim($data->email);
$password = trim($data->password);
$role = "Client"; // Default role

// Correct the empty check to use $username instead of $fullname
if (empty($username) || empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

// Check if email already exists
$checkEmailQuery = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
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
$insertQuery = $conn->prepare("INSERT INTO users (user_name, email, password, role) VALUES (?, ?, ?, ?)");
$insertQuery->bind_param("ssss", $username, $email, $hashedPassword, $role);  // Use $username here instead of $fullname

if ($insertQuery->execute()) {
    // Log the registration action
    $logMessage = "New user registered: Full Name - {$username}, Email - {$email}, Role - {$role}";
    logAction($logMessage);  // Call the log function

    echo json_encode(["success" => true, "message" => "Registration successful"]);
} else {
    echo json_encode(["success" => false, "message" => "Error during registration"]);
}
?>
