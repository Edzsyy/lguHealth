<?php
session_start();
header('Content-Type: application/json');
include('../../config/dbconn.php');

// Get the logged-in user_id from session
$user_id = $_SESSION['user_id'];
if(!isset($_SESSION['user_id'])) {
    die(json_encode(["success" => false, "message" => "No user_idfound in session"]));
} else {
    error_log("Client ID from session: " . $_SESSION['user_id']);
}


$sql = "SELECT * FROM patients WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$patients = [];
while ($row = $result->fetch_assoc()) {
    $patients[] = $row;
}

echo json_encode(["success" => true, "patients" => $patients]);

$stmt->close();
$conn->close();
