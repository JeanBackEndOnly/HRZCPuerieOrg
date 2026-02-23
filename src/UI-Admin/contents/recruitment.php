<?php
   // Fetch Active Employees
$stmtOfficial = $pdo->prepare("
    SELECT 
        ed.employee_id, 
        ed.firstname, 
        ed.middlename, 
        ed.lastname, 
        ed.suffix,
        ed.profile_picture,
        d.Department_name AS department,
        hd.employeeID,
        jt.jobTitle,
        jt.salary,
        ed.status,
        ed.user_role
    FROM employee_data ed
    INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
    LEFT JOIN jobTitles jt ON hd.jobtitle_id = jt.jobTitles_id
    LEFT JOIN departments d ON hd.Department_id = d.Department_id
    WHERE ed.status = 'Active' AND ed.user_role = 'EMPLOYEE'
    ORDER BY ed.status
");
$stmtOfficial->execute();
$officialEmployees = $stmtOfficial->fetchAll(PDO::FETCH_ASSOC);

// Fetch Pending Employees
$stmtPending = $pdo->prepare("
    SELECT 
        ed.employee_id, 
        ed.firstname, 
        ed.middlename, 
        ed.lastname, 
        ed.suffix,
        ed.profile_picture,
        d.Department_name AS department,
        hd.employeeID,
        jt.jobTitle,
        jt.salary,
        ed.status
    FROM employee_data ed
    INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
    LEFT JOIN jobTitles jt ON hd.jobtitle_id = jt.jobTitles_id
    LEFT JOIN departments d ON hd.Department_id = d.Department_id
    WHERE ed.status = 'Pending' AND ed.user_role = 'EMPLOYEE'
    ORDER BY ed.lastname, ed.firstname
");
$stmtPending->execute();
$pendingEmployees = $stmtPending->fetchAll(PDO::FETCH_ASSOC);

// Fetch Inactive Employees
$stmtInactive = $pdo->prepare("
    SELECT 
        ed.employee_id, 
        ed.firstname, 
        ed.middlename, 
        ed.lastname, 
        ed.suffix,
        ed.profile_picture,
        d.Department_name AS department,
        hd.employeeID,
        jt.jobTitle,
        jt.salary,
        ed.status,
        ed.user_role
    FROM employee_data ed
    INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
    LEFT JOIN jobTitles jt ON hd.jobtitle_id = jt.jobTitles_id
    LEFT JOIN departments d ON hd.Department_id = d.Department_id
    WHERE ed.status = 'Inactive' AND ed.user_role = 'EMPLOYEE'
    ORDER BY ed.lastname, ed.firstname
");
$stmtInactive->execute();
$inactiveEmployees = $stmtInactive->fetchAll(PDO::FETCH_ASSOC);


    $countOfficials = 1;
?>
<section>
    <div class="d-flex justify-content-between align-items-center mb-2 col-md-12 col-12 flex-wrap">
        <div class=" col-md-6 col-12">
            <h4 class=""><i class="fa-solid fa-users me-2"></i>Employees Management</h4>
            <small class="text-muted ">Create, Update And view employee Accounts</small>
        </div>
        <div class="col-md-6 col-12 d-flex justify-content-end">
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createAccounts"
                id="add_new">
                <i class="fa fa-plus"></i> Create Employee Account
            </button>
        </div>
    </div>

    <?php
           
            $pending = $pdo->query("SELECT COUNT(*) FROM employee_data WHERE status = 'Pending' AND user_role = 'EMPLOYEE'")->fetchColumn();
           
        ?>

    <!-- EMPLOYEE ACCOUNT DISPLAYS =============================================================================================== -->
    <div class="card">
        <!-- NAVIAGATIONS OF TABS -->
        <div class="card-body col-md-12 col-12 d-flex justify-content-between flex-wrap">
            <ul class="nav nav-tabs col-md-7 col-12" id="employeesTabs" role="tablist">
                <li class="nav-item col-md-4" role="presentation">
                    <button class="nav-link w-100 h-100 active" id="approved-tab" data-bs-toggle="tab"
                        data-bs-target="#Approved_Employees" type="button" role="tab" aria-controls="Approved_Employees"
                        aria-selected="true">
                        <i class="fa-solid fa-user-tie me-2"></i>Official Employees
                    </button>
                </li>
                <li class="nav-item col-md-4" role="presentation">
                    <div style="background-color: #E32126 !important;
                        z-index: 3 !important;
                        position: absolute !important;
                        transform: translateX(11.8rem) !important;
                        border-radius: 50% !important;
                        ">
                        <strong class="text-white" style="
                            padding-top: -1rem !important;
                            padding-bottom: -1rem !important;
                            padding-right: .4rem !important;
                            padding-left: .4rem !important;
                            margin: 0 !important;
                            font-size: 9px !mportant;
                            "><?php echo $pending ?></strong>
                    </div>
                    <button class="nav-link w-100 h-100" id="pending-tab" data-bs-toggle="tab"
                        data-bs-target="#Pending_Accounts" type="button" role="tab" aria-controls="Pending_Accounts"
                        aria-selected="false">
                        <i class="fa-solid fa-user-plus me-2"></i>Accounts Pending
                    </button>
                </li>
                <li class="nav-item col-md-4" role="presentation">
                    <button class="nav-link w-100 h-100" id="rejected-tab" data-bs-toggle="tab"
                        data-bs-target="#Rejected_Accounts" type="button" role="tab" aria-controls="Rejected_Accounts"
                        aria-selected="false">
                        <i class="fa-solid fa-user-minus me-2"></i>Accounts Inactive
                    </button>
                </li>
            </ul>
            <div class="col-md-4 col-12 mt-2 mt-md-0">
                <input type="text" id="searchEmployees" placeholder="search by... Employee name, ID and Job Title"
                    class="form-control">
            </div>
        </div>

        <!-- CONTENTS -->
        <div class="card-body pt-0">
            <div class="tab-content" id="employeesTabContent">
                <!-- Approved Employees -->
                <div class="tab-pane fade show active row" id="Approved_Employees" role="tabpanel"
                    aria-labelledby="approved-tab" tabindex="0">
                    <?php 
                        if($officialEmployees){
                            foreach ($officialEmployees as $officials) : ?>
                    <a href="index.php?page=contents/profile&id=<?= htmlspecialchars($officials["employee_id"]) ?>"
                        class="col-md-4">
                        <div class="card col-md-12 d-flex flex-row shadow p-2 rounded-3 border">
                            <div class="col-md-2 d-flex align-items-center">
                                <?php if($officials["profile_picture"] == null){ ?>
                                <strong class="py-2 px-2 text-white"
                                    style="
                                                    border-radius: 50%;
                                                    font-weight: 500 !important;
                                                    background-color: rgba(255, 14, 14, 0.70);
                                                    font-size: 15px;
                                                    border: solid 1px #fff;
                                                "><?= htmlspecialchars(strtoupper(substr($officials["firstname"], 0,1) . substr($officials["lastname"], 0,1))) ?></strong>
                                <?php }else{ ?>
                                <img src="../../authentication/uploads/<?= $officials["profile_picture"] ?>"
                                    style="width: 200px; height: auto; border-radius: 50%;">
                                <?php } ?>
                            </div>

                            <div class="col-md-10 d-flex flex-column">
                                <strong
                                    class="font-13"><?= htmlspecialchars($officials["firstname"] . ' ' . substr($officials["middlename"], 0, 1) . '. ' . $officials["lastname"]) ?></strong>
                                <span
                                    class="font-12"><?= htmlspecialchars($officials["jobTitle"] . ' •' . $officials["department"]) . ' •EMP-' . $officials["employeeID"] ?></span>
                            </div>
                        </div>
                    </a>
                    <?php endforeach;
                        }else{ ?>
                    <strong class="text-center w-100">NO EMPLOYEE FOUND</strong>
                    <?php } ?>
                </div>

                <!-- Pending Accounts -->
                <div class="tab-pane fade" id="Pending_Accounts" role="tabpanel" aria-labelledby="pending-tab"
                    tabindex="0">

                    <?php 
                            if($pendingEmployees){
                                foreach ($pendingEmployees as $pendings) : ?>
                    <a href="index.php?page=contents/profile&id=<?= htmlspecialchars($pendings["employee_id"]) ?>"
                        class="col-md-4">
                        <div class="card col-md-12 d-flex flex-row shadow p-2 rounded-3 border">
                            <div class="col-md-2 d-flex align-items-center">
                                <?php if($pendings["profile_picture"] == null){ ?>
                                <strong class="py-2 px-2 text-white"
                                    style="
                                                    border-radius: 50%;
                                                    font-weight: 500 !important;
                                                    background-color: rgba(255, 14, 14, 0.70);
                                                    font-size: 15px;
                                                    border: solid 1px #fff;
                                                "><?= htmlspecialchars(strtoupper(substr($pendings["firstname"], 0,1) . substr($pendings["lastname"], 0,1))) ?></strong>
                                <?php }else{ ?>
                                <img src="../../authentication/uploads/<?= $pendings["profile_picture"] ?>"
                                    style="width: 200px; height: auto; border-radius: 50%;">
                                <?php } ?>
                            </div>
                            <div class="col-md-10 d-flex flex-column">
                                <strong
                                    class="font-13"><?= htmlspecialchars($pendings["firstname"] . ' ' . substr($pendings["middlename"], 0, 1) . '. ' . $pendings["lastname"]) ?></strong>
                                <span
                                    class="font-12"><?= htmlspecialchars($pendings["jobTitle"] . ' •' . $pendings["department"]) . ' •EMP-' . $pendings["employeeID"] ?></span>
                            </div>
                        </div>
                    </a>
                    <?php endforeach;
                            }else{ ?>
                    <strong class="text-center w-100">NO EMPLOYEE FOUND</strong>
                    <?php } ?>
                </div>

                <!-- Rejected Accounts -->
                <div class="tab-pane fade" id="Rejected_Accounts" role="tabpanel" aria-labelledby="rejected-tab"
                    tabindex="0">

                    <?php 
                            if($inactiveEmployees){
                                foreach ($inactiveEmployees as $inactive) : ?>
                    <a href="index.php?page=contents/profile&id=<?= htmlspecialchars($inactive["employee_id"]) ?>"
                        class="col-md-4">
                        <div class="card col-md-12 d-flex flex-row shadow p-2 rounded-3 border">
                            <div class="col-md-2 d-flex align-items-center">
                                <?php if($inactive["profile_picture"] == null){ ?>
                                <strong class="py-2 px-2 text-white"
                                    style="
                                                    border-radius: 50%;
                                                    font-weight: 500 !important;
                                                    background-color: rgba(255, 14, 14, 0.70);
                                                    font-size: 15px;
                                                    border: solid 1px #fff;
                                                "><?= htmlspecialchars(strtoupper(substr($inactive["firstname"], 0,1) . substr($inactive["lastname"], 0,1))) ?></strong>
                                <?php }else{ ?>
                                <img src="../../authentication/uploads/<?= $inactive["profile_picture"] ?>"
                                    style="width: 200px; height: auto; border-radius: 50%;">
                                <?php } ?>
                            </div>
                            <div class="col-md-10 d-flex flex-column">
                                <strong
                                    class="font-13"><?= htmlspecialchars($inactive["firstname"] . ' ' . substr($inactive["middlename"], 0, 1) . '. ' . $inactive["lastname"]) ?></strong>
                                <span
                                    class="font-12"><?= htmlspecialchars($inactive["jobTitle"] . ' •' . $inactive["department"]) . ' •EMP-' . $inactive["employeeID"] ?></span>
                            </div>
                        </div>
                    </a>
                    <?php endforeach;
                            }else{ ?>
                    <strong class="text-center w-100">NO EMPLOYEE FOUND</strong>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ADD ACCOUNTS MODAL  ================================================ -->
<div class="modal fade" id="createAccounts" tabindex="-1" aria-labelledby="createAccountsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="createAccountsLabel">Create New Employee Account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    onclick="location.reload()"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="validation-form" method="post">
                    <!-- Name Section -->
                    <div class="col-md-3">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="lastName" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="firstName" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="middleName">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Suffix</label>
                        <select class="form-select" name="suffix">
                            <option value="" disabled selected>Select suffix (optional)</option>
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

                            // Get all job titles initially (or only when a department is selected via AJAX)
                            // If you want to show ALL job titles initially:
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
                        <select class="form-select" name="gender" required>
                            <option value="" disabled selected>Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-md-4">
                        <label class="form-label">Account Role <span class="text-danger">*</span></label>
                        <!-- <input type="text" readonly class="form-control" value="EMPLOYEE" name="user_role" required> -->
                        <select name="user_role" class="form-select" id="">
                            <option value="">Select Account Role</option>
                            <option value="EMPLOYEE">EMPLOYEE</option>
                            <option value="HRSM">HR</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="contact" required>
                    </div>

                    <!-- Account Credentials -->
                    <div class="col-md-4">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                        <div id="password-feedback" class="password-feedback"></div>
                    </div>

                    <!-- Form Submission -->
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-person-plus-fill me-1"></i> Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../../assets/js/hr_js/recruitment.js" defer></script>