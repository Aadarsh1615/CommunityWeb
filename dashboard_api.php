<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        getDashboardStats();
        break;
    default:
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

function getDashboardStats() {
    global $pdo;
    
    try {
        // Get total members count
        $stmt = $pdo->query("SELECT COUNT(*) as total_members FROM members WHERE status = 'active'");
        $totalMembers = $stmt->fetch(PDO::FETCH_ASSOC)['total_members'];
        
        // Get total users count
        $stmt = $pdo->query("SELECT COUNT(*) as total_users FROM users");
        $totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];
        
        // Get recent contact messages count (last 7 days)
        $stmt = $pdo->query("SELECT COUNT(*) as recent_activity FROM contact_messages WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
        $recentActivity = $stmt->fetch(PDO::FETCH_ASSOC)['recent_activity'];
        
        // Calculate growth rate (new members in last 30 days vs previous 30 days)
        $stmt = $pdo->query("
            SELECT 
                (SELECT COUNT(*) FROM members WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as current_month,
                (SELECT COUNT(*) FROM members WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY) AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)) as previous_month
        ");
        $growthData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $currentMonth = $growthData['current_month'];
        $previousMonth = $growthData['previous_month'];
        
        // Calculate growth rate percentage
        $growthRate = 0;
        if ($previousMonth > 0) {
            $growthRate = round((($currentMonth - $previousMonth) / $previousMonth) * 100, 1);
        } elseif ($currentMonth > 0) {
            $growthRate = 100; // New growth
        }
        
        // Get member growth data for charts (last 7 days)
        $stmt = $pdo->query("
            SELECT DATE(created_at) as date, COUNT(*) as count 
            FROM members 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            GROUP BY DATE(created_at)
            ORDER BY date
        ");
        $memberGrowth = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'stats' => [
                'total_members' => (int)$totalMembers,
                'active_groups' => (int)$totalUsers, // Using users as groups for now
                'recent_activity' => (int)$recentActivity,
                'growth_rate' => $growthRate,
                'member_growth' => $memberGrowth
            ]
        ]);
        
    } catch(PDOException $e) {
        echo json_encode(['error' => 'Failed to fetch dashboard stats: ' . $e->getMessage()]);
    }
}
?> 