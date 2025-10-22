<?php
header('Content-Type: application/json');

// ✅ Replace with your Gemini API Key
$API_KEY = "";

$data = json_decode(file_get_contents("php://input"), true);
$user_message = trim($data["message"] ?? '');

if (empty($user_message)) {
    echo json_encode(["reply" => "Please type something first."]);
    exit;
}

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $API_KEY;

$payload = [
    "contents" => [
        ["parts" => [["text" => "You are a friendly Kerala Tourism Chat Assistant. Be brief, warm, and helpful.\nUser: $user_message"]]]
    ]
];

$options = [
    "http" => [
        "header"  => "Content-Type: application/json\r\n",
        "method"  => "POST",
        "content" => json_encode($payload),
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === FALSE) {
    echo json_encode(["reply" => "Sorry, I'm having trouble connecting right now."]);
    exit;
}

$json = json_decode($response, true);
$reply = $json['candidates'][0]['content']['parts'][0]['text'] ?? "I'm not sure how to respond.";

echo json_encode(["reply" => nl2br(htmlspecialchars($reply))]);
