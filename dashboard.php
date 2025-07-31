<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - AdminHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Segoe+UI:400,600,700&display=swap">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        /* Topbar styles */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            padding: 0 32px;
            height: 68px;
            border-bottom: 1.5px solid #f0f2f7;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .topbar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .topbar-logo svg {
            background: #2563eb;
            border-radius: 8px;
            padding: 4px;
        }
        .topbar-title {
            font-size: 1.45rem;
            font-weight: 700;
            color: #2563eb;
        }
        .topbar-search {
            display: flex;
            align-items: center;
            background: #f7fafd;
            border-radius: 24px;
            padding: 0 18px;
            border: 1.5px solid #e6eaf1;
            height: 44px;
            gap: 8px;
            margin-left: 24px;
            min-width: 320px;
        }
        .topbar-search input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 1.08rem;
            width: 220px;
            padding: 8px 0;
        }
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .topbar-icon-btn {
            background: #f7fafd;
            border: none;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 1.3rem;
            cursor: pointer;
        }
        .topbar-profile {
            background: #e0e7ff;
            color: #2563eb;
            border: none;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            cursor: pointer;
        }
        /* Main content tweaks */
        .main-content {
            flex: 1;
            background: #f5f7fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 36px;
        }
        .welcome-row {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #222;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .page-desc {
            color: #6b7280;
            font-size: 1.08rem;
            margin-bottom: 24px;
        }
        .cards-row {
            display: flex;
            gap: 24px;
            margin-bottom: 28px;
        }
        .dashboard-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 8px 0 rgba(30,77,183,0.04);
            padding: 22px 24px 18px 24px;
            min-width: 210px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
            border-top: 4px solid #2563eb;
        }
        .dashboard-card .card-header {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.08rem;
            color: #2563eb;
            font-weight: 600;
        }
        .dashboard-card .card-value {
            font-size: 2.1rem;
            font-weight: 700;
            color: #222;
        }
        .dashboard-card .card-growth {
            font-size: 1rem;
            color: #22c55e;
            display: flex;
            align-items: center;
            gap: 2px;
        }
        .charts-row {
            display: flex;
            gap: 24px;
            margin-top: 0;
        }
        .chart-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 8px 0 rgba(30,77,183,0.04);
            padding: 18px 18px 18px 18px;
            flex: 1;
            min-width: 320px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .chart-header {
            font-size: 1.13rem;
            font-weight: 600;
            color: #222;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .chart-tabs {
            display: flex;
            gap: 8px;
        }
        .chart-tabs button {
            background: #f3f6fa;
            border: none;
            border-radius: 8px;
            padding: 4px 14px;
            font-size: 0.98rem;
            font-weight: 600;
            color: #2563eb;
            cursor: pointer;
            transition: background 0.15s;
        }
        .chart-tabs button.active,
        .chart-tabs button:hover {
            background: #2563eb;
            color: #fff;
        }
        .chart-placeholder {
            border: 2px dashed #e0e7ef;
            border-radius: 10px;
            min-height: 160px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #b1b5c3;
            font-size: 1.13rem;
            gap: 8px;
        }
        @media (max-width: 1100px) {
            .cards-row, .charts-row { flex-direction: column; gap: 18px; }
            .main-content { padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <svg width="40" height="40" viewBox="0 0 64 64" fill="none">
                        <rect x="20" y="10" width="24" height="32" rx="12" fill="#fff" opacity="0.1"/>
                        <rect x="28" y="18" width="8" height="20" rx="4" fill="#fff"/>
                        <rect x="24" y="38" width="16" height="4" rx="2" fill="#fff"/>
                        <polygon points="32,54 22,44 42,44" fill="#fff" opacity="0.2"/>
                    </svg>
                </div>
                <span class="sidebar-title">AdminHub</span>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="sidebar-link active" id="nav-dashboard"><i data-feather="grid"></i> Dashboard</a>
                <a href="members.html" class="sidebar-link" id="nav-members"><i data-feather="users"></i> All Members</a>
                <a href="groups.html" class="sidebar-link" id="nav-groups"><i data-feather="layers"></i> Group Info</a>
                <a href="about.html" class="sidebar-link" id="nav-about"><i data-feather="info"></i> About Us</a>
                <a href="contact.html" class="sidebar-link" id="nav-contact"><i data-feather="mail"></i> Contact Us</a>
            </nav>
        </aside>
        <div style="flex:1;display:flex;flex-direction:column;">
            <!-- Topbar -->
            <div class="topbar">
                <div class="topbar-left">
                    <div class="topbar-logo">
                        <svg width="32" height="32" viewBox="0 0 64 64" fill="none">
                            <rect x="20" y="10" width="24" height="32" rx="12" fill="#2563eb" opacity="0.12"/>
                            <rect x="28" y="18" width="8" height="20" rx="4" fill="#2563eb"/>
                            <rect x="24" y="38" width="16" height="4" rx="2" fill="#2563eb"/>
                            <polygon points="32,54 22,44 42,44" fill="#2563eb" opacity="0.18"/>
                        </svg>
                        <span class="topbar-title">Dashboard</span>
                    </div>
                    <div class="topbar-search">
                        <i data-feather="search"></i>
                        <input type="text" placeholder="Search anything...">
                    </div>
                </div>
                <div class="topbar-actions">
                    <button class="topbar-icon-btn"><i data-feather="bell"></i></button>
                    <a href="account.php" class="topbar-profile" style="text-decoration: none;"><i data-feather="user"></i></a>
                </div>
            </div>
            <!-- Main Content -->
            <main class="main-content">
                <div class="welcome-row">
                    Welcome back, <span id="userName">John</span>! <span>👋</span>
                </div>
                <div class="page-desc">Here's what's happening with your community today.</div>
                <!-- Cards Row -->
                <section class="cards-row">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <span>Total Members</span>
                            <i data-feather="users"></i>
                        </div>
                        <div class="card-value">0</div>
                        <div class="card-growth up"><i data-feather="arrow-up"></i></div>
                    </div>
                    <div class="dashboard-card">
                        <div class="card-header">
                            <span>Active Groups</span>
                            <i data-feather="layers"></i>
                        </div>
                        <div class="card-value">0</div>
                        <div class="card-growth up"><i data-feather="arrow-up"></i></div>
                    </div>
                    <div class="dashboard-card">
                        <div class="card-header">
                            <span>Recent Activity</span>
                            <i data-feather="activity"></i>
                        </div>
                        <div class="card-value">0</div>
                        <div class="card-growth up"><i data-feather="arrow-up"></i></div>
                    </div>
                    <div class="dashboard-card">
                        <div class="card-header">
                            <span>Growth Rate</span>
                            <i data-feather="trending-up"></i>
                        </div>
                        <div class="card-value"></div>
                        <div class="card-growth up"><i data-feather="arrow-up"></i></div>
                    </div>
                </section>
                <!-- Charts Section -->
                <section class="charts-row">
                    <div class="chart-card">
                        <div class="chart-header">
                            Member Growth
                            <div class="chart-tabs">
                                <button class="active">7D</button>
                                <button>30D</button>
                                <button>90D</button>
                            </div>
                        </div>
                        <div class="chart-placeholder">
                            <i data-feather="bar-chart-2"></i>
                            <span>Interactive Chart Area</span>
                        </div>
                    </div>
                    <div class="chart-card">
                        <div class="chart-header">Activity Distribution</div>
                        <div class="chart-placeholder">
                            <i data-feather="pie-chart"></i>
                            <span>Pie Chart</span>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
         <!-- User Welcome Message -->
     <div style="position:fixed; top:20px; right:30px; background:#fff; border-radius:10px; box-shadow:0 2px 10px #0002; padding:15px; z-index:1000; min-width:200px; display:none;" id="welcome-popup">
       <h4 style="margin:0 0 10px 0; color:#2563eb;">Welcome!</h4>
       <p style="margin:0; color:#666;">You are logged in as <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></p>
     </div>

    <script>
        feather.replace();
        // Chart tab switching (UI only)
        document.querySelectorAll('.chart-tabs button').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.chart-tabs button').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
        // Highlight active nav
        document.getElementById('nav-dashboard').classList.add('active');
        
        // Set user name from PHP session
        document.getElementById('userName').textContent = '<?php echo htmlspecialchars($_SESSION['user_name']); ?>';
        
        // Show welcome popup on page load
        setTimeout(function() {
            const welcomePopup = document.getElementById('welcome-popup');
            welcomePopup.style.display = 'block';
            setTimeout(function() {
                welcomePopup.style.display = 'none';
            }, 3000);
        }, 1000);
    </script>
</body>
</html>