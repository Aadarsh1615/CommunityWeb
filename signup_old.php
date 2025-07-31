<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Modern App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <style>
        .login-form h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #222;
        }
        .signup-subtitle {
            color: #6b7280;
            font-size: 1.18rem;
            margin-bottom: 22px;
        }
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
        .login-form button[type="submit"] {
            background: linear-gradient(90deg, #2563eb 0%, #1e4db7 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 16px 0;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            margin-bottom: 18px;
            transition: background 0.2s;
        }
        .login-form button[type="submit"]:hover {
            background: linear-gradient(90deg, #1e4db7 0%, #2563eb 100%);
        }
        .signup {
            text-align: center;
            margin-top: 18px;
            color: #888;
            font-size: 1.08rem;
        }
        .signup a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        .signup a:hover {
            text-decoration: underline;
        }
        .options {
            margin-bottom: 10px;
            font-size: 1rem;
        }
        .options label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #444;
        }
        .options a {
            color: #2563eb;
            text-decoration: underline;
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
            <form class="login-form" id="signupForm" method="POST" action="signup_process.php">
                <h2>Create your account</h2>
                <div class="signup-subtitle">Join Our Community.</div>
                <input type="text" placeholder="Name" required class="styled-input" name="name" id="name" value="<?php echo isset($_SESSION['signup_data']['name']) ? htmlspecialchars($_SESSION['signup_data']['name']) : ''; ?>">
                <input type="email" placeholder="Email" required class="styled-input" name="email" id="email" value="<?php echo isset($_SESSION['signup_data']['email']) ? htmlspecialchars($_SESSION['signup_data']['email']) : ''; ?>">
                <input type="password" placeholder="Password" required class="styled-input" name="password" id="password">
                <input type="password" placeholder="Confirm password" required class="styled-input" name="confirm_password" id="confirm_password">
                <div class="options">
                    <label>
                        <input type="checkbox" required> I agree to the <a href="#">Terms & Conditions</a>
                    </label>
                </div>
                <button type="submit">Create account</button>
                <div class="signup">
                    Have an account? <a href="login.php">Log in</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Display error messages if any
        <?php if (isset($_SESSION['signup_errors'])): ?>
            <?php foreach ($_SESSION['signup_errors'] as $error): ?>
                alert('<?php echo addslashes($error); ?>');
            <?php endforeach; ?>
            <?php unset($_SESSION['signup_errors']); ?>
            <?php unset($_SESSION['signup_data']); ?>
        <?php endif; ?>
        
        // Display success message if any
        <?php if (isset($_SESSION['success_message'])): ?>
            alert('<?php echo addslashes($_SESSION['success_message']); ?>');
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
    </script>
</body>
</html>