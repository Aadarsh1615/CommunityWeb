<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once 'config.php';

// Debug: Check if config variables are available
if (!isset($host) || !isset($dbname) || !isset($username) || !isset($password)) {
    echo json_encode(['error' => 'Database configuration not found']);
    exit();
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_log("Database connection successful in contact_api.php");
} catch(PDOException $e) {
    error_log("Database connection failed in contact_api.php: " . $e->getMessage());
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'POST':
        addContactMessage();
        break;
    case 'GET':
        getContactMessages();
        break;
    default:
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

function addContactMessage() {
    global $pdo;
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Debug: Log the received data
    error_log("Contact API received data: " . json_encode($data));
    
    if (!isset($data['name']) || !isset($data['email']) || !isset($data['message'])) {
        echo json_encode(['error' => 'Name, email, and message are required']);
        return;
    }
    
    $name = trim($data['name']);
    $email = trim($data['email']);
    $message = trim($data['message']);
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Invalid email format']);
        return;
    }
    
    // Validate input lengths
    if (strlen($name) > 100) {
        echo json_encode(['error' => 'Name is too long (max 100 characters)']);
        return;
    }
    
    if (strlen($email) > 100) {
        echo json_encode(['error' => 'Email is too long (max 100 characters)']);
        return;
    }
    
    if (strlen($message) > 65535) {
        echo json_encode(['error' => 'Message is too long']);
        return;
    }
    
    try {
        // Get the current user ID from session if available
        session_start();
        $sent_by = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        
        // Debug: Log the values being inserted
        error_log("Inserting contact message - Name: $name, Email: $email, Sent_by: " . ($sent_by ?? 'null'));
        
        $stmt = $pdo->prepare("
            INSERT INTO contact_messages (name, email, message, sent_by)
            VALUES (?, ?, ?, ?)
        ");
        
        $stmt->execute([$name, $email, $message, $sent_by]);
        
        $message_id = $pdo->lastInsertId();
        
        // Debug: Log successful insertion
        error_log("Contact message inserted successfully with ID: $message_id");
        
        echo json_encode([
            'success' => true, 
            'message' => 'Contact message sent successfully',
            'message_id' => $message_id
        ]);
        
    } catch(PDOException $e) {
        error_log("Database error in contact API: " . $e->getMessage());
        echo json_encode(['error' => 'Failed to save message: ' . $e->getMessage()]);
    }
}

function getContactMessages() {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            SELECT cm.*, u.name as sender_name
            FROM contact_messages cm
            LEFT JOIN users u ON cm.sent_by = u.id
            ORDER BY cm.created_at DESC
        ");
        
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'messages' => $messages
        ]);
        
    } catch(PDOException $e) {
        echo json_encode(['error' => 'Failed to retrieve messages: ' . $e->getMessage()]);
    }
}
?> 