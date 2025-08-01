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
    <title>Contact Us - AdminHub</title>
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
        .contact-content-wrapper {
            max-width: 1500px;
            margin: 0 auto;
            padding: 32px 32px 0 32px;
        }
        .contact-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 8px;
        }
        .contact-subtitle {
            color: #6b7280;
            font-size: 1.18rem;
            margin-bottom: 32px;
        }
        .contact-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 2px 8px 0 rgba(30,77,183,0.04);
            padding: 88px 80px;
            max-width: 1000px;
            margin: 0 auto;
        }
        .contact-form label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
            color: #222;
        }
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1.5px solid #e0e0e0;
            margin-bottom: 18px;
            font-size: 1.08rem;
            background: #f7fafd;
            resize: none;
        }
        .contact-form button {
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 32px;
            font-size: 1.08rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.18s;
        }
        .contact-form button:hover {
            background: #1741a6;
        }
        @media (max-width: 900px) {
            .sidebar { width: 60px; min-width: 60px; }
            .main-area { margin-left: 60px; }
            .contact-content-wrapper { padding: 24px 8px 0 8px; }
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
                <a href="about.php" class="sidebar-link" id="nav-about"><i data-feather="info"></i> About Us</a>
                <a href="contact.php" class="sidebar-link active" id="nav-contact"><i data-feather="mail"></i> Contact Us</a>
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
                        <span class="topbar-title">Contact Us</span>
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
                <div class="contact-content-wrapper">
                    <div class="contact-title">Contact Us</div>
                    <div class="contact-subtitle">We'd love to hear from you. Fill out the form below and our team will get back to you soon.</div>
                    <div class="contact-card">
                        <form class="contact-form">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" required>
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" required>
                            <label for="message">Your Message</label>
                            <textarea id="message" name="message" rows="8" required></textarea>
                            <button type="submit">Send Message</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        feather.replace();
        document.getElementById('nav-contact').classList.add('active');
        
        // Handle contact form submission
        document.querySelector('.contact-form').onsubmit = async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            
            // Debug: Log form data
            console.log('Form data:', {
                name: formData.get('name'),
                email: formData.get('email'),
                message: formData.get('message')
            });
            
            // Disable button and show loading state
            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';
            
            try {
                const requestBody = JSON.stringify({
                    name: formData.get('name'),
                    email: formData.get('email'),
                    message: formData.get('message')
                });
                
                console.log('Sending request to contact_api.php with body:', requestBody);
                
                const response = await fetch('contact_api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: requestBody
                });
                
                console.log('Response status:', response.status);
                const responseText = await response.text();
                console.log('Response text:', responseText);
                
                const result = JSON.parse(responseText);
                
                if (result.success) {
                    alert('Message sent successfully!');
                    this.reset(); // Clear the form
                } else {
                    alert('Error: ' + (result.error || 'Failed to send message'));
                }
                
            } catch (error) {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            } finally {
                // Re-enable button
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }
        };
    </script>
</body>
</html>