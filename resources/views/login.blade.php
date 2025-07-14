<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Login Form</title>
    
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container" id="loginContainer">
        <div class="login-header">
            <h2>Welcome Back</h2>
            <p>Please sign in to your account</p>
        </div>
        
        <form class="login-form" id="loginForm">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
                <div class="error-message" id="emailError"></div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <div class="error-message" id="passwordError"></div>
            </div>
            
            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>
            
            <button type="submit" class="login-btn" id="loginBtn">
                <span class="spinner"></span>
                <span class="btn-text">Sign In</span>
            </button>
            
            <div class="signup-link">
                Don't have an account? <a href="#">Sign up here</a>
            </div>
        </form>
    </div>

    <div class="dashboard-container" id="dashboardContainer" style="display: none;">
        <div class="dashboard-header">
            <h2>Dashboard</h2>
            <p>Welcome, <span id="userName"></span>!</p>
        </div>
        <div class="dashboard-content" style="padding: 20px;">
            <p>This is your personal dashboard. You can view your account details and manage your settings here.</p>
            <button class="logout-btn" id="logoutBtn">Sign Out</button>
        </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>