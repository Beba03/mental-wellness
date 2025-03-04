<?php
include("APIKey.php");

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$userInput = $data['userInput'] ?? '';

if (!$userInput) {
    echo json_encode(["error" => "No input provided"]);
    exit;
}

// Set up request payload
$requestData = [
    "contents" => [
        [
            "role" => "user",
            "parts" => [
                ["text" => "You are a mental health AI. Provide a reassuring and positive response: " . $userInput]
            ]
        ]
    ]
];

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . API_KEY;

$options = [
    "http" => [
        "header" => "Content-Type: application/json\r\n",
        "method" => "POST",
        "content" => json_encode($requestData),
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === false) {
    echo json_encode(["error" => "Failed to fetch AI response"]);
} else {
    echo $response;
}
?>

