<?php
// Database setup script
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect to MySQL without specifying database
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS adminhub");
    echo "Database 'adminhub' created successfully or already exists.<br>";
    
    // Select the database
    $pdo->exec("USE adminhub");
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Table 'users' created successfully or already exists.<br>";
    
    // Insert test user if not exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute(['test@example.com']);
    
    if ($stmt->rowCount() == 0) {
        $hashed_password = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute(['Test User', 'test@example.com', $hashed_password]);
        echo "Test user created successfully.<br>";
        echo "Email: test@example.com<br>";
        echo "Password: password<br>";
    } else {
        echo "Test user already exists.<br>";
    }
    
    echo "<br>Database setup completed successfully!<br>";
    echo "<a href='signup.php'>Go to Signup Page</a> | <a href='login.php'>Go to Login Page</a>";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 