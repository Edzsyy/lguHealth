<?php
session_start();
header('Content-Type: application/json');

// Include database configuration
include('../../admin/assets/config/dbconn.php');

try {
    $filters = [];
    $params = [];
    $types = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filterData'])) {
        $filterData = json_decode($_POST['filterData'], true);

        if (isset($filterData['filterName']) && !empty($filterData['filterName'])) {
            $filters[] = "patient_name LIKE ?";
            $params[] = "%" . $filterData['filterName'] . "%";
            $types .= "s";
        }
        if (isset($filterData['filterStartDate']) && !empty($filterData['filterStartDate'])) {
            $filters[] = "date_of_birth >= ?";
            $params[] = $filterData['filterStartDate'];
            $types .= "s";
        }
        if (isset($filterData['filterEndDate']) && !empty($filterData['filterEndDate'])) {
            $filters[] = "date_of_birth <= ?";
            $params[] = $filterData['filterEndDate'];
            $types .= "s";
        }
        if (isset($filterData['filterAdmissionType']) && !empty($filterData['filterAdmissionType'])) {
            $filters[] = "registration_type = ?";
            $params[] = $filterData['filterAdmissionType'];
            $types .= "s";
        }
        if (isset($filterData['filterStatus']) && !empty($filterData['filterStatus'])) {
            $filters[] = "status = ?";
            $params[] = $filterData['filterStatus'];
            $types .= "s";
        }
        if (isset($filterData['filterGender']) && !empty($filterData['filterGender'])) {
            $filters[] = "gender = ?";
            $params[] = $filterData['filterGender'];
            $types .= "s";
        }
        if (isset($filterData['filterAge']) && !empty($filterData['filterAge'])) {
            $filters[] = "TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) = ?";
            $params[] = intval($filterData['filterAge']);
            $types .= "i";
        }
    }

    // Construct the WHERE clause
    $where_clause = $filters ? implode(" AND ", $filters) : "1=1";
    $query = "SELECT patient_id, patient_name, date_of_birth, gender, contact_number FROM patients WHERE $where_clause";

    // Prepare the statement
    $stmt = $conn->prepare($query);

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
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing your request']);
} finally {
    $conn->close();
}
?>
