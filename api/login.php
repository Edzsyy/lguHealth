<?php
session_start();
header('Content-Type: application/json');
include('../api/config/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validate email and password input
    if (isset($data['email']) && isset($data['password'])) {
        $email = trim($data['email']);
        $password = $data['password'];

        // Sanitize email for safety
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Invalid email format']);
            exit;
        }

        // Prepare statement to check users table
        $stmt = $conn->prepare("SELECT user_id, password, role FROM users WHERE email = ?");
        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Database error']);
            exit;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // If email exists, verify the password
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hashed_password, $role);
            $stmt->fetch();

            // Check if password matches
            if (password_verify($password, $hashed_password)) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);

                // Store user info in session
                $_SESSION['user_id'] = $user_id;
                $_SESSION['role'] = ucfirst(strtolower($role));

                echo json_encode([
                    'success' => true,
                    'role' => ucfirst(strtolower($role)),
                    'session' => $_SESSION
                ]);
                exit;
            }
        }

        // If no match is found or password is incorrect
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
