<?php
include('../config/session_start.php');
header('Content-Type: application/json');
include('../config/dbconn.php');

error_log("Starting get_patients.php");

$where_clause = "1=1";
$params = [];
$types = '';

$inputData = file_get_contents("php://input");
error_log("Raw Input: " . $inputData); // Log the raw input

$filterData = json_decode($inputData, true);
error_log("Decoded Filter Data: " . json_encode($filterData)); // Log decoded filter data

if (isset($filterData['filterData'])) {
    if (!empty($filterData['filterData']['filterName'])) {
        $where_clause .= " AND patient_name LIKE ?";
        $params[] = "%" . $filterData['filterData']['filterName'] . "%";
        $types .= 's';
        error_log("Adding filter for Name: " . $filterData['filterData']['filterName']);
    }
    if (!empty($filterData['filterData']['filterAge'])) {
        $age = intval($filterData['filterData']['filterAge']);
        $where_clause .= " AND age = ?";
        $params[] = $age;
        $types .= 'i';
        error_log("Adding filter for Age: " . $age);
    }
    if (!empty($filterData['filterData']['filterGender'])) {
        $where_clause .= " AND gender = ?";
        $params[] = $filterData['filterData']['filterGender'];
        $types .= 's';
        error_log("Adding filter for Gender: " . $filterData['filterData']['filterGender']);
    }
    if (!empty($filterData['filterData']['filterAdmissionType'])) {
        $where_clause .= " AND admission_type = ?";
        $params[] = $filterData['filterData']['filterAdmissionType'];
        $types .= 's';
        error_log("Adding filter for Admission Type: " . $filterData['filterData']['filterAdmissionType']);
    }
    if (!empty($filterData['filterData']['filterStatus'])) {
        $where_clause .= " AND patient_status = ?";
        $params[] = $filterData['filterData']['filterStatus'];
        $types .= 's';
        error_log("Adding filter for Status: " . $filterData['filterData']['filterStatus']);
    }
}

// Construct SQL Query
$sql = "SELECT patient_id, patient_name, age, gender, admission_type, patient_status FROM patients WHERE $where_clause";

// Log SQL Query for Debugging
error_log("SQL Query: " . $sql);
error_log("Params: " . json_encode($params));

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$patients = [];
while ($row = $result->fetch_assoc()) {
    $patients[] = $row;
}

echo json_encode($patients);

$stmt->close();
$conn->close();
