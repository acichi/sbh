<?php
require '../properties/connection.php';

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Convert amount to centavos for PayMongo
$amount = (float)$data['amount'] * 100;
$paymentType = strtolower($data['payment_type']);

// Normalize card-based types for PayMongo
$validTypes = ['gcash', 'paymaya', 'card'];
if ($paymentType === 'visa' || $paymentType === 'mastercard') {
    $paymentType = 'card';
}

if (!in_array($paymentType, $validTypes)) {
    echo json_encode(['error' => 'Invalid payment type']);
    exit;
}

$headers = [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode('sk_test_FSqBor49LkwXZ7N4fsn1ubtK:')
];

$body = [
    'data' => [
        'attributes' => [
            'line_items' => [[
                'currency' => 'PHP',
                'amount' => (int)$amount,
                'description' => $data['facility_name'],
                'name' => 'Reservation for ' . $data['reservee'],
                'quantity' => 1
            ]],
            'payment_method_types' => [$paymentType],
            'redirect' => [
                'success' => 'http://localhost/sbr/success.php',
                'failed' => 'http://localhost/sbr/failed.php'
            ]
        ]
    ]
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.paymongo.com/v1/checkout_sessions',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($body),
    CURLOPT_HTTPHEADER => $headers,
]);

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo json_encode(['error' => 'Curl error: ' . $err]);
    exit;
}

$res = json_decode($response, true);

// Ensure successful creation of checkout session
if (
    isset($res['data']['id']) &&
    isset($res['data']['attributes']['checkout_url'])
) {
    $transactionId   = $res['data']['id'];
    $checkoutUrl     = $res['data']['attributes']['checkout_url'];
    $reservee        = $data['reservee'];
    $facilityName    = $data['facility_name'];
    $amountPaid      = $data['amount']; // In pesos
    $balance         = 0; // Default
    $dateCheckin     = $data['date_start'];
    $dateCheckout    = $data['date_end'];
    $timestamp       = date('Y-m-d H:i:s');
    $dateBooked      = $data['date_booked'];
    $paymentTypeDB   = ucfirst($data['payment_type']); // Store as: GCash, Visa, etc.

    // Insert into receipt table
    $stmt = $conn->prepare("INSERT INTO receipt (
        transaction_id, reservee, facility_name, amount_paid, balance,
        date_checkin, date_checkout, timestamp, date_booked, payment_type
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssdsssss",
        $transactionId,
        $reservee,
        $facilityName,
        $amountPaid,
        $balance,
        $dateCheckin,
        $dateCheckout,
        $timestamp,
        $dateBooked,
        $paymentTypeDB
    );

    if ($stmt->execute()) {
        // Update facility status to 'Unavailable'
        $update = $conn->prepare("UPDATE facility SET status = 'Unavailable' WHERE name = ?");
        $update->bind_param("s", $facilityName);
        if ($update->execute()) {
            echo json_encode(['checkout_url' => $checkoutUrl]);
        } else {
            echo json_encode(['error' => 'Checkout created, but failed to update facility status']);
        }
        $update->close();
    } else {
        echo json_encode(['error' => 'DB insert failed: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid PayMongo response']);
}
