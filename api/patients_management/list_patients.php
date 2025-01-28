<?php
session_start();
header('Content-Type: application/json');
include('../../admin/assets/config/dbconn.php');

$where_clause = "1=1";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filterData'])) {
    $filterData = json_decode($_POST['filterData'], true);
        if(isset($filterData['filterName']) && !empty($filterData['filterName'])) {
         $where_clause .= " AND patient_name LIKE '%" . $conn->real_escape_string($filterData['filterName']) . "%'";
        }
        if(isset($filterData['filterStartDate']) && !empty($filterData['filterStartDate'])) {
            $where_clause .= " AND date_of_birth >= '" . $conn->real_escape_string($filterData['filterStartDate']) . "'";
        }
        if(isset($filterData['filterEndDate']) && !empty($filterData['filterEndDate'])) {
           $where_clause .= " AND date_of_birth <= '" . $conn->real_escape_string($filterData['filterEndDate']) . "'";
        }
        if(isset($filterData['filterAdmissionType']) && !empty($filterData['filterAdmissionType'])) {
              $where_clause .= " AND registration_type = '" . $conn->real_escape_string($filterData['filterAdmissionType']) . "'";
        }
         if(isset($filterData['filterStatus']) && !empty($filterData['filterStatus'])) {
              $where_clause .= " AND status = '" . $conn->real_escape_string($filterData['filterStatus']) . "'";
        }
        if(isset($filterData['filterGender']) && !empty($filterData['filterGender'])) {
              $where_clause .= " AND gender = '" . $conn->real_escape_string($filterData['filterGender']) . "'";
        }
       if(isset($filterData['filterAge']) && !empty($filterData['filterAge'])) {
            $age = intval($filterData['filterAge']);
             $where_clause .= " AND  TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) = " . $age;
        }
     if(isset($filterData['filterDoctor']) && !empty($filterData['filterDoctor'])) {
              $where_clause .= " AND 1 = 0";  // You will need to make a join with other tables if you need to filter for doctor's name.
         }
}
// Prepare and execute the query
    $stmt = $conn->prepare("SELECT patient_id, patient_name, date_of_birth, gender, contact_number FROM patients WHERE $where_clause ");
     $stmt->execute();
     $result = $stmt->get_result();
     $patients = array();
   while ($row = $result->fetch_assoc()) {
         $patients[] = $row;
    }

  echo json_encode($patients);
    $stmt->close();
$conn->close();
?>