<?php
session_start();
header('Content-Type: application/json');
include('../../config/dbconn.php');

// Check if the user is logged in (user_id should be set)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['appointmentId']) && !empty($data['appointmentId'])) {
        $appointmentId = intval($data['appointmentId']);

        // Ensure the user has permission to delete the appointment (based on their role and the appointment's user_id)
        // Only the client who created the appointment or an admin should be able to delete it

        // Check the appointment's user_id (to ensure the user has permission to delete it)
        $stmt = $conn->prepare("SELECT user_id FROM appointments WHERE appointment_id = ?");
        $stmt->bind_param('i', $appointmentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $appointment = $result->fetch_assoc();

        if ($appointment) {
            // Check if the logged-in user is the one who created the appointment or if the user is an admin
            if ($appointment['user_id'] === $_SESSION['user_id'] || $_SESSION['role'] === 'Admin') {
                // Prepare and execute the delete query
                $stmtDelete = $conn->prepare("DELETE FROM appointments WHERE appointment_id = ?");
                $stmtDelete->bind_param("i", $appointmentId);

                if ($stmtDelete->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Appointment deleted successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error deleting appointment: ' . $stmtDelete->error]);
                }

                $stmtDelete->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'You do not have permission to delete this appointment']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Appointment not found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing appointmentId']);
    }

    $conn->close();
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    $conn->close();
    exit;
}
?>
