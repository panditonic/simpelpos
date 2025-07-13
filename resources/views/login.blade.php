<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Login Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            position: relative;
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .login-header h2 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .login-form {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input.error {
            border-color: #e74c3c;
            background: #fdf2f2;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        .remember-me input {
            margin-right: 8px;
        }

        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #5a67d8;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        .login-btn.loading .spinner {
            display: inline-block;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        /* Notification Styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 1000;
            transform: translateX(400px);
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            min-width: 300px;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        }

        .notification.error {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }

        .notification .close-btn {
            float: right;
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            margin-left: 10px;
            opacity: 0.8;
        }

        .notification .close-btn:hover {
            opacity: 1;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                margin: 0 10px;
            }
            
            .login-header {
                padding: 20px;
            }
            
            .login-form {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Welcome Back</h2>
            <p>Please sign in to your account</p>
        </div>
        
        <form class="login-form" id="loginForm">
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

    <script>
        // Form validation rules (Laravel-style)
        const validationRules = {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minLength: 6
            }
        };

        // Validation messages
        const validationMessages = {
            required: 'This field is required.',
            email: 'Please enter a valid email address.',
            minLength: 'This field must be at least {min} characters long.'
        };

        // Form elements
        const form = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const loginBtn = document.getElementById('loginBtn');

        // Validation functions
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function validateField(fieldName, value) {
            const rules = validationRules[fieldName];
            const errors = [];

            if (rules.required && !value.trim()) {
                errors.push(validationMessages.required);
            }

            if (rules.email && value && !validateEmail(value)) {
                errors.push(validationMessages.email);
            }

            if (rules.minLength && value && value.length < rules.minLength) {
                errors.push(validationMessages.minLength.replace('{min}', rules.minLength));
            }

            return errors;
        }

        function showFieldError(fieldName, errors) {
            const input = document.getElementById(fieldName);
            const errorElement = document.getElementById(fieldName + 'Error');

            if (errors.length > 0) {
                input.classList.add('error');
                errorElement.textContent = errors[0];
                errorElement.classList.add('show');
            } else {
                input.classList.remove('error');
                errorElement.classList.remove('show');
            }
        }

        function clearFieldError(fieldName) {
            const input = document.getElementById(fieldName);
            const errorElement = document.getElementById(fieldName + 'Error');
            
            input.classList.remove('error');
            errorElement.classList.remove('show');
        }

        // Real-time validation
        emailInput.addEventListener('input', function() {
            const errors = validateField('email', this.value);
            showFieldError('email', errors);
        });

        passwordInput.addEventListener('input', function() {
            const errors = validateField('password', this.value);
            showFieldError('password', errors);
        });

        // Notification system
        function showNotification(message, type = 'success') {
            // Remove existing notifications
            const existingNotification = document.querySelector('.notification');
            if (existingNotification) {
                existingNotification.remove();
            }

            // Create new notification
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <span>${message}</span>
                <button class="close-btn" onclick="this.parentElement.remove()">&times;</button>
            `;

            document.body.appendChild(notification);

            // Show notification
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);

            // Auto-hide after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                    }, 300);
                }
            }, 5000);
        }

        // Form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate all fields
            const emailErrors = validateField('email', emailInput.value);
            const passwordErrors = validateField('password', passwordInput.value);

            showFieldError('email', emailErrors);
            showFieldError('password', passwordErrors);

            // Check if form is valid
            if (emailErrors.length === 0 && passwordErrors.length === 0) {
                // Show loading state
                loginBtn.classList.add('loading');
                loginBtn.querySelector('.btn-text').textContent = 'Signing In...';

                // Simulate API call
                setTimeout(() => {
                    // Reset button state
                    loginBtn.classList.remove('loading');
                    loginBtn.querySelector('.btn-text').textContent = 'Sign In';

                    // Simulate login result (you can modify this logic)
                    const isSuccess = Math.random() > 0.3; // 70% success rate for demo

                    if (isSuccess) {
                        showNotification('Login successful! Welcome back.', 'success');
                        
                        // Redirect or perform success actions
                        setTimeout(() => {
                            // window.location.href = '/dashboard';
                            console.log('Redirecting to dashboard...');
                        }, 1500);
                    } else {
                        showNotification('Invalid credentials. Please try again.', 'error');
                    }
                }, 2000);
            } else {
                showNotification('Please fix the errors below.', 'error');
            }
        });

        // Demo buttons for testing notifications
        document.querySelector('.forgot-password').addEventListener('click', function(e) {
            e.preventDefault();
            showNotification('Password reset link sent to your email!', 'success');
        });

        document.querySelector('.signup-link a').addEventListener('click', function(e) {
            e.preventDefault();
            showNotification('Redirecting to signup page...', 'success');
        });
    </script>
</body>
</html>