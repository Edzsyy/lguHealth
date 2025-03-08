<?php
session_start();
header('Content-Type: application/json');

include('../config/dbconn.php');

// Check if the user is logged in as a patient (client_id should be set)
if (!isset($_SESSION['client_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Start building the SQL query to get appointments for the logged-in patient (client_id)
$where_clause = "appointments.client_id = ?"; // Filter to get appointments for the logged-in patient
$params = [$_SESSION['client_id']]; // Use logged-in patient's ID for filtering
$types = 'i'; // The client_id is an integer

// Filters (if provided)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_GET['filterDoctor'])) {
        $where_clause .= " AND users.user_name LIKE ?";
        $params[] = "%" . $_GET['filterDoctor'] . "%";
        $types .= 's';
    }

    if (!empty($_GET['filterStartDate'])) {
        $where_clause .= " AND appointments.appointment_date >= ?";
        $params[] = $_GET['filterStartDate'];
        $types .= 's';
    }

    if (!empty($_GET['filterEndDate'])) {
        $where_clause .= " AND appointments.appointment_date <= ?";
        $params[] = $_GET['filterEndDate'];
        $types .= 's';
    }

    if (!empty($_GET['filterStatus'])) {
        $where_clause .= " AND appointments.status = ?";
        $params[] = $_GET['filterStatus'];
        $types .= 's';
    }
}

// Construct SQL Query with JOINs (Ensuring the where clause is applied)
$sql = "SELECT 
    appointments.appointment_id, 
    appointments.patient_name, 
    users.user_name AS doctor_name,  
    appointments.appointment_date, 
    appointments.appointment_time,
    appointments.status, 
    appointments.notes 
FROM appointments 
JOIN users ON appointments.doctor_id = users.user_id 
WHERE appointments.client_id = ? AND $where_clause";  // Apply client_id filter

// Prepare and execute query
$stmt = $conn->prepare($sql);

// Bind parameters if filters exist
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch data
$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

// Output JSON response
echo json_encode($appointments);

// Close connections
$stmt->close();
$conn->close();
?>
