-- Contact Messages Table for AdminHub
-- This table stores contact form submissions from users

USE adminhub;

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