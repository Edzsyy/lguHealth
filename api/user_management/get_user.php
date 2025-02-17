<?php
include('../config/session_start.php');
header('Content-Type: application/json');
include('../config/dbconn.php');

try {
    // Verify if $conn exists
    if (!isset($conn)) {
        throw new Exception("Database connection is missing.");
    }

    // Prepare and execute query
    $query = "SELECT user_id, user_name, email, role FROM users ORDER BY user_id DESC";
    $result = $conn->query($query);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    // Fetch data
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode($users);
} catch (Exception $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
