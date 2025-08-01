<?php
require_once 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Contact Messages Table Test</h2>";
    
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'contact_messages'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Contact messages table exists</p>";
        
        // Count messages
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM contact_messages");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "<p>Total contact messages: $count</p>";
        
        // Show recent messages
        $stmt = $pdo->query("
            SELECT cm.*, u.name as sender_name 
            FROM contact_messages cm 
            LEFT JOIN users u ON cm.sent_by = u.id 
            ORDER BY cm.created_at DESC 
            LIMIT 5
        ");
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($messages) {
            echo "<h3>Recent Messages:</h3>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Status</th><th>Sent By</th><th>Created</th></tr>";
            
            foreach ($messages as $msg) {
                echo "<tr>";
                echo "<td>{$msg['id']}</td>";
                echo "<td>{$msg['name']}</td>";
                echo "<td>{$msg['email']}</td>";
                echo "<td>" . substr($msg['message'], 0, 50) . "...</td>";
                echo "<td>{$msg['status']}</td>";
                echo "<td>{$msg['sender_name']}</td>";
                echo "<td>{$msg['created_at']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No messages found</p>";
        }
        
    } else {
        echo "<p style='color: red;'>✗ Contact messages table does not exist</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Database Error: " . $e->getMessage() . "</p>";
}
?>

<h3>Test Contact API</h3>
<p>You can test the contact API by visiting: <a href="contact_api.php" target="_blank">contact_api.php</a></p>
<p>This will show all contact messages in JSON format.</p>

<h3>Test Contact Form</h3>
<p>Visit the contact page to test the form: <a href="contact.php">contact.php</a></p> 