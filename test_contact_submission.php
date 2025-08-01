<?php
// Test script to directly test contact form submission
require_once 'config.php';

echo "<h2>Testing Contact Form Submission</h2>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Test data
    $testData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'message' => 'This is a test message from the test script.'
    ];
    
    echo "<p>Testing with data: " . json_encode($testData) . "</p>";
    
    // Simulate the API call
    session_start();
    $sent_by = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
    $stmt = $pdo->prepare("
        INSERT INTO contact_messages (name, email, message, sent_by)
        VALUES (?, ?, ?, ?)
    ");
    
    $stmt->execute([$testData['name'], $testData['email'], $testData['message'], $sent_by]);
    
    $message_id = $pdo->lastInsertId();
    
    echo "<p style='color: green;'>✓ Message inserted successfully with ID: $message_id</p>";
    
    // Verify the insertion
    $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
    $stmt->execute([$message_id]);
    $message = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($message) {
        echo "<h3>Inserted Message Details:</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        foreach ($message as $field => $value) {
            echo "<tr><td>$field</td><td>$value</td></tr>";
        }
        echo "</table>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>✗ Database Error: " . $e->getMessage() . "</p>";
}

echo "<h3>Test Contact API Endpoint</h3>";
echo "<p>You can also test the API endpoint directly:</p>";
echo "<p><a href='contact_api.php' target='_blank'>View contact_api.php</a></p>";
echo "<p>This should show all contact messages in JSON format.</p>";
?> 