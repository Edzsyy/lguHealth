<?php
session_start();
header('Content-Type: application/json');

// Include database configuration
include('../../admin/assets/config/dbconn.php');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['patientId'])) {
        $patientId = filter_var($_GET['patientId'], FILTER_VALIDATE_INT);

        if ($patientId === false || $patientId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid patient ID']);
            exit;
        }

        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT patient_id, patient_name, date_of_birth, gender, contact_number, address, medical_history, allergies FROM patients WHERE patient_id = ?");
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        $result = $stmt->get_result();
        $patient = $result->fetch_assoc();

        if ($patient) {
            echo json_encode($patient);
        } else {
            echo json_encode(['success' => false, 'message' => 'Patient not found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method or missing patient ID']);
    }
} catch (Exception $e) {
    // Handle exceptions
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing your request']);
} finally {
    $conn->close(); // Ensure the connection is closed
}
?>
