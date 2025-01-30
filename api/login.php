<?php
session_start();
// Set response header to JSON
header('Content-Type: application/json');
include('../config/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if(isset($data['email']) && isset($data['password'])){
        $email = trim($data['email']);
        $password = $data['password'];
          // Prepare and execute the query
          $stmt = $conn->prepare("SELECT user_id, password, role FROM users WHERE email = ?");
          $stmt->bind_param("s", $email);
          $stmt->execute();
          $stmt->store_result();
            if ($stmt->num_rows > 0) {
                 $stmt->bind_result($user_id, $hashed_password, $role);
                  $stmt->fetch();
                 if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['role'] = $role;
                     echo json_encode(['success' => true, 'role' => $role]); // Include role in the response
                     exit;
                  }
             }
    }
      echo json_encode(['success' => false]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']); // Added message
}

$conn->close();
?>