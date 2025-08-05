<?php
function sendSMS($recipients, $message) {
    $deviceId = '6887177d6eec0f67df7d3daa';  // your device ID
    $apiKey   = '0d2de39f-8e1e-4996-a699-9d196a5e62d9';  // your API key

    $url = "https://api.textbee.dev/api/v1/gateway/devices/$deviceId/send-sms";

    $data = [
        'recipients' => $recipients,
        'message' => $message,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'x-api-key: ' . $apiKey,
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);

    curl_close($ch);

    return [
        'status_code' => $httpcode,
        'response' => $response,
        'error' => $error
    ];
}
