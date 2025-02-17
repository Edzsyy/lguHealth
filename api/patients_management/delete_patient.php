<?php
include('../config/session_start.php');
header('Content-Type: application/json');
include('../config/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
        if(isset($data['patientId']) && !empty($data['patientId'])){
            $patientId = intval($data['patientId']);
         // Prepare and execute the query
          $stmt = $conn->prepare("DELETE FROM patients WHERE patient_id = ?");
         $stmt->bind_param("i", $patientId);

            if ($stmt->execute()) {
                 echo json_encode(['success' => true]);
                 exit;
            } else {
               echo json_encode(['success' => false, 'message' => 'Error deleting patient: ' . $stmt->error]);
             }
        } else {
             echo json_encode(['success' => false, 'message' => 'Missing patientId']);
         }
   } else {
      echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
  $conn->close();
?>