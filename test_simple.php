<?php
require_once 'config.php';

echo "<h2>Simple Database Test</h2>";

try {
    // Test database connection
    echo "<p>✓ Database connection successful</p>";
    
    // Check users
    $stmt = $pdo->query("SELECT id, name, email FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<p>✓ Users found: " . count($users) . "</p>";
    foreach ($users as $user) {
        echo "<p>- User ID: {$user['id']}, Name: {$user['name']}, Email: {$user['email']}</p>";
    }
    
    // Check members
    $stmt = $pdo->query("SELECT id, name, email, role FROM members WHERE status = 'active'");
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<p>✓ Active members found: " . count($members) . "</p>";
    foreach ($members as $member) {
        echo "<p>- Member ID: {$member['id']}, Name: {$member['name']}, Email: {$member['email']}, Role: {$member['role']}</p>";
    }
    
    // Test API endpoint
    echo "<h3>Testing API Endpoint</h3>";
    $url = 'http://localhost/AdminHub/members_api.php?action=get_all';
    $response = file_get_contents($url);
    echo "<p>API Response:</p>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
    
} catch (Exception $e) {
    echo "<p>✗ Error: " . $e->getMessage() . "</p>";
}
?> 