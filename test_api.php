<?php
require_once 'config.php';

echo "<h2>Testing Members API</h2>";

// Test adding a member
$testData = [
    'name' => 'Test Member',
    'email' => 'testmember@example.com',
    'role' => 'member'
];

echo "<h3>Testing Add Member API</h3>";

// Simulate the API call
$_GET['action'] = 'add';
$_SERVER['REQUEST_METHOD'] = 'POST';

// Capture the output
ob_start();
include 'members_api.php';
$output = ob_get_clean();

echo "<p>API Response:</p>";
echo "<pre>" . htmlspecialchars($output) . "</pre>";

// Test getting all members
echo "<h3>Testing Get All Members API</h3>";

$_GET['action'] = 'get_all';
$_SERVER['REQUEST_METHOD'] = 'GET';

ob_start();
include 'members_api.php';
$output = ob_get_clean();

echo "<p>API Response:</p>";
echo "<pre>" . htmlspecialchars($output) . "</pre>";
?> 