<?php
require_once 'config.php';
header('Content-Type: application/json');

// Enable CORS for AJAX requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'get_all':
            getMembers();
            break;
        case 'add':
            addMember();
            break;
        case 'delete':
            deleteMember();
            break;
        case 'delete_multiple':
            deleteMultipleMembers();
            break;
        case 'update':
            updateMember();
            break;
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

function getMembers() {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT m.*, u.name as added_by_name 
        FROM members m 
        LEFT JOIN users u ON m.added_by = u.id 
        WHERE m.status = 'active' 
        ORDER BY m.created_at DESC
    ");
    $stmt->execute();
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'members' => $members]);
}

function addMember() {
    global $pdo;
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['name']) || !isset($data['email']) || !isset($data['role'])) {
        throw new Exception('Name, email, and role are required');
    }
    
    $name = trim($data['name']);
    $email = trim($data['email']);
    $role = $data['role'];
    
    // Get the first available user ID or use NULL if no users exist
    $stmt = $pdo->prepare("SELECT id FROM users ORDER BY id ASC LIMIT 1");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $added_by = $data['added_by'] ?? ($user ? $user['id'] : null);
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }
    
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM members WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        throw new Exception('Email already exists');
    }
    
    // Insert new member
    $stmt = $pdo->prepare("
        INSERT INTO members (name, email, role, added_by) 
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$name, $email, $role, $added_by]);
    
    $member_id = $pdo->lastInsertId();
    
    // Get the newly created member
    $stmt = $pdo->prepare("
        SELECT m.*, u.name as added_by_name 
        FROM members m 
        LEFT JOIN users u ON m.added_by = u.id 
        WHERE m.id = ?
    ");
    $stmt->execute([$member_id]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'member' => $member]);
}

function deleteMember() {
    global $pdo;
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        throw new Exception('Member ID is required');
    }
    
    $member_id = $data['id'];
    
    // Soft delete by setting status to inactive
    $stmt = $pdo->prepare("UPDATE members SET status = 'inactive' WHERE id = ?");
    $stmt->execute([$member_id]);
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('Member not found');
    }
    
    echo json_encode(['success' => true, 'message' => 'Member deleted successfully']);
}

function deleteMultipleMembers() {
    global $pdo;
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['ids']) || !is_array($data['ids'])) {
        throw new Exception('Member IDs array is required');
    }
    
    $member_ids = $data['ids'];
    $placeholders = str_repeat('?,', count($member_ids) - 1) . '?';
    
    // Soft delete multiple members
    $stmt = $pdo->prepare("UPDATE members SET status = 'inactive' WHERE id IN ($placeholders)");
    $stmt->execute($member_ids);
    
    echo json_encode(['success' => true, 'message' => 'Members deleted successfully']);
}

function updateMember() {
    global $pdo;
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id']) || !isset($data['name']) || !isset($data['email']) || !isset($data['role'])) {
        throw new Exception('ID, name, email, and role are required');
    }
    
    $id = $data['id'];
    $name = trim($data['name']);
    $email = trim($data['email']);
    $role = $data['role'];
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }
    
    // Check if email already exists for other members
    $stmt = $pdo->prepare("SELECT id FROM members WHERE email = ? AND id != ?");
    $stmt->execute([$email, $id]);
    if ($stmt->fetch()) {
        throw new Exception('Email already exists');
    }
    
    // Update member
    $stmt = $pdo->prepare("UPDATE members SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->execute([$name, $email, $role, $id]);
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('Member not found');
    }
    
    // Get the updated member
    $stmt = $pdo->prepare("
        SELECT m.*, u.name as added_by_name 
        FROM members m 
        LEFT JOIN users u ON m.added_by = u.id 
        WHERE m.id = ?
    ");
    $stmt->execute([$id]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'member' => $member]);
}
?> 