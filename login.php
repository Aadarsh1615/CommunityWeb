<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Modern App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <style>
        .styled-input {
            padding: 16px 18px;
            font-size: 1.08rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            outline: none;
            margin-bottom: 18px;
            background: #fff;
            transition: border 0.2s;
            width: 100%;
            box-sizing: border-box;
        }
        .styled-input:focus {
            border-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo">
                <!-- Simple SVG icon -->
                <svg width="80" height="80" viewBox="0 0 64 64" fill="none">
                    <rect x="20" y="10" width="24" height="32" rx="12" fill="#fff" opacity="0.1"/>
                    <rect x="28" y="18" width="8" height="20" rx="4" fill="#fff"/>
                    <rect x="24" y="38" width="16" height="4" rx="2" fill="#fff"/>
                    <polygon points="32,54 22,44 42,44" fill="#fff" opacity="0.2"/>
                </svg>
            </div>
            <h1>AdminHub</h1>
            <p>Professional Network</p>
        </div>
        <div class="right-panel">
            <form class="login-form" id="loginForm" method="POST" action="login_process.php">
                <h2>Welcome back</h2>
                <input type="email" placeholder="Email" required class="styled-input" name="email" id="email" value="<?php echo isset($_SESSION['login_email']) ? htmlspecialchars($_SESSION['login_email']) : ''; ?>">
                <input type="password" placeholder="Password" required class="styled-input" name="password" id="password">
                <div class="options">
                    <label>
                        <input type="checkbox"> Remember sign in details
                    </label>
                    <a href="#" class="forgot">Forgot password?</a>
                </div>
                <button type="submit">Log in</button>
                <div class="signup">
                    Don't have an account? <a href="signup.php">Sign up</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Display error messages if any
        <?php if (isset($_SESSION['login_errors'])): ?>
            <?php foreach ($_SESSION['login_errors'] as $error): ?>
                alert('<?php echo addslashes($error); ?>');
            <?php endforeach; ?>
            <?php unset($_SESSION['login_errors']); ?>
            <?php unset($_SESSION['login_email']); ?>
        <?php endif; ?>
        
        // Display success message if any
        <?php if (isset($_SESSION['success_message'])): ?>
            alert('<?php echo addslashes($_SESSION['success_message']); ?>');
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
    </script>
    window.onload = function() {
        const params = new URLSearchParams(window.location.search);
        if (params.get('error') === 'notregistered') {
            showPopup('This email is not registered.');
        }
        if (params.get('error') === 'wrongpassword') {
            showPopup('Incorrect password.');
        }
        if (params.get('error') === 'notverified') {
            showPopup('Your email is not verified. Please check your inbox.');
        }
        function showPopup(message) {
            const popup = document.createElement('div');
            popup.style.position = 'fixed';
            popup.style.top = '30px';
            popup.style.left = '50%';
            popup.style.transform = 'translateX(-50%)';
            popup.style.background = '#fff';
            popup.style.color = '#d32f2f';
            popup.style.border = '1.5px solid #d32f2f';
            popup.style.padding = '18px 32px';
            popup.style.borderRadius = '10px';
            popup.style.boxShadow = '0 2px 10px #0002';
            popup.style.zIndex = 9999;
            popup.innerHTML = '<b>' + message + '</b> <span style="margin-left:20px;cursor:pointer;font-weight:bold;" id="closePopup">&times;</span>';
            document.body.appendChild(popup);
            document.getElementById('closePopup').onclick = function() {
                popup.remove();
                window.history.replaceState({}, document.title, window.location.pathname);
            };
        }
    };
    </script>
   
</body>
</html>