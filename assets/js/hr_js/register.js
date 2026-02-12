function getVerification() {
    document.getElementById("verification-section").style.display = 'flex';
}
$(document).ready(function() {
    let canResend = false;
    let countdownInterval;

    // Password match validation
    $('#cpassword').on('blur', function() {
        const password = $('#password').val();
        const cpassword = $(this).val();

        if (password !== cpassword && cpassword !== '') {
            $(this).addClass('is-invalid');
            $('#password-feedback').html('<span style="color: red;">Passwords do not match!</span>');
        } else {
            $(this).removeClass('is-invalid');
            $('#password-feedback').html('');
        }
    });

    // Clear form when page loads
    $(window).on('load', function() {
        sessionStorage.removeItem('pending_registration');
        $('#register-form')[0].reset();
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('cpassword');
    const passwordFeedback = document.getElementById('password-feedback');

    // Create show password toggle for password field
    const passwordToggle = document.createElement('button');
    passwordToggle.type = 'button';
    passwordToggle.innerHTML = '<i class="fa-solid fa-eye"></i>';
    passwordToggle.style.position = 'absolute';
    passwordToggle.style.right = '10px';
    passwordToggle.style.top = '50%';
    passwordToggle.style.transform = 'translateY(5px)';
    passwordToggle.style.background = 'none';
    passwordToggle.style.border = 'none';
    passwordToggle.style.cursor = 'pointer';
    passwordToggle.style.fontSize = '15px';

    // Create show password toggle for confirm password field
    const confirmPasswordToggle = document.createElement('button');
    confirmPasswordToggle.type = 'button';
    confirmPasswordToggle.innerHTML = '<i class="fa-solid fa-eye"></i>';
    confirmPasswordToggle.style.position = 'absolute';
    confirmPasswordToggle.style.right = '10px';
    confirmPasswordToggle.style.top = '50%';
    confirmPasswordToggle.style.transform = 'translateY(5px)';
    confirmPasswordToggle.style.background = 'none';
    confirmPasswordToggle.style.border = 'none';
    confirmPasswordToggle.style.cursor = 'pointer';
    confirmPasswordToggle.style.fontSize = '15px';

    // Add toggle buttons to password fields
    passwordInput.parentNode.style.position = 'relative';
    passwordInput.parentNode.appendChild(passwordToggle);

    confirmPasswordInput.parentNode.style.position = 'relative';
    confirmPasswordInput.parentNode.appendChild(confirmPasswordToggle);

    // Toggle password visibility
    passwordToggle.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        passwordToggle.innerHTML = type === 'password' ? '<i class="fa-solid fa-eye"></i>' : '<i class="fa-solid fa-eye-slash"></i>';
    });

    confirmPasswordToggle.addEventListener('click', function() {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        confirmPasswordToggle.innerHTML = type === 'password' ? '<i class="fa-solid fa-eye"></i>' : '<i class="fa-solid fa-eye-slash"></i>';
    });

    // Password validation
    function validatePassword() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        const hasMinLength = password.length >= 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
        const passwordsMatch = password === confirmPassword;

        let messages = [];

        // Password requirements
        if (!hasMinLength) messages.push('at least 8 characters');
        if (!hasUppercase) messages.push('one capital letter');
        if (!hasSpecialChar) messages.push('one special character');

        // Confirm password check
        if (confirmPassword && !passwordsMatch) {
            messages.push('passwords do not match');
        }

        // Update styling and feedback
        if (messages.length > 0) {
            passwordInput.style.borderColor = '#dc3545';
            confirmPasswordInput.style.borderColor = '#dc3545';
            passwordFeedback.style.color = '#dc3545';
            passwordFeedback.style.position = 'absolute';
            passwordFeedback.textContent = `Password must contain: ${messages.join(', ')}`;
        } else if (password.length > 0) {
            passwordInput.style.borderColor = '#28a745';
            confirmPasswordInput.style.borderColor = '#28a745';
            passwordFeedback.style.color = '#28a745';
            passwordFeedback.style.position = 'absolute';
            passwordFeedback.textContent = 'Password meets all requirements';
        } else {
            passwordInput.style.borderColor = '';
            confirmPasswordInput.style.borderColor = '';
            passwordFeedback.textContent = '';
        }

        return messages.length === 0;
    }

    // Real-time validation
    passwordInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validatePassword);

    // Form submission validation
    const form = passwordInput.closest('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validatePassword()) {
                e.preventDefault();
            }
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const departmentSelect = document.getElementById('Department_id');
    const jobTitleSelect = document.getElementById('jobTitleSelect');

    if (departmentSelect && jobTitleSelect) {
        // Store all job title options for filtering
        const allJobTitleOptions = Array.from(jobTitleSelect.querySelectorAll('option'));

        departmentSelect.addEventListener('change', function() {
            const selectedDeptId = this.value;

            // Reset job title select
            jobTitleSelect.innerHTML = '<option value="">Select Job Title</option>';

            if (selectedDeptId === '') {
                // Show all job titles when no department is selected
                allJobTitleOptions.forEach(option => {
                    if (option.value !== '') {
                        jobTitleSelect.appendChild(option.cloneNode(true));
                    }
                });
            } else {
                // Filter job titles by selected department
                allJobTitleOptions.forEach(option => {
                    const deptId = option.getAttribute('data-department-id');
                    if (deptId === selectedDeptId) {
                        jobTitleSelect.appendChild(option.cloneNode(true));
                    }
                });

                // If no job titles for this department
                if (jobTitleSelect.options.length === 1) {
                    const noOption = document.createElement('option');
                    noOption.value = '';
                    noOption.textContent = 'No job titles available for this department';
                    jobTitleSelect.appendChild(noOption);
                }
            }
        });
    }
});