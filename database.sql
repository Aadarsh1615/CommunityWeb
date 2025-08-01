-- Create database
CREATE DATABASE IF NOT EXISTS adminhub;
USE adminhub;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create members table
CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('admin', 'member', 'moderator') DEFAULT 'member',
    status ENUM('active', 'inactive') DEFAULT 'active',
    added_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (added_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Insert sample user for testing
INSERT INTO users (name, email, password) VALUES 
('Test User', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
-- Password is 'password' 

-- Insert sample members for testing (only if user exists)
INSERT INTO members (name, email, role, added_by) 
SELECT 'John Doe', 'john.doe@example.com', 'admin', id FROM users WHERE id = 1
UNION ALL
SELECT 'Jane Smith', 'jane.smith@example.com', 'member', id FROM users WHERE id = 1
UNION ALL
SELECT 'Mike Johnson', 'mike.johnson@example.com', 'moderator', id FROM users WHERE id = 1;

-- Create contact_messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
    sent_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sent_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Insert sample contact message for testing (only if user exists)
INSERT INTO contact_messages (name, email, message, sent_by)
SELECT 'Sample User', 'sample@example.com', 'This is a sample contact message for testing purposes.', id FROM users WHERE id = 1; 