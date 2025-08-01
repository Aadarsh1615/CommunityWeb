<?php
require_once 'config.php';

echo "<h2>Testing Members Database</h2>";

try {
    // Test database connection
    echo "<p>✓ Database connection successful</p>";
    
    // Check if members table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'members'");
    if ($stmt->rowCount() > 0) {
        echo "<p>✓ Members table exists</p>";
    } else {
        echo "<p>✗ Members table does not exist</p>";
    }
    
    // Check members count
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM members WHERE status = 'active'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>✓ Active members count: " . $result['count'] . "</p>";
    
    // Show sample members
    $stmt = $pdo->query("SELECT * FROM members WHERE status = 'active' LIMIT 5");
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($members) > 0) {
        echo "<h3>Sample Members:</h3>";
        echo "<ul>";
        foreach ($members as $member) {
            echo "<li>{$member['name']} ({$member['email']}) - {$member['role']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No members found in database</p>";
    }
    
} catch (Exception $e) {
    echo "<p>✗ Error: " . $e->getMessage() . "</p>";
}
?> 