<?php
session_start();
header('Content-Type: application/json');
include('../config/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
      if (
        isset($data['patientName']) && !empty($data['patientName']) &&
        isset($data['patientDob']) && !empty($data['patientDob']) &&
        isset($data['patientGender']) && !empty($data['patientGender']) &&
        isset($data['patientContact']) && !empty($data['patientContact']) &&
           isset($data['patientAddress']) && !empty($data['patientAddress'])
    ) {
        $patientName = trim($data['patientName']);
        $patientDob = $data['patientDob'];
        $patientAge = isset($data['patientAge']) ? intval($data['patientAge']) : null;
        $patientGender = $data['patientGender'];
        $patientContact = trim($data['patientContact']);
        $patientAddress = trim($data['patientAddress']);
        $patientMedicalHistory = isset($data['patientMedicalHistory']) ? trim($data['patientMedicalHistory']) : '';
         $patientAllergies = isset($data['patientAllergies']) ? trim($data['patientAllergies']) : '';


        // Prepare and execute the query
        $stmt = $conn->prepare("INSERT INTO patients (patient_name, date_of_birth, age, gender, contact_number, address, medical_history, allergies, registration_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'staff')");
        $stmt->bind_param("ssssssss", $patientName, $patientDob, $patientAge, $patientGender, $patientContact, $patientAddress, $patientMedicalHistory, $patientAllergies);
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
                 $stmt->close();
                  $conn->close();
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Error saving patient: ' . $stmt->error]);
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