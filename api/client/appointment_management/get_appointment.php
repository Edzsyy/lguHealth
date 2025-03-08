<?php
session_start();
header('Content-Type: application/json');
include('../../config/dbconn.php');

// Uncomment this if you want to ensure the user is logged in (not necessary if user_id is already stored in the session)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['appointmentId'])) {
    $appointmentId = intval($_GET['appointmentId']);

    // Prepare and execute the query to get the appointment details along with patient and doctor info from users table
    $stmt = $conn->prepare("SELECT 
                                a.appointment_id, 
                                a.patient_id, 
                                a.doctor_id, 
                                a.appointment_date, 
                                a.status, 
                                a.notes, 
                                p.user_name AS patient_name, 
                                d.user_name AS doctor_name 
                            FROM appointments a
                            JOIN users p ON a.patient_id = p.user_id
                            JOIN users d ON a.doctor_id = d.user_id
                            WHERE a.appointment_id = ?");
    $stmt->bind_param("i", $appointmentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();

    if ($appointment) {
        // Return appointment with doctor and patient names
        echo json_encode(['success' => true, 'appointment' => $appointment]);
        $stmt->close();
        $conn->close();
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Appointment not found']);
        $stmt->close();
        $conn->close();
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method or missing appointment ID']);
    $conn->close();
    exit;
}
?>
