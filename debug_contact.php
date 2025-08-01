<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug Contact Form</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .debug-section { margin: 20px 0; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
    </style>
</head>
<body>
    <h1>Contact Form Debug</h1>
    
    <div class="debug-section">
        <h3>1. Session Check</h3>
        <?php if (isset($_SESSION['user_id'])): ?>
            <p class="success">✓ User logged in: <?php echo $_SESSION['user_name']; ?> (ID: <?php echo $_SESSION['user_id']; ?>)</p>
        <?php else: ?>
            <p class="error">✗ No user session found</p>
        <?php endif; ?>
    </div>
    
    <div class="debug-section">
        <h3>2. Database Connection Test</h3>
        <?php
        require_once 'config.php';
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<p class='success'>✓ Database connection successful</p>";
            
            // Check if contact_messages table exists
            $stmt = $pdo->query("SHOW TABLES LIKE 'contact_messages'");
            if ($stmt->rowCount() > 0) {
                echo "<p class='success'>✓ Contact messages table exists</p>";
                
                // Count messages
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM contact_messages");
                $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                echo "<p class='info'>Current messages in database: $count</p>";
            } else {
                echo "<p class='error'>✗ Contact messages table does not exist</p>";
            }
        } catch(PDOException $e) {
            echo "<p class='error'>✗ Database connection failed: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
    
    <div class="debug-section">
        <h3>3. Test Contact Form</h3>
        <form id="testForm">
            <label>Name: <input type="text" name="name" value="Debug Test User" required></label><br><br>
            <label>Email: <input type="email" name="email" value="debug@test.com" required></label><br><br>
            <label>Message: <textarea name="message" required>This is a debug test message.</textarea></label><br><br>
            <button type="submit">Test Submit</button>
        </form>
        <div id="result"></div>
    </div>
    
    <div class="debug-section">
        <h3>4. Direct API Test</h3>
        <button onclick="testAPI()">Test API Directly</button>
        <div id="apiResult"></div>
    </div>
    
    <div class="debug-section">
        <h3>5. Links</h3>
        <p><a href="contact.php" target="_blank">Open Contact Form</a></p>
        <p><a href="contact_api.php" target="_blank">View API Response</a></p>
        <p><a href="test_contact.php" target="_blank">View Database Messages</a></p>
    </div>

    <script>
        // Test form submission
        document.getElementById('testForm').onsubmit = async function(e) {
            e.preventDefault();
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = '<p class="info">Testing form submission...</p>';
            
            const formData = new FormData(this);
            const data = {
                name: formData.get('name'),
                email: formData.get('email'),
                message: formData.get('message')
            };
            
            console.log('Sending data:', data);
            
            try {
                const response = await fetch('contact_api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                
                const responseText = await response.text();
                console.log('Response:', responseText);
                
                const result = JSON.parse(responseText);
                
                if (result.success) {
                    resultDiv.innerHTML = '<p class="success">✓ Form submission successful! Message ID: ' + result.message_id + '</p>';
                } else {
                    resultDiv.innerHTML = '<p class="error">✗ Form submission failed: ' + (result.error || 'Unknown error') + '</p>';
                }
            } catch (error) {
                resultDiv.innerHTML = '<p class="error">✗ Error: ' + error.message + '</p>';
                console.error('Error:', error);
            }
        };
        
        // Test API directly
        async function testAPI() {
            const apiResultDiv = document.getElementById('apiResult');
            apiResultDiv.innerHTML = '<p class="info">Testing API...</p>';
            
            const testData = {
                name: 'API Test User',
                email: 'apitest@example.com',
                message: 'Direct API test message'
            };
            
            try {
                const response = await fetch('contact_api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(testData)
                });
                
                const responseText = await response.text();
                const result = JSON.parse(responseText);
                
                if (result.success) {
                    apiResultDiv.innerHTML = '<p class="success">✓ API test successful! Message ID: ' + result.message_id + '</p>';
                } else {
                    apiResultDiv.innerHTML = '<p class="error">✗ API test failed: ' + (result.error || 'Unknown error') + '</p>';
                }
            } catch (error) {
                apiResultDiv.innerHTML = '<p class="error">✗ API Error: ' + error.message + '</p>';
            }
        }
    </script>
</body>
</html> 