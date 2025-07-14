// Form validation rules
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
const loginContainer = document.getElementById('loginContainer');
const dashboardContainer = document.getElementById('dashboardContainer');
const userNameElement = document.getElementById('userName');
const logoutBtn = document.getElementById('logoutBtn');

// Get CSRF token from meta tag
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Session management
function checkSession() {
    fetch('/check-auth', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.authenticated) {
            window.location.href = "/dasbor";
            // showDashboard(data.user);
        }
    })
    .catch(error => {
        console.error('Error checking session:', error);
    });
}

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

// Notification system
function showNotification(message, type = 'success') {
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <span>${message}</span>
        <button class="close-btn" onclick="this.parentElement.remove()">×</button>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 100);

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

function showDashboard(user) {
    loginContainer.style.display = 'none';
    dashboardContainer.style.display = 'block';
    userNameElement.textContent = user.name;
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

// Form submission
form.addEventListener('submit', function(e) {
    e.preventDefault();

    const emailErrors = validateField('email', emailInput.value);
    const passwordErrors = validateField('password', passwordInput.value);

    showFieldError('email', emailErrors);
    showFieldError('password', passwordErrors);

    if (emailErrors.length === 0 && passwordErrors.length === 0) {
        loginBtn.classList.add('loading');
        loginBtn.querySelector('.btn-text').textContent = 'Signing In...';

        const formData = new FormData(form);
        
        fetch('/login', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            loginBtn.classList.remove('loading');
            loginBtn.querySelector('.btn-text').textContent = 'Sign In';

            if (data.success) {
                showNotification(data.message, 'success');
                // showDashboard(data.user);
                window.location.href = "/dasbor";
            } else {
                showNotification(data.message, 'error');
                
                // Show server validation errors
                if (data.errors) {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        showFieldError(field, messages);
                    }
                }
            }
        })
        .catch(error => {
            loginBtn.classList.remove('loading');
            loginBtn.querySelector('.btn-text').textContent = 'Sign In';
            console.error('Login error:', error);
            showNotification('An error occurred. Please try again.', 'error');
        });
    } else {
        showNotification('Please fix the errors below.', 'error');
    }
});

// Logout functionality
logoutBtn.addEventListener('click', function() {
    fetch('/logout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            dashboardContainer.style.display = 'none';
            loginContainer.style.display = 'block';
            form.reset();
            showNotification(data.message, 'success');
        }
    })
    .catch(error => {
        console.error('Logout error:', error);
        showNotification('An error occurred during logout.', 'error');
    });
});

// Check for existing session on page load
document.addEventListener('DOMContentLoaded', function() {
    checkSession();
});

// Forgot password functionality
document.querySelector('.forgot-password').addEventListener('click', function(e) {
    e.preventDefault();
    
    const email = emailInput.value;
    if (!email) {
        showNotification('Please enter your email address first.', 'error');
        return;
    }

    fetch('/forgot-password', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Forgot password error:', error);
        showNotification('An error occurred. Please try again.', 'error');
    });
});

// Signup link functionality
document.querySelector('.signup-link a').addEventListener('click', function(e) {
    e.preventDefault();
    showNotification('Redirecting to signup page...', 'success');
    // In a real application, you would redirect to the signup page
    // window.location.href = '/register';
});