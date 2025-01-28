<?php
session_start();
error_log(print_r($_POST, true)); 
header('Content-Type: application/json');
include('../../admin/assets/config/dbconn.php');

try {
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['patientId'])) {
        $patientId = filter_var($_POST['patientId'], FILTER_VALIDATE_INT);

        if ($patientId === false || $patientId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid patient ID']);
            exit;
        }

        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT patient_id, patient_name, date_of_birth, gender, contact_number, address, medical_history, allergies, admission_type, status FROM patients WHERE patient_id = ?");
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        $result = $stmt->get_result();
        $patient = $result->fetch_assoc();

        if ($patient) {
            echo json_encode(['success' => true, 'data' => $patient]);
              $stmt->close();
              $conn->close();
             exit;
        } else {
             echo json_encode(['success' => false, 'message' => 'Patient not found']);
             $stmt->close();
             $conn->close();
             exit;
        }
    } else {
         echo json_encode(['success' => false, 'message' => 'Invalid request method or missing patient ID']);
        $conn->close();
         exit;
    }
} catch (Exception $e) {
    // Handle exceptions
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing your request']);
} finally {
    if(isset($conn)) {
          $conn->close(); // Ensure the connection is closed
    }
}
?>