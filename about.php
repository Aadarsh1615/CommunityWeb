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
    <title>About Us - AdminHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body {
            margin: 0;
            background: #f6f8fb;
        }
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            min-width: 220px;
            background: linear-gradient(135deg, #1e4db7 0%, #2563eb 100%);
            color: #fff;
            min-height: 100vh;
            position: relative;
            z-index: 10;
        }
        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            padding: 0 32px;
            height: 68px;
            border-bottom: 1.5px solid #f0f2f7;
            position: relative;
            z-index: 5;
        }
        .main-content {
            flex: 1;
            padding: 48px 0 0 0;
            display: flex;
            flex-direction: column;
        }
        .about-content-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 32px 32px 0 32px;
        }
        .about-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 8px;
        }
        .about-subtitle {
            color: #6b7280;
            font-size: 1.18rem;
            margin-bottom: 32px;
        }
        .about-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 2px 8px 0 rgba(30,77,183,0.04);
            padding: 32px 28px;
            max-width: 700px;
            margin: 0 auto;
        }
        .about-section-title {
            font-size: 1.18rem;
            font-weight: 600;
            margin-top: 24px;
            margin-bottom: 8px;
            color: #222;
        }
        .about-text {
            color: #444;
            font-size: 1.08rem;
            margin-bottom: 10px;
        }
        @media (max-width: 900px) {
            .sidebar { width: 60px; min-width: 60px; }
            .main-area { margin-left: 60px; }
            .about-content-wrapper { padding: 24px 8px 0 8px; }
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
                <a href="dashboard.php" class="sidebar-link" id="nav-dashboard"><i data-feather="grid"></i> Dashboard</a>
                <a href="members.php" class="sidebar-link" id="nav-members"><i data-feather="users"></i> All Members</a>
                <a href="groups.php" class="sidebar-link" id="nav-groups"><i data-feather="layers"></i> Group Info</a>
                <a href="about.php" class="sidebar-link active" id="nav-about"><i data-feather="info"></i> About Us</a>
                <a href="contact.php" class="sidebar-link" id="nav-contact"><i data-feather="mail"></i> Contact Us</a>
            </nav>
        </aside>
        <div class="main-area">
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
                        <span class="topbar-title">About Us</span>
                    </div>
                    <div class="topbar-search">
                        <i data-feather="search"></i>
                        <input type="text" placeholder="Search anything...">
                    </div>
                </div>
                <div class="topbar-actions">
                    <button class="topbar-icon-btn"><i data-feather="bell"></i></button>
                    <button class="topbar-profile"><i data-feather="user"></i></button>
                </div>
            </div>
            <!-- Main Content -->
            <main class="main-content">
                <div class="about-content-wrapper">
                    <div class="about-title">About Us</div>
                    <div class="about-subtitle">Learn more about AdminHub and our mission.</div>
                    <div class="about-card">
                        <div class="about-section-title">Who We Are</div>
                        <div class="about-text">
                            <b>AdminHub</b> is a professional network platform designed for community management and collaboration. Our mission is to empower admins and members to connect, share, and grow together.
                        </div>
                        <div class="about-section-title">Our Mission</div>
                        <div class="about-text">
                            We aim to provide a seamless experience for managing groups, tracking activity, and fostering engagement within your community.
                        </div>
                        <div class="about-section-title">Contact</div>
                        <div class="about-text">
                            Have questions or feedback? <a href="contact.php" style="color:#2563eb;text-decoration:underline;">Contact us</a> any time.
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        feather.replace();
        document.getElementById('nav-about').classList.add('active');
    </script>
</body>
</html>