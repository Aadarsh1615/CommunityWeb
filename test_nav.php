<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<h2>Not Logged In</h2>";
    echo "<p>You need to be logged in to access the pages.</p>";
    echo "<p><a href='login.php'>Go to Login</a></p>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Navigation Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .nav-test { margin: 20px 0; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
        .nav-test a { display: inline-block; margin: 5px 10px; padding: 10px 15px; background: #2563eb; color: white; text-decoration: none; border-radius: 5px; }
        .nav-test a:hover { background: #1741a6; }
        .session-info { background: #f0f0f0; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Navigation Test</h1>
    
    <div class="session-info">
        <h3>Session Information:</h3>
        <p><strong>User ID:</strong> <?php echo $_SESSION['user_id']; ?></p>
        <p><strong>User Name:</strong> <?php echo $_SESSION['user_name']; ?></p>
        <p><strong>User Email:</strong> <?php echo $_SESSION['user_email']; ?></p>
    </div>
    
    <div class="nav-test">
        <h3>Test Navigation Links:</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="members.php">Members</a>
        <a href="groups.php">Groups</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
    </div>
    
    <div class="nav-test">
        <h3>Other Links:</h3>
        <a href="logout.php">Logout</a>
        <a href="account.php">Account</a>
    </div>
</body>
</html> 