<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection to get additional user details
$host = 'localhost';
$dbname = 'adminhub';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get user details from database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
} catch(PDOException $e) {
    $user = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - AdminHub</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Segoe+UI:400,600,700&display=swap">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        .account-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        
        .account-header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            text-align: center;
        }
        
        .account-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 3rem;
            color: white;
            font-weight: bold;
        }
        
        .account-name {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        .account-role {
            background: #2563eb;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .account-email {
            color: #666;
            font-size: 1.1rem;
        }
        
        .account-details {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .details-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 25px;
            border-bottom: 2px solid #f0f2f7;
            padding-bottom: 15px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f2f7;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #555;
            font-size: 1rem;
        }
        
        .detail-value {
            color: #333;
            font-size: 1rem;
        }
        
        .back-btn {
            background: #2563eb;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            transition: background 0.3s ease;
        }
        
        .back-btn:hover {
            background: #1e4db7;
        }
        
        .account-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border-left: 4px solid #2563eb;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .account-container {
                margin: 20px auto;
                padding: 10px;
            }
            
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .account-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="account-container">
        <!-- Navigation Buttons -->
        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
            <a href="dashboard.php" class="back-btn">
                <i data-feather="arrow-left"></i>
                Back to Dashboard
            </a>
            <a href="logout.php" class="back-btn" style="background: #dc3545;">
                <i data-feather="log-out"></i>
                Logout
            </a>
        </div>
        
        <!-- Account Header -->
        <div class="account-header">
            <div class="account-avatar">
                <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
            </div>
            <h1 class="account-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
            <div class="account-role">Administrator</div>
            <div class="account-email"><?php echo htmlspecialchars($_SESSION['user_email']); ?></div>
        </div>
        
        <!-- Account Details -->
        <div class="account-details">
            <h2 class="details-title">Account Information</h2>
            
            <div class="detail-row">
                <span class="detail-label">Full Name</span>
                <span class="detail-value"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Email Address</span>
                <span class="detail-value"><?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">User ID</span>
                <span class="detail-value">#<?php echo $_SESSION['user_id']; ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Role</span>
                <span class="detail-value">Administrator</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Account Created</span>
                <span class="detail-value">
                    <?php 
                    if ($user && $user['created_at']) {
                        $created_date = new DateTime($user['created_at']);
                        echo $created_date->format('F Y'); // Month and Year
                    } else {
                        echo 'N/A';
                    }
                    ?>
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Last Login</span>
                <span class="detail-value">
                    <?php echo date('F j, Y \a\t g:i A', $_SESSION['login_time']); ?>
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Account Status</span>
                <span class="detail-value" style="color: #22c55e; font-weight: 600;">Active</span>
            </div>
        </div>
        
        <!-- Account Statistics -->
        <div class="account-stats">
            <div class="stat-card">
                <div class="stat-number">1</div>
                <div class="stat-label">Total Logins</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Groups Created</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Members Added</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-number">100%</div>
                <div class="stat-label">Account Security</div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Feather icons
        feather.replace();
    </script>
</body>
</html> 