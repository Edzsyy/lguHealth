<?php
session_start();
header('Content-Type: application/json');
include('../../admin/assets/config/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['patientId'])) {
    $patientId = intval($_GET['patientId']);

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT patient_id, patient_name, date_of_birth, gender, contact_number, address, medical_history, allergies FROM patients WHERE patient_id = ?");
    $stmt->bind_param("i", $patientId);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();

    if ($patient) {
        echo json_encode($patient);
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
      $conn->close(); // Close connection on invalid request
      exit;
 }
?>