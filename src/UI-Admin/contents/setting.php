<?php
    $stmt = $pdo->prepare("SELECT a.*, ai.*, ass.*, d.Department_name, d.Department_code, d.Department_id, j.jobTitle, j.jobTitles_id  FROM admin a
        LEFT JOIN admin_info ai ON a.admin_id = ai.admin_id
        LEFT JOIN departments d ON ai.admin_department_id = d.Department_id
        LEFT JOIN jobTitles j ON ai.admin_position_id = j.jobTitles_id
        LEFT JOIN admin_schedule ass ON a.admin_id = ass.admin_id 
        WHERE a.admin_id = 1");
    $stmt->execute();
    $getAdminData = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<section>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="col-md-5">
            <h4 class="mb-0"><i class="fa fa-cog text-dark me-2"></i>Account Settings</h4>
            <small class="text-muted">Manage your account information and preferences</small>
        </div>
        <div class="col-md-7 d-flex justify-content-end">
            <button class="m-0 btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#changePassword">
                <i class="fa-solid fa-key me-2"></i>Change Password
            </button>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-0 col-md-12 col-12 flex-wrap">
        <div class="card-body col-md-8 col-12">
            <ul class="nav nav-tabs justify-content-start align-items-start col-md-12 col-12" id="AdminSettingsTabs">
                <li class="nav-item col-md-3 col-12">
                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#Personal">
                        <i class="fa-solid fa-circle-info me-2"></i> Personal Information
                    </a>
                </li>
                <li class="nav-item col-md-3 col-12">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Employement">
                        <i class="fa-solid fa-circle-info me-2"></i> Employement
                    </a>
                </li>
                <li class="nav-item col-md-3 col-12">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#hrEmployees">
                        <i class="fa-solid fa-circle-info me-2"></i> HRMS Activation
                    </a>
                </li>
                <li class="nav-item col-md-3 col-12">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#history">
                        <i class="fa-solid fa-clock me-2"></i>Login History
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-4">
            <div class="card rounded-2">
                <div class="d-flex flex-column w-100 align-items-center justify-content-center p-2">
                    <?php 
                    $adminPicture = $getAdminData["admin_picture"] ?? null;
                    if($adminPicture == null){ ?>
                    <strong class="py-1 px-5 text-white mb-2" style="
                                border-radius: 50%;
                                background-color: #303030ff;
                                font-size: 5rem;
                            "><?= htmlspecialchars(substr($getAdminData["admin_firstname"] ?? '', 0,1)) ?></strong>
                    <?php }else{ ?>
                    <img src="../../authentication/uploads/<?= $adminPicture ?>"
                        style="width: 200px; height: auto; border-radius: 50%;">
                    <?php } ?>

                    <span id="admin_employeeID"
                        class="text-muted fw-bold"><?= htmlspecialchars($getAdminData["admin_employeeID"] ?? '') ?></span>
                    <span
                        id="employeeName"><?= htmlspecialchars($getAdminData["admin_firstname"] ?? '') . " " .  substr(htmlspecialchars($getAdminData["admin_middlename"] ?? ''), 0, 1) . ". " . htmlspecialchars($getAdminData["admin_lastname"] ?? '') ?></span>
                    <span class="text-center"
                        id="employeeDept"><?= isset($getAdminData["Department_name"]) ? htmlspecialchars($getAdminData["Department_name"] . ' (' . $getAdminData["Department_code"] . ')') : '' ?></span>
                    <span id="employeeJobTitle"><?= htmlspecialchars($getAdminData["jobTitle"]) ?? '' ?></span>

                </div>
            </div>
        </div>

        <!-- PERSONAL INFORMATION TAB -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-8 height tab-pane fade show active" role="tabpanel"
            id="Personal">
            <form id="admin_profile_update" enctype="multipart/form-data">
                <div class="card rounded-2 profile-contents col-md-12 col-12"
                    style="padding-bottom: 5rem !important; overflow-y: scroll;">
                    <input type="hidden" name="employee_id" value="<?= $hr_id ?>">
                    <!-- PERSONAL INFORMATION HEADER -->
                    <div class="col-md-12 d-flex">
                        <div class="header ps-3 pt-3 col-md-5 col-8">
                            <h5 class="m-0 p-0 label-media-name">
                                <i class="fa-solid fa-circle-info me-2"></i>Personal Information
                            </h5>
                        </div>
                        <div
                            class="col-md-7 col-4 button-margin-right no-padding-media d-flex justify-content-end me-5">
                            <button type="submit"
                                class="btn btn-sm btn-danger px-5 mt-3 me-5 button-margin-right">Update</button>
                        </div>
                    </div>

                    <div class="col-md-10 ms-3">
                        <label class="form-label">Upload or update profile picture here:</label>
                        <input type="file" name="admin_picture" class="form-control">
                    </div>

                    <!-- PERSONAL INFORMATION CONTENTS -->
                    <div class="row flex-wrap col-md-12 col-12 p-3">
                        <div class="col-md-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="admin_firstname" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_firstname"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="admin_middlename" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_middlename"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="admin_lastname" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_lastname"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Suffix</label>
                            <select class="form-select" name="admin_suffix">
                                <option value="" <?= empty($getAdminData["admin_suffix"] ?? '') ? 'selected' : '' ?>>
                                    Select
                                    suffix (optional)</option>
                                <option value="Jr"
                                    <?= ($getAdminData["admin_suffix"] ?? '') == 'Jr' ? 'selected' : '' ?>>Jr
                                </option>
                                <option value="Sr"
                                    <?= ($getAdminData["admin_suffix"] ?? '') == 'Sr' ? 'selected' : '' ?>>Sr
                                </option>
                                <option value="II"
                                    <?= ($getAdminData["admin_suffix"] ?? '') == 'II' ? 'selected' : '' ?>>II
                                </option>
                                <option value="III"
                                    <?= ($getAdminData["admin_suffix"] ?? '') == 'III' ? 'selected' : '' ?>>III
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Citizenship</label>
                            <input type="text" name="admin_citizenship" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_citizenship"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gender</label>
                            <select name="admin_gender" id="admin_gender" class="form-select">
                                <option value="">Select Gender</option>
                                <option value="MALE"
                                    <?= ($getAdminData["admin_gender"] ?? '') == 'MALE' ? 'selected' : '' ?>>
                                    Male</option>
                                <option value="FEMALE"
                                    <?= ($getAdminData["admin_gender"] ?? '') == 'FEMALE' ? 'selected' : '' ?>>Female
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Civil Status</label>
                            <select name="admin_civil_status" id="admin_civil_status" class="form-select">
                                <option value="">Select Civil Status</option>
                                <option value="Single"
                                    <?= ($getAdminData["admin_civil_status"] ?? '') == 'Single' ? 'selected' : '' ?>>
                                    Single
                                </option>
                                <option value="Married"
                                    <?= ($getAdminData["admin_civil_status"] ?? '') == 'Married' ? 'selected' : '' ?>>
                                    Married
                                </option>
                                <option value="Widowed"
                                    <?= ($getAdminData["admin_civil_status"] ?? '') == 'Widowed' ? 'selected' : '' ?>>
                                    Widowed
                                </option>
                                <option value="Separated"
                                    <?= ($getAdminData["admin_civil_status"] ?? '') == 'Separated' ? 'selected' : '' ?>>
                                    Separated</option>
                                <option value="Divorced"
                                    <?= ($getAdminData["admin_civil_status"] ?? '') == 'Divorced' ? 'selected' : '' ?>>
                                    Divorced
                                </option>
                                <option value="Annulled"
                                    <?= ($getAdminData["admin_civil_status"] ?? '') == 'Annulled' ? 'selected' : '' ?>>
                                    Annulled
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Religion</label>
                            <select name="admin_religion" id="admin_religion" class="form-select">
                                <option value="">Select Religion</option>
                                <option value="Roman Catholic"
                                    <?= ($getAdminData["admin_religion"] ?? '') == 'Roman Catholic' ? 'selected' : '' ?>>
                                    Roman
                                    Catholic</option>
                                <option value="Islam"
                                    <?= ($getAdminData["admin_religion"] ?? '') == 'Islam' ? 'selected' : '' ?>>Islam
                                </option>
                                <option value="Iglesia ni Cristo"
                                    <?= ($getAdminData["admin_religion"] ?? '') == 'Iglesia ni Cristo' ? 'selected' : '' ?>>
                                    Iglesia ni Cristo</option>
                                <option value="Protestant"
                                    <?= ($getAdminData["admin_religion"] ?? '') == 'Protestant' ? 'selected' : '' ?>>
                                    Protestant
                                </option>
                                <option value="Born Again Christian"
                                    <?= ($getAdminData["admin_religion"] ?? '') == 'Born Again Christian' ? 'selected' : '' ?>>
                                    Born Again Christian</option>
                                <option value="Seventh-day Adventist"
                                    <?= ($getAdminData["admin_religion"] ?? '') == 'Seventh-day Adventist' ? 'selected' : '' ?>>
                                    Seventh-day Adventist</option>
                                <option value="Buddhist"
                                    <?= ($getAdminData["admin_religion"] ?? '') == 'Buddhist' ? 'selected' : '' ?>>
                                    Buddhist
                                </option>
                                <option value="Jehovah's Witness"
                                    <?= ($getAdminData["admin_religion"] ?? '') == 'Jehovah\'s Witness' ? 'selected' : '' ?>>
                                    Jehovah's Witness</option>
                                <option value="Mormon"
                                    <?= ($getAdminData["admin_religion"] ?? '') == 'Mormon' ? 'selected' : '' ?>>Mormon
                                </option>
                                <option value="Aglipayan"
                                    <?= ($getAdminData["admin_religion"] ?? '') == 'Aglipayan' ? 'selected' : '' ?>>
                                    Aglipayan
                                </option>
                                <option value="None"
                                    <?= ($getAdminData["admin_religion"] ?? '') == 'None' ? 'selected' : '' ?>>None
                                </option>
                                <option value="Others"
                                    <?= ($getAdminData["admin_religion"] ?? '') == 'Others' ? 'selected' : '' ?>>Others
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Birthday</label>
                            <?php
                                // Convert birthday to proper date format for input type="date"
                                $birthday = $getAdminData["admin_birth"] ?? '';
                                if (!empty($birthday)) {
                                    // If it's already in YYYY-MM-DD format, use it directly
                                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {
                                        $formattedBirthday = $birthday;
                                    } else {
                                        // Try to convert from other formats
                                        $formattedBirthday = date('Y-m-d', strtotime($birthday));
                                    }
                                } else {
                                    $formattedBirthday = '';
                                }
                            ?>
                            <input type="date" name="admin_birth" id="admin_birth" class="form-control"
                                value="<?= htmlspecialchars($formattedBirthday) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Age</label>
                            <input type="text" name="age" id="age" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Birth Place</label>
                            <input type="text" name="admin_birthPlace" id="admin_birthPlace" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_birthPlace"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="admin_cpno" id="admin_cpno" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_cpno"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="admin_email" id="admin_email" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_email"] ?? '') ?>">
                        </div>
                    </div>
                    <!-- ADDRESS INFORMATION HEADER -->
                    <div class="header ps-3 pt-3">
                        <h5 class="m-0 p-0">
                            <i class="fa-solid fa-circle-info me-2"></i>Address Information
                        </h5>
                    </div>
                    <!-- ADDRESS INFORMATION CONTENTS -->
                    <div class="row flex-wrap col-md-12 col-12 p-3 h-auto">
                        <div class="col-md-3">
                            <label class="form-label">House/Block No.</label>
                            <input type="text" name="admin_house" id="admin_house" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_house"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Street</label>
                            <input type="text" name="admin_street" id="admin_street" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_street"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Subdivision</label>
                            <input type="text" name="admin_subdivision" id="admin_subdivision" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_subdivision"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Barangay</label>
                            <input type="text" name="admin_barangay" id="admin_barangay" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_barangay"] ?? '') ?>">
                        </div>
                        <div class="col-md-3" style="z-index: 2 !important;">
                            <label class="form-label">City/Municipality</label>
                            <input type="text" name="admin_city" id="admin_city" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_city"] ?? '') ?>">
                        </div>
                        <div class="col-md-3" style="z-index: 2 !important;">
                            <label class="form-label">Province</label>
                            <input type="text" name="admin_province" id="admin_province" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_province"] ?? '') ?>">
                        </div>
                        <div class="col-md-3" style="z-index: 2 !important;">
                            <label class="form-label">Zip Code</label>
                            <input type="text" name="admin_zip_code" id="admin_zip_code" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["admin_zip_code"] ?? '') ?>">
                        </div>
                    </div>
                    <div
                        class="col-md-12 hidden-button d-flex button-margin-right no-padding-media justify-content-end me-5">
                        <button type="submit"
                            class="btn btn-sm btn-danger px-5 mt-3 me-5 no-padding-media button-margin-right">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Employement -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-8 height tab-pane fade" role="tabpanel" id="Employement">
            <form id="employment_update">
                <input type="hidden" name="admin_update" value="true">
                <div class="card rounded-2 profile-contents col-md-12 col-12" style="overflow-y: scroll;">
                    <!-- EMPLOYMENT INFORMATION HEADER -->
                    <div class="col-md-12 d-flex">
                        <div class="header ps-3 pt-3 col-md-5">
                            <h5 class="m-0 p-0 label-media-name">
                                <i class="fa-solid fa-circle-info me-2"></i>Employment Information
                            </h5>
                        </div>
                    </div>
                    <!-- EMPLOYMENT INFORMATION CONTENTS -->
                    <div class="row flex-wrap col-md-12 col-12 p-3">
                        <div class="col-md-4">
                            <label class="form-label">Employee ID</label>
                            <input type="text" name="admin_employee_id"
                                value="<?= $getAdminData["admin_employee_id"] ?>" id="employeeID_field"
                                class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Joined at</label>
                            <input type="text" name="joined_at" value="<?= $getAdminData["joined_at"] ?>"
                                id="joined_at_field" class="form-control">
                        </div>
                        <?php
                            $stmt = $pdo->prepare("SELECT d.Department_id, d.Department_name FROM departments d");
                            $stmt->execute();
                            $departmentResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $stmt = $pdo->prepare("SELECT * FROM jobTitles");
                            $stmt->execute();
                            $jobtitleResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <div class="col-md-4">
                            <label class="form-label">Department</label>
                            <select name="admin_department_id" class="form-select" required>
                                <option value="">Select Department</option>
                                <?php foreach($departmentResult as $departments): ?>
                                <option value="<?= $departments['Department_id'] ?>"
                                    <?= ($departments['Department_id'] == $getAdminData['Department_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($departments['Department_name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Job Title</label>
                            <select name="admin_position_id" class="form-select" required>
                                <option value="">Select Job Title</option>
                                <?php foreach($jobtitleResult as $jb): ?>
                                <option value="<?= $jb['jobTitles_id'] ?>"
                                    <?= ($jb['jobTitles_id'] == $getAdminData['jobTitles_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($jb['jobTitle']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Unit/Section</label>
                            <select name="unit_section_id" id="" class="form-select">
                                <option value="">Select Unit/Section</option>
                                <?php foreach($getUnit as $uniSec):  ?>
                                    <option value="<?= $uniSec["unit_section_id"] ?>"><?= htmlspecialchars($uniSec["unit_section_name"]) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <strong class="w-100 text-start fs-5 mt-3">
                            Scheduling information
                        </strong>
                        <?php
                            $stmtTemplates = $pdo->prepare("SELECT * FROM sched_template ORDER BY department, scheduleName");
                            $stmtTemplates->execute();
                            $templates = $stmtTemplates->fetchAll(PDO::FETCH_ASSOC);

                            $groupedTemplates = [];
                            foreach ($templates as $template) {
                                $groupedTemplates[$template['department']][] = $template;
                            }
                            ?>

                        <div class="col-md-3">
                            <label class="form-label">Schedule Template</label>
                            <select name="schedule_template" id="schedule_template" class="form-select">
                                <option value="">Select Schedule </option>
                                <?php foreach ($groupedTemplates as $department => $deptTemplates): ?>
                                <optgroup label="<?= $department ?>">
                                    <?php foreach ($deptTemplates as $template): ?>
                                    <option value="<?= $template['template_id'] ?>"
                                        data-from="<?= $template['schedule_from'] ?>"
                                        data-to="<?= $template['schedule_to'] ?>" data-shift="<?= $template['shift'] ?>"
                                        data-days="<?= $template['day'] ?>"
                                        data-name="<?= htmlspecialchars($template['scheduleName']) ?>">
                                        <?= htmlspecialchars($template['scheduleName']) ?>
                                        (<?= $template['schedule_from'] ?> - <?= $template['schedule_to'] ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Shift Type</label>
                            <input type="text" name="shift_type" value="<?= $getAdminData["shift_type"] ?? '' ?>"
                                id="shift_type" class="form-control" placeholder="Auto-filled from template" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Work Days</label>
                            <input type="text" name="work_days" value="<?= $getAdminData["work_days"] ?? '' ?>"
                                id="work_days" class="form-control" placeholder="Auto-filled from template" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Schedule From</label>
                            <input type="time" name="scheduleFrom" value="<?= $getAdminData["scheduleFrom"] ?? '' ?>"
                                id="scheduleFrom" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Schedule To</label>
                            <input type="time" name="scheduleTo" id="scheduleTo"
                                value="<?= $getAdminData["scheduleTo"] ?? '' ?>" class="form-control" readonly>
                        </div>

                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const scheduleTemplate = document.getElementById('schedule_template');
                            const shiftType = document.getElementById('shift_type');
                            const workDays = document.getElementById('work_days');
                            const scheduleFrom = document.getElementById('scheduleFrom');
                            const scheduleTo = document.getElementById('scheduleTo');

                            scheduleTemplate.addEventListener('change', function() {
                                if (this.value) {
                                    const selectedOption = this.options[this.selectedIndex];

                                    // Auto-fill all fields
                                    shiftType.value = selectedOption.getAttribute('data-shift');
                                    workDays.value = selectedOption.getAttribute('data-days');
                                    scheduleFrom.value = selectedOption.getAttribute('data-from');
                                    scheduleTo.value = selectedOption.getAttribute('data-to');

                                    // Optional: Add visual feedback
                                    this.classList.add('is-valid');
                                } else {
                                    // Clear fields if no template selected
                                    clearScheduleFields();
                                }
                            });

                            function clearScheduleFields() {
                                shiftType.value = '';
                                workDays.value = '';
                                scheduleFrom.value = '';
                                scheduleTo.value = '';
                                scheduleTemplate.classList.remove('is-valid');
                            }

                            // Optional: Allow manual editing by double-clicking fields
                            [shiftType, workDays, scheduleFrom, scheduleTo].forEach(field => {
                                field.addEventListener('dblclick', function() {
                                    this.readOnly = !this.readOnly;
                                    if (!this.readOnly) {
                                        this.focus();
                                    }
                                });
                            });
                        });
                        </script>
                        <div class="col-md-12 d-flex mt-3 justify-content-end me-0">
                            <button type="submit" class="btn  btn-danger px-5 mt-3 me-2">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- HRMS Activation -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-8 height tab-pane fade" role="tabpanel" id="hrEmployees">
            <table class="text-center table table-bordered text-center table-sm">
                <thead class="table-light col-md-12">
                    <tr class="col-md-12">
                        <th>#</th>
                        <th>Complete Name</th>
                        <th>Account Role</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center" id="Accounts_approved" style="color: #666;">
                    <?php 
                        $stmtOfficial = $pdo->prepare("
                            SELECT 
                                ed.employee_id, 
                                ed.firstname, 
                                ed.middlename, 
                                ed.lastname, 
                                ed.suffix,
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
                            WHERE ed.user_role = 'HRSM'
                            ORDER BY ed.status
                        ");
                        $stmtOfficial->execute();
                        $officialEmployees = $stmtOfficial->fetchAll(PDO::FETCH_ASSOC);
                        $countOfficials = 1;
                        if($officialEmployees){
                            foreach ($officialEmployees as $officials) : ?>
                    <tr>
                        <th><?= $countOfficials++ ?></th>
                        <th><?= htmlspecialchars($officials["firstname"]) . ' ' . htmlspecialchars($officials["lastname"]) ?>
                        </th>
                        <th>HRMS</th>
                        <td class="d-flex justify-content-center flex-wrap gap-1">
                            <a
                                href="index.php?page=contents/profile&id=<?= htmlspecialchars($officials["employee_id"]) ?>">
                                <button class="btn btn-sm btn-danger px-3 py-2 m-0">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </a>

                            <form class="form_select d-flex align-items-center">
                                <input type="hidden" name="employee_id"
                                    value="<?= htmlspecialchars($officials['employee_id']) ?>">
                                <select class="form-select m-0 p-2 select_status" name="status">
                                    <option value="" disabled>Select Status</option>
                                    <option value="Active" <?= ($officials['status'] === 'Active') ? 'selected' : '' ?>>
                                        Active
                                    </option>
                                    <option value="Inactive"
                                        <?= ($officials['status'] === 'Inactive') ? 'selected' : '' ?>>
                                        Inactive</option>
                                    <option value="Pending"
                                        <?= ($officials['status'] === 'Pending') ? 'selected' : '' ?>>
                                        Pending</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    <?php 
                                        endforeach; 
                                    }else {
                                        echo '<tr><td colspan="6" class="text-center">No employees found</td></tr>';
                                    }  
                                ?>
                </tbody>
            </table>
        </div>
        <!-- LOGIN HISTORY TAB -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-8 height tab-pane fade" role="tabpanel" id="history">
            <div class="card rounded-2 profile-contents" style="overflow-y: scroll;">
                <!-- LOGIN HISTORY HEADER -->
                <div class="header ps-3 pt-3">
                    <h5 class="m-0 p-0">
                        <i class="fa-solid fa-circle-info me-2"></i>Login History
                    </h5>
                </div>

                <!-- LOGIN HISTORY CONTENTS -->
                <div class="table-responsive table-body-201">
                    <table class="text-center table table-bordered text-center table-sm">
                        <?php
                        $stmtHistory = $pdo->prepare("SELECT * FROM admin_login_history WHERE employee_id = '$admin_id' ORDER BY login_time DESC");
                        $stmtHistory->execute();
                        $history = $stmtHistory->fetchAll(PDO::FETCH_ASSOC);  
                    ?>



                        <thead class="table-light col-md-12">
                            <tr class="col-md-12">
                            <tr>
                                <th>Login Time</th>
                                <th>Logout Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($history as $his) : ?>
                            <tr>
                                <th><?= 'Login at: <strong>' . date("M d Y g:iA", strtotime($his["login_time"])) . '</strong>' ?>
                                </th>
                                <th>
                                    <p class="w-100 text-danger mb-0 mb-2">
                                        <?php if (!empty($his["logout_time"])): ?>
                                        <?= 'Logout at: <strong>' . date("M d Y g:i A", strtotime($his["logout_time"])) . '</strong>' ?>
                                        <?php else: ?>

                                        <?php endif; ?>
                                    </p>
                                </th>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- CHANGE PASSWORD MODAL -->
    <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="changePass_form" class="modal-content">
                <input type="hidden" name="admin_id" value="<?= $admin_id ?>">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-start text-white w-100" id="passwordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="currentPassword">Current Password:</label>
                    <input type="password" name="current_password" id="currentPassword" class="form-control" required>
                </div>
                <div class="modal-body">
                    <label for="newPassword">New Password:</label>
                    <input type="password" name="new_pass" id="newPassword" class="form-control" required>
                </div>
                <div class="modal-body">
                    <label for="confirmPassword">Confirm Password:</label>
                    <input type="password" name="confirm_pass" id="confirmPassword" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const birthdayInput = document.getElementById("admin_birth");
    const ageInput = document.getElementById("age");

    function calculateAge() {
        if (!birthdayInput.value) {
            ageInput.value = "";
            return;
        }

        const birthDate = new Date(birthdayInput.value);
        const today = new Date();

        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        const dayDiff = today.getDate() - birthDate.getDate();

        // Adjust age if birthday hasn't occurred yet this year
        if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
            age--;
        }

        ageInput.value = age;
    }

    // Calculate on change
    birthdayInput.addEventListener("change", calculateAge);

    // Calculate on page load (for pre-filled birthdays)
    calculateAge();
});
</script>