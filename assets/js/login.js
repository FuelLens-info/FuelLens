// Login page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Login type switching
    const loginTypeBtns = document.querySelectorAll('.login-type-btn');
    const loginForms = document.querySelectorAll('.auth-form');

    loginTypeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            
            // Update active button
            loginTypeBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Show corresponding form
            loginForms.forEach(form => {
                form.classList.remove('active');
                if (form.id === `${type}-login-form`) {
                    form.classList.add('active');
                }
            });
        });
    });

    // Password toggle functionality
    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Form submission
    const stationForm = document.getElementById('station-login-form');
    const erpForm = document.getElementById('erp-login-form');

    // Removed JS form submission handlers to allow normal PHP processing
    // if (stationForm) {
    //     stationForm.addEventListener('submit', function(e) {
    //         e.preventDefault();
    //         handleLogin(this, 'station');
    //     });
    // }

    // if (erpForm) {
    //     erpForm.addEventListener('submit', function(e) {
    //         e.preventDefault();
    //         handleLogin(this, 'erp');
    //     });
    // }

    // Demo credential auto-fill
    const demoCredentials = document.querySelector('.demo-credentials');
    if (demoCredentials) {
        demoCredentials.addEventListener('click', function(e) {
            if (e.target.textContent.includes('demo@fuellens.com')) {
                // Fill station owner credentials
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');
                if (emailInput && passwordInput) {
                    emailInput.value = 'demo@fuellens.com';
                    passwordInput.value = 'password123';
                }
            } else if (e.target.textContent.includes('EMP001')) {
                // Fill employee credentials
                const employeeIdInput = document.getElementById('employee_id');
                const passwordInput = document.getElementById('erp_password');
                const roleSelect = document.getElementById('role');
                if (employeeIdInput && passwordInput && roleSelect) {
                    employeeIdInput.value = 'EMP001';
                    passwordInput.value = 'admin123';
                    roleSelect.value = 'employee';
                }
            } else if (e.target.textContent.includes('ADM001')) {
                // Fill admin credentials
                const employeeIdInput = document.getElementById('employee_id');
                const passwordInput = document.getElementById('erp_password');
                const roleSelect = document.getElementById('role');
                if (employeeIdInput && passwordInput && roleSelect) {
                    employeeIdInput.value = 'ADM001';
                    passwordInput.value = 'admin123';
                    roleSelect.value = 'admin';
                }
            }
        });
    }

    // Form validation
    function validateForm(form) {
        const inputs = form.querySelectorAll('input[required], select[required]');
        let isValid = true;

        inputs.forEach(input => {
            const formGroup = input.closest('.form-group');
            const existingError = formGroup.querySelector('.error-message');
            
            if (existingError) {
                existingError.remove();
            }
            
            formGroup.classList.remove('error');

            if (!input.value.trim()) {
                showFieldError(input, 'This field is required');
                isValid = false;
            } else if (input.type === 'email' && !isValidEmail(input.value)) {
                showFieldError(input, 'Please enter a valid email address');
                isValid = false;
            }
        });

        return isValid;
    }

    function showFieldError(input, message) {
        const formGroup = input.closest('.form-group');
        formGroup.classList.add('error');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
        formGroup.appendChild(errorDiv);
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});