<?php
session_start();
header('Content-Type: application/json');

include('../config/dbconn.php');

// Replace with your actual Gemini API key
$geminiApiKey = 'AIzaSyCTy3o5XuseEuJbK5H2EdwERmMUH6ExOEA'; // Replace it with your API KEY

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
        exit;
    }

    // Validate the input data
    if (isset($data['symptoms']) && is_array($data['symptoms']) && isset($data['explanation']) && !empty($data['explanation'])) {
        $symptoms = $data['symptoms'];
        $explanation = trim($data['explanation']);

        // Construct a well-formatted prompt
        $prompt = "Based on the following symptoms: " . implode(", ", $symptoms) . "\n";
        $prompt .= "And this explanation by a doctor/nurse: " . $explanation . "\n";
        $prompt .= "What are the likely diagnoses, and what are the recommendations for health recovery? Please provide a brief, clear diagnosis and actionable health recovery tips.";

        // Call the Gemini API
        $geminiResponse = getGeminiAiSuggestions($prompt, $geminiApiKey);

        if ($geminiResponse['success']) {
            echo json_encode([
                'success' => true,
                'aiSickness' => $geminiResponse['aiSickness'],
                'aiHealth' => $geminiResponse['aiHealth']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gemini AI API call failed: ' . $geminiResponse['message']]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing required data (symptoms and explanation)']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();

// Function to call the Gemini AI API
function getGeminiAiSuggestions($prompt, $apiKey) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;

    // Data to send in the request
    $data = [
        'contents' => [
            ['parts' => [['text' => $prompt]]]
        ]
    ];

    // HTTP headers
    $headers = [
        'Content-Type: application/json'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        error_log("cURL Error: " . $error_msg);
        return ['success' => false, 'message' => 'cURL Error: ' . $error_msg];
    }

    curl_close($ch);

    // Process the response from Gemini API
    $responseData = json_decode($response, true);

    // Check if the response contains valid AI output
    if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
        return [
            'success' => true,
            'aiSickness' => "Possible diagnoses: " . $responseData['candidates'][0]['content']['parts'][0]['text'],
            'aiHealth' => "Recommendations for health recovery: " . $responseData['candidates'][0]['content']['parts'][0]['text']
        ];
    } else {
        error_log("Gemini API response structure is incorrect: " . json_encode($responseData));
        return ['success' => false, 'message' => 'Gemini API response structure is incorrect'];
    }
}
?>
