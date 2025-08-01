<?php
// Test script to verify dashboard API functionality
echo "<h2>Dashboard API Test</h2>";

// Test the API directly
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/AdminHub/dashboard_api.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

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
    if ($result && isset($result['success']) && $result['success']) {
        echo "<p style='color: green;'>✓ API call successful!</p>";
        
        $stats = $result['stats'];
        echo "<h3>Dashboard Statistics:</h3>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Metric</th><th>Value</th></tr>";
        echo "<tr><td>Total Members</td><td>{$stats['total_members']}</td></tr>";
        echo "<tr><td>Active Groups</td><td>{$stats['active_groups']}</td></tr>";
        echo "<tr><td>Recent Activity</td><td>{$stats['recent_activity']}</td></tr>";
        echo "<tr><td>Growth Rate</td><td>{$stats['growth_rate']}%</td></tr>";
        echo "</table>";
        
        if (!empty($stats['member_growth'])) {
            echo "<h3>Member Growth Data (Last 7 Days):</h3>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Date</th><th>New Members</th></tr>";
            foreach ($stats['member_growth'] as $growth) {
                echo "<tr><td>{$growth['date']}</td><td>{$growth['count']}</td></tr>";
            }
            echo "</table>";
        }
    } else {
        echo "<p style='color: red;'>✗ API call failed: " . ($result['error'] ?? 'Unknown error') . "</p>";
    }
}

echo "<h3>Database Verification:</h3>";
require_once 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check members count
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM members WHERE status = 'active'");
    $membersCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p><strong>Active Members in Database:</strong> $membersCount</p>";
    
    // Check total members
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM members");
    $totalMembers = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p><strong>Total Members in Database:</strong> $totalMembers</p>";
    
    // Check recent contact messages
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM contact_messages WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $recentMessages = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p><strong>Recent Contact Messages (7 days):</strong> $recentMessages</p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Database Error: " . $e->getMessage() . "</p>";
}

echo "<h3>Links:</h3>";
echo "<p><a href='dashboard.php' target='_blank'>View Dashboard</a></p>";
echo "<p><a href='members.php' target='_blank'>View Members</a></p>";
echo "<p><a href='dashboard_api.php' target='_blank'>View API Response</a></p>";
?> 