<?php
include('../config/session_start.php');
header('Content-Type: application/json');
include('../config/dbconn.php');

try {
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }

    // GET method and patientId in the query string are what we want
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['patientId'])) {
        $patientId = filter_var($_GET['patientId'], FILTER_VALIDATE_INT);

        if ($patientId === false || $patientId <= 0) {
            error_log("Invalid patient ID: " . $_GET['patientId']);
            echo json_encode(['success' => false, 'message' => 'Invalid patient ID']);
            exit;
        }

        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
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
            error_log("Patient not found with id: " . $patientId);
            echo json_encode(['success' => false, 'message' => 'Patient not found']);
            $stmt->close();
            $conn->close();
            exit;
        }
    } else {
        error_log("Invalid request method or missing patient ID");
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