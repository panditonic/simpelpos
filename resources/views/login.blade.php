<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Login Form</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 2rem;
        }
        
        .login-header h2 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px 0 0 10px;
            border-right: none;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .forgot-password:hover {
            color: #764ba2;
        }
        
        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #6c757d;
        }
        
        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .signup-link a:hover {
            color: #764ba2;
        }
        
        .dashboard-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            text-align: center;
        }
        
        .dashboard-header h2 {
            color: #333;
            margin-bottom: 1rem;
        }
        
        .btn-logout {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <!-- Login Form -->
                <div class="login-container" id="loginContainer">
                    <div class="card login-card">
                        <div class="login-header">
                            <h2><i class="fas fa-sign-in-alt me-2"></i>Welcome Back</h2>
                            <p>Please sign in to your account</p>
                        </div>
                        
                        <div class="card-body p-4">
                            <form id="loginForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="Enter your email" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" id="password" name="password" 
                                               placeholder="Enter your password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="#" class="forgot-password">Forgot Password?</a>
                                </div>
                                
                                <button type="submit" class="btn btn-login w-100 text-white" id="loginBtn">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" id="loginSpinner"></span>
                                    <span class="btn-text">Sign In</span>
                                </button>
                                
                                <div class="signup-link">
                                    Don't have an account? <a href="#">Sign up here</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Dashboard -->
                <div class="dashboard-container" id="dashboardContainer" style="display: none;">
                    <div class="dashboard-header">
                        <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h2>
                        <p class="mb-4">Welcome, <span id="userName" class="fw-bold text-primary"></span>!</p>
                    </div>
                    <div class="dashboard-content">
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            This is your personal dashboard. You can view your account details and manage your settings here.
                        </div>
                        <button class="btn btn-logout" id="logoutBtn">
                            <i class="fas fa-sign-out-alt me-2"></i>Sign Out
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('#togglePassword').click(function() {
                const passwordField = $('#password');
                const icon = $(this).find('i');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
            
            // Handle form submission
            $('#loginForm').submit(function(e) {
                e.preventDefault();
                
                const loginBtn = $('#loginBtn');
                const loginSpinner = $('#loginSpinner');
                const formData = new FormData(this);
                
                // Show loading state
                loginBtn.prop('disabled', true);
                loginSpinner.removeClass('d-none');
                
                $.ajax({
                    url: '/login', // Sesuaikan dengan route Laravel Anda
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Hide loading state
                        loginBtn.prop('disabled', false);
                        loginSpinner.addClass('d-none');
                        
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful!',
                            text: response.message || 'Welcome back!',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            // Show dashboard or redirect
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            } else {
                                $('#loginContainer').hide();
                                $('#dashboardContainer').show();
                                $('#userName').text(response.user.name || response.user.email);
                            }
                        });
                    },
                    error: function(xhr) {
                        // Hide loading state
                        loginBtn.prop('disabled', false);
                        loginSpinner.addClass('d-none');
                        
                        let errorMessage = 'An error occurred during login.';
                        let errors = {};
                        
                        if (xhr.responseJSON) {
                            errorMessage = xhr.responseJSON.message || errorMessage;
                            errors = xhr.responseJSON.errors || {};
                        }
                        
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: errorMessage,
                            confirmButtonText: 'Try Again',
                            confirmButtonColor: '#dc3545'
                        });
                        
                        // Clear form errors
                        $('.form-control').removeClass('is-invalid');
                        $('.invalid-feedback').remove();
                        
                        // Show field-specific errors
                        if (Object.keys(errors).length > 0) {
                            Object.keys(errors).forEach(function(field) {
                                const fieldElement = $(`#${field}`);
                                fieldElement.addClass('is-invalid');
                                fieldElement.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                            });
                        }
                    }
                });
            });
            
            // Handle logout
            $('#logoutBtn').click(function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will be logged out of your account.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, logout!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/logout', // Sesuaikan dengan route Laravel Anda
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Logged Out',
                                    text: 'You have been successfully logged out.',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    $('#dashboardContainer').hide();
                                    $('#loginContainer').show();
                                    $('#loginForm')[0].reset();
                                    $('.form-control').removeClass('is-invalid');
                                    $('.invalid-feedback').remove();
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An error occurred during logout.',
                                    confirmButtonColor: '#dc3545'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>