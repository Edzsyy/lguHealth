<?php
session_start();
header('Content-Type: application/json');
include('../config/dbconn.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (
        isset($data['itemName']) && !empty($data['itemName']) &&
        isset($data['itemCategory']) && !empty($data['itemCategory']) &&
        isset($data['itemQuantity']) && !empty($data['itemQuantity']) &&
        isset($data['itemUnitPrice']) && !empty($data['itemUnitPrice'])
    ) {
        $itemName = trim($data['itemName']);
        $itemCategory = $data['itemCategory'];
        $itemQuantity = intval($data['itemQuantity']);
        $itemUnitPrice = floatval($data['itemUnitPrice']);
        $loggedInUserId = $_SESSION['user_id']; // Get logged-in user ID from session

        // Prepare and execute the query
        $stmt = $conn->prepare("INSERT INTO inventory (item_name, category, quantity, unit_price, created_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $itemName, $itemCategory, $itemQuantity, $itemUnitPrice, $loggedInUserId); // Added created_by

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
            $stmt->close();
            $conn->close();
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error saving inventory item: ' . $stmt->error]);
            $stmt->close();
            $conn->close();
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing required data']);
        $conn->close();
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    $conn->close();
    exit;
}
?>