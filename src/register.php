<?php include '../header.php'; ?>
<style>
@media(max-width:768px) {
    .container {
        margin: 0 !important;
    }

    .card-header {
        width: 90vw;
    }

    .card-body {
        display: flex !important;
        justify-content: start !important;
        align-items: start !important;
        height: 75vh !important;
        padding: .3rem !important;
    }

    .card-body::-webkit-scrollbar {
        display: none !important;
    }

    .fontRegister {
        font-size: 2rem !important;
    }
}

.verification-section {
    display: none;
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    margin-top: 20px;
    border-left: 4px solid #007bff;
}

.password-feedback {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
</style>
<main id="main" class="login-page">
    <div class="container row justify-content-center align-items-center ">
        <div class="row justify-content-center align-items-center col-md-12 col-12">
            <div class="col-md-9 col-12 p-0 m-0">
                <div class="card-header shadow">
                    <div class="card-header bg-gradient-primary text-white shadow  text-center">
                        <h4 class="mb-0 fontRegister fw-light">Sign-up to Z.C Puericulture Center</h4>
                    </div>
                    <div class="card-body scroll">
                        <!-- Registration Form -->
                        <form class="row g-1 align-items-start justify-content-start" id="register-form" method="post">
                            <!-- Name -->
                            <div class="col-md-3">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input required type="text" class="form-control" name="lastName" id="lastName">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input required type="text" class="form-control" name="firstName" id="firstName">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Middle Name</label>
                                <input type="text" class="form-control" name="middleName" id="middleName">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Suffix</label>
                                <select class="form-select" name="suffix" id="suffix">
                                    <option value="" disabled selected>Select suffix (optional) </option>
                                    <option value="Jr">Jr</option>
                                    <option value="Sr">Sr</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                </select>
                            </div>
                            <!-- Reference ID -->
                            <div class="col-md-3">
                                <label class="form-label">Employee ID <span class="text-danger">*</span></label>
                                <?php 
                                    $randogs = str_pad(random_int(0, 999999), 9, '0', STR_PAD_LEFT);
                                ?>
                                <input required readonly type="number" value="<?= htmlspecialchars($randogs) ?>"
                                    class="form-control" name="employeeID" id="employeeID">
                            </div>
                            <?php
                                // Get all departments
                                $stmt_departments = $pdo->prepare("SELECT * FROM departments ORDER BY Department_name ASC");
                                $stmt_departments->execute();
                                $departments = $stmt_departments->fetchAll(PDO::FETCH_ASSOC);

                                // Get all job titles initially (or only when a department is selected via AJAX)
                                // If you want to show ALL job titles initially:
                                $stmt_jobtitles = $pdo->prepare("SELECT J.*, D.Department_name 
                                    FROM jobTitles J
                                    LEFT JOIN departments D ON J.department_id = D.Department_id
                                    ORDER BY J.jobTitle ASC");
                                $stmt_jobtitles->execute();
                                $all_jobtitles = $stmt_jobtitles->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                            <div class="col-md-3">
                                <label for="Department_id" class="form-label">Department</label>
                                <select class="form-select" id="Department_id" name="Department_id">
                                    <option value="">Select Department</option>
                                    <?php foreach($departments as $dep) : ?>
                                    <option value="<?= htmlspecialchars($dep["Department_id"]) ?>">
                                        <?= htmlspecialchars($dep["Department_name"]) . " (" . htmlspecialchars($dep["Department_code"]) . ")" ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="jobTitleSelect" class="form-label">Job Title</label>
                                <select class="form-select" id="jobTitleSelect" name="jobTitle_id">
                                    <option value="">Select Job Title</option>
                                    <!-- Show all job titles initially -->
                                    <?php foreach($all_jobtitles as $jb) : ?>
                                    <option value="<?= htmlspecialchars($jb["jobTitles_id"]) ?>"
                                        data-department-id="<?= htmlspecialchars($jb["department_id"] ?? '') ?>">
                                        <?= htmlspecialchars($jb["jobTitle"]) . " (₱" . number_format($jb["salary"], 2) . ")" ?>
                                        <?php if(!empty($jb["Department_name"])): ?>
                                        - <?= htmlspecialchars($jb["Department_name"]) ?>
                                        <?php endif; ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sex <span class="text-danger">*</span></label>
                                <select required class="form-select" name="gender" id="gender">
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <!-- Contact Information -->
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input required type="email" class="form-control" name="email" id="email">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact Number</label>
                                <input type="number" class="form-control" name="contact" id="contact">
                            </div>

                            <!-- Account Info -->
                            <div class="col-md-4">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input required type="text" class="form-control" name="username" id="username">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input required type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input required type="password" class="form-control" name="cpassword" id="cpassword">
                                <div id="password-feedback" class="password-feedback"></div>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button type="submit" onclick="getVerification()" class="btn btn-primary px-5"
                                    id="submit-btn">
                                    <i class="bi bi-person-plus-fill me-1"></i> Create Account
                                </button>
                                <div class="mt-2">
                                    <span>Already have an account? </span><a href="index.php"
                                        class="text-decoration-none">Sign In</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
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
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('cpassword');
    const passwordFeedback = document.getElementById('password-feedback');

    // Create show password toggle for password field
    const passwordToggle = document.createElement('button');
    passwordToggle.type = 'button';
    passwordToggle.innerHTML = 'Show';
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
    confirmPasswordToggle.innerHTML = 'Show';
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
        passwordToggle.innerHTML = type === 'password' ? 'Show' : 'Hide';
    });

    confirmPasswordToggle.addEventListener('click', function() {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        confirmPasswordToggle.innerHTML = type === 'password' ? 'Show' : 'Hide';
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
</script>
<script>
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
</script>
<?php include '../footer.php'; ?>