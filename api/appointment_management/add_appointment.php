<?php
session_start();
header('Content-Type: application/json');

include('../config/dbconn.php');

// Get raw JSON input
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Debugging: Check if JSON is received correctly
if ($data === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON received', 'raw_data' => $json]);
    exit;
}

// Check if all required fields exist before accessing them
$appointmentPatient = isset($data['appointmentPatient']) ? trim($data['appointmentPatient']) : null;
$appointmentDoctor = isset($data['appointmentDoctor']) ? trim($data['appointmentDoctor']) : null;
$appointmentDate = isset($data['appointmentDate']) ? $data['appointmentDate'] : null;
$appointmentStatus = "Scheduled"; // Default status
$appointmentNotes = isset($data['appointmentNotes']) ? trim($data['appointmentNotes']) : '';

if (!$appointmentPatient || !$appointmentDoctor || !$appointmentDate) {
    echo json_encode(['success' => false, 'message' => 'Missing required data', 'received_data' => $data]);
    exit;
}

// Prepare and execute the query
$stmt = $conn->prepare("INSERT INTO appointments (patient_name, doctor_id, appointment_date, status, notes) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sisss", $appointmentPatient, $appointmentDoctor, $appointmentDate, $appointmentStatus, $appointmentNotes);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Appointment added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error adding appointment: ' . $stmt->error]);
}

// Close connections
$stmt->close();
$conn->close();
exit;

