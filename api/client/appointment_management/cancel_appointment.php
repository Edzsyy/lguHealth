<?php
session_start();
header('Content-Type: application/json');
include('../../config/dbconn.php');

// Check if the user is logged in (user_id should be set)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Client') {
    echo json_encode(['success' => false, 'message' => 'Client not logged in or unauthorized']);
    exit;
}

$data = json_decode(file_get_contents("php://input"));

$appointmentId = $data->appointmentId;
$status = 'Cancelled'; // Set the status to "Cancelled" as we're updating the appointment status

try {
    // Prepare SQL query to check if the appointment belongs to the logged-in client (user_id)
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE appointment_id = ? AND user_id = ?");
    $stmt->bind_param('ii', $appointmentId, $_SESSION['user_id']); // Bind parameters (appointmentId as integer, userId as integer)

    // Execute the query to check if the appointment belongs to the logged-in client
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();

    // If the appointment exists and belongs to the client
    if ($appointment) {
        // Update the status to 'Cancelled' for the corresponding appointment
        $updateStmt = $conn->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ?");
        $updateStmt->bind_param('si', $status, $appointmentId); // Bind parameters (status as string, appointmentId as integer)

        // Execute the update query
        if ($updateStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Appointment cancelled successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to cancel the appointment']);
        }
    } else {
        // If the appointment does not belong to the logged-in client, deny cancellation
        echo json_encode(['success' => false, 'message' => 'You do not have permission to cancel this appointment']);
    }

    // Close the statement and connection
    $stmt->close();
    $updateStmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
