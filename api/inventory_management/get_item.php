<?php
session_start();
header('Content-Type: application/json');
include('../config/dbconn.php');
error_log("Starting get_item.php");
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['itemId'])) {
    $itemId = intval($_GET['itemId']);
    error_log("Requested item ID: " . $itemId);
    // Prepare and execute the query
      $stmt = $conn->prepare("SELECT item_id, item_name, category, quantity, unit_price FROM inventory WHERE item_id = ?");
     $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();
     error_log("Query executed.");
    $item = $result->fetch_assoc();

    if ($item) {
        error_log("Item found, id: " . $item['item_id']);
       echo json_encode($item);
         $stmt->close();
        $conn->close();
        exit;
    } else {
       error_log("Item not found with id: " . $itemId);
        echo json_encode(['success' => false, 'message' => 'Item not found']);
        $stmt->close();
        $conn->close();
      exit;
    }
} else {
   error_log("Invalid request method or missing item ID");
    echo json_encode(['success' => false, 'message' => 'Invalid request method or missing item ID']);
    $conn->close();
    exit;
}
?>