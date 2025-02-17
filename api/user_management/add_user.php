<?php
include('../config/session_start.php');
header('Content-Type: application/json');
include('../config/dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['userName'];
    $email = $_POST['userEmail'];
    $password = password_hash($_POST['userPassword'], PASSWORD_DEFAULT); // Secure password hashing
    $role = $_POST['userRole'];

    // Insert into database
    $query = "INSERT INTO users (user_name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "User added successfully!",
            "userId" => $stmt->insert_id
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Database error: " . $stmt->error
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
