<?php
session_start();
header('Content-Type: application/json');
include('../../config/dbconn.php');

// Uncomment this if you want to ensure the user is logged in (not necessary if client_id is stored as a session variable)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Handling the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if all required data is provided
    if (
        isset($data['appointmentId']) && !empty($data['appointmentId']) &&
        isset($data['appointmentPatient']) && !empty($data['appointmentPatient']) &&
        isset($data['appointmentDoctor']) && !empty($data['appointmentDoctor']) &&
        isset($data['appointmentDate']) && !empty($data['appointmentDate']) &&
        isset($data['appointmentStatus']) && !empty($data['appointmentStatus'])
    ) {
        $appointmentId = intval($data['appointmentId']);
        $appointmentPatient = trim($data['appointmentPatient']);
        $appointmentDoctor = trim($data['appointmentDoctor']);
        $appointmentDate = $data['appointmentDate'];
        $appointmentStatus = $data['appointmentStatus'];
        $appointmentNotes = isset($data['appointmentNotes']) ? trim($data['appointmentNotes']) : '';

        // Validate that the patient and doctor exist in the users table (for integrity)
        $stmtCheckPatient = $conn->prepare("SELECT user_id FROM users WHERE user_id = ? AND role = 'Client'");
        $stmtCheckPatient->bind_param("i", $appointmentPatient);
        $stmtCheckPatient->execute();
        $resultPatient = $stmtCheckPatient->get_result();

        if ($resultPatient->num_rows === 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid patient ID']);
            exit;
        }

        $stmtCheckDoctor = $conn->prepare("SELECT user_id FROM users WHERE user_id = ? AND role = 'Doctor'");
        $stmtCheckDoctor->bind_param("i", $appointmentDoctor);
        $stmtCheckDoctor->execute();
        $resultDoctor = $stmtCheckDoctor->get_result();

        if ($resultDoctor->num_rows === 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid doctor ID']);
            exit;
        }

        // Prepare and execute the update query
        $stmt = $conn->prepare("UPDATE appointments SET patient_id = ?, doctor_id = ?, appointment_date = ?, status = ?, notes = ? WHERE appointment_id = ?");
        $stmt->bind_param("iisssi", $appointmentPatient, $appointmentDoctor, $appointmentDate, $appointmentStatus, $appointmentNotes, $appointmentId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
            $stmt->close();
            $conn->close();
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating appointment: ' . $stmt->error]);
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
