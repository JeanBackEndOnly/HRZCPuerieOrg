
document.addEventListener('DOMContentLoaded', function() {
    employeePageTab();
});

function employeePageTab() {
    const tabButtons = document.querySelectorAll('#employeesTabs .nav-link');
    const tabContents = document.querySelectorAll('.tab-pane');

    // Initialize tabs - hide all except active
    tabContents.forEach(content => {
        if (!content.classList.contains('active')) {
            content.style.display = 'none';
        }
    });

    tabButtons.forEach((button) => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Update active button
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Hide all tab contents
            tabContents.forEach(content => {
                content.style.display = 'none';
                content.classList.remove('show', 'active');
            });

            // Show the selected tab
            const targetId = this.getAttribute('data-bs-target');
            const targetContent = document.querySelector(targetId);
            if (targetContent) {
                targetContent.style.display = 'block';
                targetContent.classList.add('show', 'active');

                // Load data for the active tab
                if (targetId === '#Pending_Accounts') {
                    // loadEmployeeData_hr_pending();
                } else if (targetId === '#Approved_Employees') {
                    // loadEmployeeData_hr();
                } else if (targetId === '#Rejected_Accounts') {
                    // loadEmployeeData_hr_rejected();
                }
            }
        });
    });
}


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


document.getElementById("searchEmployees").addEventListener("keyup", function() {
    let keyword = this.value.toLowerCase().trim();

    // IDs of the 3 tables
    let tableIDs = ["Accounts_rejected", "Accounts_pending", "Accounts_approved"];

    tableIDs.forEach(function(tableID) {
        let rows = document.querySelectorAll(`#${tableID} tr`);

        rows.forEach(row => {
            let rowText = row.innerText.toLowerCase();

            // Show row if it matches the search, hide if not
            if (rowText.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {

    const employeeIDInputs = document.querySelectorAll('input[id="employeeID"]');
    if (employeeIDInputs.length > 1) {
        employeeIDInputs.forEach((input, index) => {
            if (index > 0) {
                input.id = `employeeID-${index + 1}`;
            }
        });
    }
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
    passwordToggle.style.fontSize = '12px';

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
    confirmPasswordToggle.style.fontSize = '12px';

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