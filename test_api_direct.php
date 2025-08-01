<?php
// Test script to directly test the contact API
echo "<h2>Testing Contact API Directly</h2>";

// Test data
$testData = [
    'name' => 'API Test User',
    'email' => 'apitest@example.com',
    'message' => 'This is a test message sent directly to the API.'
];

echo "<p>Testing with data: " . json_encode($testData) . "</p>";

// Create a cURL request to test the API
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'http://localhost/AdminHub/contact_api.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen(json_encode($testData))
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

curl_close($ch);

echo "<h3>API Response:</h3>";
echo "<p><strong>HTTP Code:</strong> $httpCode</p>";

if ($error) {
    echo "<p style='color: red;'>cURL Error: $error</p>";
} else {
    echo "<p><strong>Response:</strong> $response</p>";
    
    $result = json_decode($response, true);
    if ($result) {
        if (isset($result['success']) && $result['success']) {
            echo "<p style='color: green;'>✓ API call successful!</p>";
            echo "<p>Message ID: " . $result['message_id'] . "</p>";
        } else {
            echo "<p style='color: red;'>✗ API call failed: " . ($result['error'] ?? 'Unknown error') . "</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Invalid JSON response</p>";
    }
}

echo "<h3>Check Database:</h3>";
echo "<p><a href='test_contact.php' target='_blank'>View contact messages in database</a></p>";
echo "<p><a href='contact_api.php' target='_blank'>View all messages via API</a></p>";
?> 