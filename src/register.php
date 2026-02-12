<?php include '../header.php'; ?>
<link rel="stylesheet" href="../assets/css/register.css">
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
                            <?php
                                // Get all departments
                                $stmt_departments = $pdo->prepare("SELECT * FROM departments ORDER BY Department_name ASC");
                                $stmt_departments->execute();
                                $departments = $stmt_departments->fetchAll(PDO::FETCH_ASSOC);

                                $stmt_jobtitles = $pdo->prepare("SELECT J.*, D.Department_name 
                                    FROM jobTitles J
                                    LEFT JOIN departments D ON J.department_id = D.Department_id
                                    ORDER BY J.jobTitle ASC");
                                $stmt_jobtitles->execute();
                                $all_jobtitles = $stmt_jobtitles->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                            <div class="col-md-4">
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

                            <div class="col-md-4">
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
                            <div class="col-md-4">
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
<script src="../assets/js/hr_js/register.js"></script>
<?php include '../footer.php'; ?>