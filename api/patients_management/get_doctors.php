<?php
session_start();
header('Content-Type: application/json');
include('../../admin/assets/config/dbconn.php');

$stmt = $conn->prepare("SELECT u.user_id, u.user_name, COUNT(da.patient_id) AS patient_count
                        FROM users u
                        LEFT JOIN doctor_assignments da ON u.user_id = da.doctor_id
                        WHERE u.role = 'Doctor'
                        GROUP BY u.user_id, u.user_name");
$stmt->execute();
$result = $stmt->get_result();
$doctors = array();
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}
$stmt->close();
$conn->close();
echo json_encode($doctors);
?>