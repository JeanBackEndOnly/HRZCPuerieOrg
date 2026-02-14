<section>
    <?php $getHrData = getHrData();   ?>
    <div class="d-flex justify-content-between align-items-center mb-3 col-md-12 col-12">
        <div class="col-md-5 col-7">
            <h4 class="mb-0 label-media-name"><i class="fa fa-cog text-dark me-2"></i>Account Settings</h4>
            <small class="text-muted p-media-name">Manage your parent account information and preferences</small>
        </div>
        <div class="col-md-7 col-5 d-flex justify-content-end">
            <button class="m-0 btn btn-sm btn-danger change-pass-media" data-bs-toggle="modal" data-bs-target="#changePassword"><i class="fa-solid fa-key me-2"></i>Change Password</button>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-0 col-md-12 col-12 flex-wrap">
        <div class="card-body col-md-8 col-12">
            <ul class="nav nav-tabs justify-content-end align-items-end col-md-12 col-12" id="ProfileInfoTabs">
                <li class="nav-item cursor-pointer col-md-2 col-12">
                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#Personal"><i
                            class="fa-solid fa-circle-info me-2"></i>Personal</a>
                </li>
                <li class="nav-item cursor-pointer col-md-2 col-12">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Employment"><i
                            class="fa-solid me-2 fa-briefcase"></i>Employment</a>
                </li>
                <li class="nav-item cursor-pointer col-md-2 col-12">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Education"><i
                            class="fa-solid me-2 fa-school"></i>Education</a>
                </li>
                <li class="nav-item cursor-pointer col-md-2 col-12">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Family"><i
                            class="fa-solid me-2 fa-people-group"></i>Family</a>
                </li>
                <li class="nav-item cursor-pointer col-md-2 col-12">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Leave">
                        <i class="fa-solid fa-chart-line me-2"></i>Activities</a>
                </li>
                <li class="nav-item cursor-pointer col-md-2 col-12">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#history">
                        <i class="fa-solid fa-clock-rotate-left me-2"></i>Login history</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="column p-2 m-0 rounded-2 col-12 col-md-4">
            <div class="card rounded-2">
                <div class="d-flex flex-column w-100 align-items-center justify-content-center p-2">
                    <?php if($getHrData["profile_picture"] == null){ ?>
                            <strong class="py-1 px-5 text-white mb-2" style="
                                border-radius: 50%;
                                background-color: #303030ff;
                                font-size: 5rem;
                            "><?= htmlspecialchars(substr($getHrData["firstname"], 0,1)) ?></strong>
                    <?php }else{ ?>
                            <img src="../../authentication/uploads/<?= $getHrData["profile_picture"] ?>" 
                                style="width: 200px; height: auto; border-radius: 50%;">
                    <?php } ?>
                    
                    <span id="employeeID"
                        class="text-muted fw-bold"><?= htmlspecialchars($getHrData["employeeID"]) ?? '' ?></span>
                    <span
                        id="employeeName"><?= htmlspecialchars($getHrData["firstname"]) . " " .  substr(htmlspecialchars($getHrData["middlename"]), 0, 1) . ". " . htmlspecialchars($getHrData["lastname"]) ?></span>
                    <span class="text-center"
                        id="employeeDept"><?= htmlspecialchars($getHrData["Department_name"]) . ' (' . htmlspecialchars($getHrData["Department_code"]) . ')'?></span>
                    <span id="employeeJobTitle"><?= htmlspecialchars($getHrData["jobTitle"]) ?? '' ?></span>
                    <span id="employeeSchedule" class="fw-bold"></span>
                      <a href="index.php?page=contents/pds&employee_id=<?= $getHrData["employee_id"] ?? '' ?>" class="mt-2"><strong>View Personal Data Sheet <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i></strong></a>
                </div>
            </div>
        </div>
        <!-- PERSONAL INFORMATIONS TAB -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-8 height tab-pane fade show active" role="tabpanel"
            id="Personal">
            <form id="profile_update_employee" enctype="multipart/form-data">
                <div class="card rounded-2 profile-contents col-md-12 col-12" style="padding-bottom: 5rem !important; overflow-y: scroll;">
                    <input type="hidden" name="employee_id" value="<?= $hr_id ?>">
                    <!-- PERSONAL INFORMATION HEADER -->
                    <div class="col-md-12 d-flex">
                        <div class="header ps-3 pt-3 col-md-5 col-8">
                            <h5 class="m-0 p-0 label-media-name">
                                <i class="fa-solid fa-circle-info me-2"></i>Personal Information
                            </h5>
                        </div>
                        <div class="col-md-7 col-4 button-margin-right no-padding-media d-flex justify-content-end me-5">
                            <button type="submit" class="btn btn-sm btn-danger px-5 mt-3 me-5 button-margin-right">Update</button>
                        </div>
                    </div>

                    <div class="col-md-10 ms-3">
                        <label class="form-label">Upload or update profile picture here:</label>
                        <input type="file" name="profile_picture" class="form-control">
                    </div>

                    <!-- PERSONAL INFORMATION CONTENTS -->
                    <div class="row flex-wrap col-md-12 col-12 p-3">
                        <div class="col-md-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="firstname" class="form-control"
                                value="<?= htmlspecialchars($getHrData["firstname"] ?? '') ?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middlename" class="form-control"
                                value="<?= htmlspecialchars($getHrData["middlename"] ?? '') ?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control"
                                value="<?= htmlspecialchars($getHrData["lastname"] ?? '') ?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Suffix</label>
                            <select class="form-select" name="suffix" disabled>
                                <option value="" <?= empty($getHrData["suffix"] ?? '') ? 'selected' : '' ?>>Select
                                    suffix (optional)</option>
                                <option value="Jr" <?= ($getHrData["suffix"] ?? '') == 'Jr' ? 'selected' : '' ?>>Jr
                                </option>
                                <option value="Sr" <?= ($getHrData["suffix"] ?? '') == 'Sr' ? 'selected' : '' ?>>Sr
                                </option>
                                <option value="II" <?= ($getHrData["suffix"] ?? '') == 'II' ? 'selected' : '' ?>>II
                                </option>
                                <option value="III" <?= ($getHrData["suffix"] ?? '') == 'III' ? 'selected' : '' ?>>III
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Citizenship</label>
                            <input type="text" name="citizenship" class="form-control"
                                value="<?= htmlspecialchars($getHrData["citizenship"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="">Select Gender</option>
                                <option value="MALE" <?= ($getHrData["gender"] ?? '') == 'MALE' ? 'selected' : '' ?>>
                                    Male</option>
                                <option value="FEMALE"
                                    <?= ($getHrData["gender"] ?? '') == 'FEMALE' ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Civil Status</label>
                            <select name="civil_status" id="civil_status" class="form-select">
                                <option value="">Select Civil Status</option>
                                <option value="Single"
                                    <?= ($getHrData["civil_status"] ?? '') == 'Single' ? 'selected' : '' ?>>Single
                                </option>
                                <option value="Married"
                                    <?= ($getHrData["civil_status"] ?? '') == 'Married' ? 'selected' : '' ?>>Married
                                </option>
                                <option value="Widowed"
                                    <?= ($getHrData["civil_status"] ?? '') == 'Widowed' ? 'selected' : '' ?>>Widowed
                                </option>
                                <option value="Separated"
                                    <?= ($getHrData["civil_status"] ?? '') == 'Separated' ? 'selected' : '' ?>>
                                    Separated</option>
                                <option value="Divorced"
                                    <?= ($getHrData["civil_status"] ?? '') == 'Divorced' ? 'selected' : '' ?>>Divorced
                                </option>
                                <option value="Annulled"
                                    <?= ($getHrData["civil_status"] ?? '') == 'Annulled' ? 'selected' : '' ?>>Annulled
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Religion</label>
                            <select name="religion" id="religion" class="form-select">
                                <option value="">Select Religion</option>
                                <option value="Roman Catholic"
                                    <?= ($getHrData["religion"] ?? '') == 'Roman Catholic' ? 'selected' : '' ?>>Roman
                                    Catholic</option>
                                <option value="Islam"
                                    <?= ($getHrData["religion"] ?? '') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                <option value="Iglesia ni Cristo"
                                    <?= ($getHrData["religion"] ?? '') == 'Iglesia ni Cristo' ? 'selected' : '' ?>>
                                    Iglesia ni Cristo</option>
                                <option value="Protestant"
                                    <?= ($getHrData["religion"] ?? '') == 'Protestant' ? 'selected' : '' ?>>Protestant
                                </option>
                                <option value="Born Again Christian"
                                    <?= ($getHrData["religion"] ?? '') == 'Born Again Christian' ? 'selected' : '' ?>>
                                    Born Again Christian</option>
                                <option value="Seventh-day Adventist"
                                    <?= ($getHrData["religion"] ?? '') == 'Seventh-day Adventist' ? 'selected' : '' ?>>
                                    Seventh-day Adventist</option>
                                <option value="Buddhist"
                                    <?= ($getHrData["religion"] ?? '') == 'Buddhist' ? 'selected' : '' ?>>Buddhist
                                </option>
                                <option value="Jehovah's Witness"
                                    <?= ($getHrData["religion"] ?? '') == 'Jehovah\'s Witness' ? 'selected' : '' ?>>
                                    Jehovah's Witness</option>
                                <option value="Mormon"
                                    <?= ($getHrData["religion"] ?? '') == 'Mormon' ? 'selected' : '' ?>>Mormon
                                </option>
                                <option value="Aglipayan"
                                    <?= ($getHrData["religion"] ?? '') == 'Aglipayan' ? 'selected' : '' ?>>Aglipayan
                                </option>
                                <option value="None"
                                    <?= ($getHrData["religion"] ?? '') == 'None' ? 'selected' : '' ?>>None</option>
                                <option value="Others"
                                    <?= ($getHrData["religion"] ?? '') == 'Others' ? 'selected' : '' ?>>Others
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Birthday</label>
                            <?php
                                // Convert birthday to proper date format for input type="date"
                                $birthday = $getHrData["birthday"] ?? '';
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
                            <input type="date" name="birthday" id="birthday" class="form-control"
                                value="<?= htmlspecialchars($formattedBirthday) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Age</label>
                            <input type="text" name="age" id="age" class="form-control"
                                value="<?= htmlspecialchars($getHrData["age"] ?? '') ?>" readonly>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Birth Place</label>
                            <input type="text" name="birthPlace" id="birthPlace" class="form-control"
                                value="<?= htmlspecialchars($getHrData["birthPlace"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact" id="contact" class="form-control"
                                value="<?= htmlspecialchars($getHrData["contact"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="<?= htmlspecialchars($getHrData["email"] ?? '') ?>">
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
                            <input type="text" name="houseBlock" id="houseBlock" class="form-control"
                                value="<?= htmlspecialchars($getHrData["houseBlock"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Street</label>
                            <input type="text" name="street" id="street" class="form-control"
                                value="<?= htmlspecialchars($getHrData["street"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Subdivision</label>
                            <input type="text" name="subdivision" id="subdivision" class="form-control"
                                value="<?= htmlspecialchars($getHrData["subdivision"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Barangay</label>
                            <input type="text" name="barangay" id="barangay" class="form-control"
                                value="<?= htmlspecialchars($getHrData["barangay"] ?? '') ?>">
                        </div>
                        <div class="col-md-3" style="z-index: 2 !important;">
                            <label class="form-label">City/Municipality</label>
                            <input type="text" name="city_muntinlupa" id="city_muntinlupa" class="form-control"
                                value="<?= htmlspecialchars($getHrData["city_muntinlupa"] ?? '') ?>">
                        </div>
                        <div class="col-md-3" style="z-index: 2 !important;">
                            <label class="form-label">Province</label>
                            <input type="text" name="province" id="province" class="form-control"
                                value="<?= htmlspecialchars($getHrData["province"] ?? '') ?>">
                        </div>
                        <div class="col-md-3" style="z-index: 2 !important;">
                            <label class="form-label">Zip Code</label>
                            <input type="text" name="zip_code" id="zip_code" class="form-control"
                                value="<?= htmlspecialchars($getHrData["zip_code"] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-12 hidden-button d-flex button-margin-right no-padding-media justify-content-end me-5">
                            <button type="submit" class="btn btn-sm btn-danger px-5 mt-3 me-5 no-padding-media button-margin-right">Update</button>
                        </div>
                </div>
            </form>
        </div>
        <!-- WORK INFORMATIONS TAB -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-8 height tab-pane fade" role="tabpanel" id="Employment">
            <form id="employment_update">
                <input type="hidden" name="admin_update" value="false">
                <input type="hidden" name="employee_id" value="<?= $hr_id ?>">
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
                            <input type="text" name="employeeID"
                                value="<?= $getHrData["employeeID"] ?>" id="employeeID" readonly
                                class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Joined at</label>
                            <input type="text" name="joined_at" value="<?= $getHrData["joined_at"] ?>"
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
                            <select name="Department_id" class="form-select" required>
                                <option value="">Select Department</option>
                                <?php foreach($departmentResult as $departments): ?>
                                <option value="<?= $departments['Department_id'] ?>"
                                    <?= ($departments['Department_id'] == $getHrData['Department_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($departments['Department_name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Designation</label>
                            <select name="" disabled class="form-select" required>
                                <option value="">Select Designation</option>
                                <?php foreach($jobtitleResult as $jb): ?>
                                <option value="<?= $jb['jobTitles_id'] ?>"
                                    <?= ($jb['jobTitles_id'] == $getHrData['jobTitles_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($jb['jobTitle']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Unit/Section</label>
                            <select name="unit_section_id" id="" class="form-select" required>
                                <option value="">Select Unit/Section</option>
                                <?php foreach($getUnit as $uniSec):  ?>
                                    <option value="<?= $uniSec['unit_section_id'] ?>"
                                    <?= ($uniSec['unit_section_id'] == $getHrData['unit_section_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($uniSec['unit_section_name']) ?>
                                </option>
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
                            <input type="text" name="shift_type" value="<?= $getHrData["shift_type"] ?? '' ?>"
                                id="shift_type" class="form-control" placeholder="Auto-filled from template" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Work Days</label>
                            <input type="text" name="work_days" value="<?= $getHrData["work_days"] ?? '' ?>"
                                id="work_days" class="form-control" placeholder="Auto-filled from template" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Schedule From</label>
                            <input type="time" name="scheduleFrom" value="<?= $getHrData["scheduleFrom"] ?? '' ?>"
                                id="scheduleFrom" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Schedule To</label>
                            <input type="time" name="scheduleTo" id="scheduleTo"
                                value="<?= $getHrData["scheduleTo"] ?? '' ?>" class="form-control" readonly>
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
        <!-- EDUCATIONAL BACKGROUND TAB -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-8 height tab-pane fade" role="tabpanel" id="Education">
            <form id="educational_update_employee">
                <input type="hidden" name="employee_id" value="<?= $hr_id ?>">
                <div class="card rounded-2 profile-contents col-md-12 col-12" style="overflow-y: scroll;">
                    <!-- EDUCATIONAL INFORMATION HEADER -->
                    <div class="col-md-12 d-flex">
                        <div class="header ps-3 pt-3 col-md-5 col-8">
                            <h5 class="m-0 p-0 label-media-name">
                                <i class="fa-solid fa-circle-info me-2"></i>Educational Background
                            </h5>
                        </div>
                        <div class="col-md-7 col-4 button-margin-right no-padding-media d-flex justify-content-end me-5">
                            <button type="submit" class="btn btn-sm btn-danger px-5 mt-3 me-5 button-margin-right">Update</button>
                        </div>
                    </div>
                    <?php
                        // Fetch educational data for each level
                        $educationLevels = ['Elementary', 'High_school', 'Senior_high', 'College', 'Graduate'];
                        $educationData = [];
                        
                        foreach($educationLevels as $level) {
                            $stmt = $pdo->prepare("SELECT * FROM educational_data WHERE employee_id = ? AND education_level = ?");
                            $stmt->execute([$hr_id, $level]);
                            $educationData[$level] = $stmt->fetch(PDO::FETCH_ASSOC);
                        }
                    ?>
                    <!-- EDUCATIONAL INFORMATION CONTENTS -->
                    <div class="row flex-wrap col-md-12 col-12 p-3">
                        <!-- Elementary School -->
                        <strong class="w-100 text-start fs-5">Elementary Information</strong>
                        <div class="col-md-3">
                            <label class="form-label">Elementary School Name</label>
                            <input type="text" name="elementary_school_name" class="form-control"
                                value="<?= $educationData['Elementary']['school_name'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Year Started</label>
                            <input type="text" name="elementary_year_started" class="form-control"
                                value="<?= $educationData['Elementary']['year_started'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Year Ended</label>
                            <input type="text" name="elementary_year_ended" class="form-control"
                                value="<?= $educationData['Elementary']['year_ended'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Honors</label>
                            <textarea name="elementary_honors"
                                class="form-control"><?= $educationData['Elementary']['honors'] ?? '' ?></textarea>
                        </div>

                        <!-- High School -->
                        <strong class="w-100 text-start fs-5">High School Information</strong>
                        <div class="col-md-3">
                            <label class="form-label">High School Name</label>
                            <input type="text" name="high_school_school_name" class="form-control"
                                value="<?= $educationData['High_school']['school_name'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Year Started</label>
                            <input type="text" name="high_school_year_started" class="form-control"
                                value="<?= $educationData['High_school']['year_started'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Year Ended</label>
                            <input type="text" name="high_school_year_ended" class="form-control"
                                value="<?= $educationData['High_school']['year_ended'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Honors</label>
                            <textarea name="high_school_honors"
                                class="form-control"><?= $educationData['High_school']['honors'] ?? '' ?></textarea>
                        </div>

                        <!-- Senior High School -->
                        <strong class="w-100 text-start fs-5">Senior High Information</strong>
                        <div class="col-md-3">
                            <label class="form-label">Senior High School Name</label>
                            <input type="text" name="senior_high_school_name" class="form-control"
                                value="<?= $educationData['Senior_high']['school_name'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Year Started</label>
                            <input type="text" name="senior_high_year_started" class="form-control"
                                value="<?= $educationData['Senior_high']['year_started'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Year Ended</label>
                            <input type="text" name="senior_high_year_ended" class="form-control"
                                value="<?= $educationData['Senior_high']['year_ended'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Strand</label>
                            <input type="text" name="senior_high_course_strand" class="form-control"
                                value="<?= $educationData['Senior_high']['course_strand'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Honors</label>
                            <textarea name="senior_high_honors"
                                class="form-control"><?= $educationData['Senior_high']['honors'] ?? '' ?></textarea>
                        </div>

                        <!-- College -->
                        <strong class="w-100 text-start fs-5">College Information</strong>
                        <div class="col-md-3">
                            <label class="form-label">College School Name</label>
                            <input type="text" name="college_school_name" class="form-control"
                                value="<?= $educationData['College']['school_name'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Year Started</label>
                            <input type="text" name="college_year_started" class="form-control"
                                value="<?= $educationData['College']['year_started'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Year Ended</label>
                            <input type="text" name="college_year_ended" class="form-control"
                                value="<?= $educationData['College']['year_ended'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Course</label>
                            <input type="text" name="college_course_strand" class="form-control"
                                value="<?= $educationData['College']['course_strand'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Honors</label>
                            <textarea name="college_honors"
                                class="form-control"><?= $educationData['College']['honors'] ?? '' ?></textarea>
                        </div>

                        <!-- Graduate -->
                        <strong class="w-100 text-start fs-5">Graduate Information</strong>
                        <div class="col-md-3">
                            <label class="form-label">Graduate School Name</label>
                            <input type="text" name="graduate_school_name" class="form-control"
                                value="<?= $educationData['Graduate']['school_name'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Year Started</label>
                            <input type="text" name="graduate_year_started" class="form-control"
                                value="<?= $educationData['Graduate']['year_started'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Year Ended</label>
                            <input type="text" name="graduate_year_ended" class="form-control"
                                value="<?= $educationData['Graduate']['year_ended'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Course</label>
                            <input type="text" name="graduate_course_strand" class="form-control"
                                value="<?= $educationData['Graduate']['course_strand'] ?? '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Honors</label>
                            <textarea name="graduate_honors"
                                class="form-control"><?= $educationData['Graduate']['honors'] ?? '' ?></textarea>
                        </div>
                    </div>
                    <div class="transform col-md-12 col-12 d-flex justify-content-end pe-4 mt-3 mb-2">
                        <button type="submit" class="btn btn-danger px-5 mt-4">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- FAMILY BACKGROUND TAB -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-8 height tab-pane fade" role="tabpanel" id="Family">
             <form id="family_update_employee">
                <input type="hidden" name="employee_id" value="<?= $hr_id ?>">
                <div class="card rounded-2 profile-contents" style="overflow-y: scroll;">
                    <!-- FAMILY INFORMATION HEADER -->
                    <div class="col-md-12 d-flex">
                        <div class="header ps-3 pt-3 col-md-5">
                            <h5 class="m-0 p-0">
                                <i class="fa-solid fa-circle-info me-2"></i>Family Information
                            </h5>
                        </div>
                        <div class="col-md-7 d-flex justify-content-end me-5">
                            <button type="submit" class="btn btn-sm btn-danger px-5 mt-3 me-5">Update</button>
                        </div>
                    </div>
                    <?php
                        $stmtFather = $pdo->prepare("SELECT * FROM Family_data WHERE employee_id = '$hr_id' AND Relationship = 'Father'");
                        $stmtFather->execute();
                        $father = $stmtFather->fetch(PDO::FETCH_ASSOC);        
                    
                        $stmtMother = $pdo->prepare("SELECT * FROM Family_data WHERE employee_id = '$hr_id' AND Relationship = 'Mother'");
                        $stmtMother->execute();
                        $mother = $stmtMother->fetch(PDO::FETCH_ASSOC);   

                        $stmtGuardian = $pdo->prepare("SELECT * FROM Family_data WHERE employee_id = '$hr_id' AND Relationship = 'Guardian'");
                        $stmtGuardian->execute();
                        $guardian = $stmtGuardian->fetch(PDO::FETCH_ASSOC);  
                        
                        $stmtSpouse = $pdo->prepare("SELECT * FROM Family_data WHERE employee_id = '$hr_id' AND Relationship = 'Spouse'");
                        $stmtSpouse->execute();
                        $Spouse = $stmtSpouse->fetch(PDO::FETCH_ASSOC);  
                    ?>
                    <!-- FAMILY INFORMATION CONTENTS -->
                    <div class="row flex-wrap col-md-12 col-12 p-3">
                        <div class="col-md-12 row">
                            <!-- Fathers info -->
                            <strong class="fs-5 w-100 text-start">Father's Information</strong>
                            <div class="col-md-4">
                                <label class="form-label">First Name</label>
                                <input type="text" name="father_firstname" class="form-control"
                                    value="<?= $father["firstname"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Middle Name</label>
                                <input type="text" name="father_middlename" class="form-control"
                                    value="<?= $father["middlename"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="father_lastname" class="form-control"
                                    value="<?= $father["lastname"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Occupation</label>
                                <input type="text" name="father_occupation" class="form-control"
                                    value="<?= $father["occupation"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact</label>
                                <input type="text" name="father_contact" class="form-control"
                                    value="<?= $father["contact"] ?? '' ?>">
                            </div>
                            <strong class="fs-5 w-100 text-start mt-2">Father's Address</strong>
                            <div class="col-md-4">
                                <label class="form-label">House Block</label>
                                <input type="text" name="father_house_block" class="form-control"
                                    value="<?= $father["house_block"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Street</label>
                                <input type="text" name="father_street" class="form-control"
                                    value="<?= $father["street"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Subdivision</label>
                                <input type="text" name="father_subdivision" class="form-control"
                                    value="<?= $father["subdivision"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Barangay</label>
                                <input type="text" name="father_barangay" class="form-control"
                                    value="<?= $father["barangay"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" name="father_city" class="form-control"
                                    value="<?= $father["city"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Province</label>
                                <input type="text" name="father_province" class="form-control"
                                    value="<?= $father["province"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Zip Code</label>
                                <input type="text" name="father_zip_code" class="form-control"
                                    value="<?= $father["zip_code"] ?? '' ?>">
                            </div>

                            <!-- Mothers info -->
                            <strong class="fs-5 w-100 text-start">Mother's Information</strong>
                            <div class="col-md-4">
                                <label class="form-label">First Name</label>
                                <input type="text" name="mother_firstname" class="form-control"
                                    value="<?= $mother["firstname"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Middle Name</label>
                                <input type="text" name="mother_middlename" class="form-control"
                                    value="<?= $mother["middlename"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="mother_lastname" class="form-control"
                                    value="<?= $mother["lastname"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Occupation</label>
                                <input type="text" name="mother_occupation" class="form-control"
                                    value="<?= $mother["occupation"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact</label>
                                <input type="text" name="mother_contact" class="form-control"
                                    value="<?= $mother["contact"] ?? '' ?>">
                            </div>
                            <strong class="fs-5 w-100 text-start mt-2">Mother's Address</strong>
                            <div class="col-md-4">
                                <label class="form-label">House Block</label>
                                <input type="text" name="mother_house_block" class="form-control"
                                    value="<?= $mother["house_block"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Street</label>
                                <input type="text" name="mother_street" class="form-control"
                                    value="<?= $mother["street"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Subdivision</label>
                                <input type="text" name="mother_subdivision" class="form-control"
                                    value="<?= $mother["subdivision"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Barangay</label>
                                <input type="text" name="mother_barangay" class="form-control"
                                    value="<?= $mother["barangay"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" name="mother_city" class="form-control"
                                    value="<?= $mother["city"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Province</label>
                                <input type="text" name="mother_province" class="form-control"
                                    value="<?= $mother["province"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Zip Code</label>
                                <input type="text" name="mother_zip_code" class="form-control"
                                    value="<?= $mother["zip_code"] ?? '' ?>">
                            </div>

                            <!-- Guardian informations -->
                            <strong class="fs-5 w-100 text-start">Guardian's Information</strong>
                            <div class="col-md-4">
                                <label class="form-label">First Name</label>
                                <input type="text" name="guardian_firstname" class="form-control"
                                    value="<?= $guardian["firstname"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Middle Name</label>
                                <input type="text" name="guardian_middlename" class="form-control"
                                    value="<?= $guardian["middlename"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="guardian_lastname" class="form-control"
                                    value="<?= $guardian["lastname"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Occupation</label>
                                <input type="text" name="guardian_occupation" class="form-control"
                                    value="<?= $guardian["occupation"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact</label>
                                <input type="text" name="guardian_contact" class="form-control"
                                    value="<?= $guardian["contact"] ?? '' ?>">
                            </div>
                            <strong class="fs-5 w-100 text-start mt-2">Guardian's Address</strong>
                            <div class="col-md-4">
                                <label class="form-label">House Block</label>
                                <input type="text" name="guardian_house_block" class="form-control"
                                    value="<?= $guardian["house_block"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Street</label>
                                <input type="text" name="guardian_street" class="form-control"
                                    value="<?= $guardian["street"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Subdivision</label>
                                <input type="text" name="guardian_subdivision" class="form-control"
                                    value="<?= $guardian["subdivision"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Barangay</label>
                                <input type="text" name="guardian_barangay" class="form-control"
                                    value="<?= $guardian["barangay"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" name="guardian_city" class="form-control"
                                    value="<?= $guardian["city"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Province</label>
                                <input type="text" name="guardian_province" class="form-control"
                                    value="<?= $guardian["province"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Zip Code</label>
                                <input type="text" name="guardian_zip_code" class="form-control"
                                    value="<?= $guardian["zip_code"] ?? '' ?>">
                            </div>

                            <!-- Spouse informations -->
                            <strong class="fs-5 w-100 text-start">Spouse Information</strong>
                            <div class="col-md-4">
                                <label class="form-label">First Name</label>
                                <input type="text" name="spouse_firstname" class="form-control"
                                    value="<?= $Spouse["firstname"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Middle Name</label>
                                <input type="text" name="spouse_middlename" class="form-control"
                                    value="<?= $Spouse["middlename"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="spouse_lastname" class="form-control"
                                    value="<?= $Spouse["lastname"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Occupation</label>
                                <input type="text" name="spouse_occupation" class="form-control"
                                    value="<?= $Spouse["occupation"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact</label>
                                <input type="text" name="spouse_contact" class="form-control"
                                    value="<?= $Spouse["contact"] ?? '' ?>">
                            </div>
                            <strong class="fs-5 w-100 text-start mt-2">Spouse Address</strong>
                            <div class="col-md-4">
                                <label class="form-label">House Block</label>
                                <input type="text" name="spouse_house_block" class="form-control"
                                    value="<?= $Spouse["house_block"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Street</label>
                                <input type="text" name="spouse_street" class="form-control"
                                    value="<?= $Spouse["street"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Subdivision</label>
                                <input type="text" name="spouse_subdivision" class="form-control"
                                    value="<?= $Spouse["subdivision"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Barangay</label>
                                <input type="text" name="spouse_barangay" class="form-control"
                                    value="<?= $Spouse["barangay"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" name="spouse_city" class="form-control"
                                    value="<?= $Spouse["city"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Province</label>
                                <input type="text" name="spouse_province" class="form-control"
                                    value="<?= $Spouse["province"] ?? '' ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Zip Code</label>
                                <input type="text" name="spouse_zip_code" class="form-control"
                                    value="<?= $Spouse["zip_code"] ?? '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end me-5 mb-5">
                        <button type="submit" class="btn btn-sm btn-danger px-5 mt-3 me-5">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Leave Informations -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-8 height tab-pane fade" role="tabpanel" id="Leave">
            <div class="card rounded-2 profile-contents col-md-12 col-12" style="overflow-y: scroll;">
                <!-- FAMILY INFORMATION HEADER -->
                <div class="header ps-3 pt-3">
                    <h5 class="m-0 p-0 label-media-name">
                        <i class="fa-solid fa-circle-info me-2"></i>Activity Tracking
                    </h5>
                </div>
                <!-- FAMILY INFORMATION CONTENTS -->
                <div class="row flex-wrap col-md-12 col-12 p-3">
                    <?php
                        $stmtActivities = $pdo->prepare("SELECT * FROM activities WHERE employee_id = '$hr_id' ORDER BY activity_at DESC");
                        $stmtActivities->execute();
                        $Activities = $stmtActivities->fetchAll(PDO::FETCH_ASSOC);

                        
                    ?>
                    <div class="responsive-table w-100">
                        <table class="table table-responsive table-bordered text-center">
                            <thead>
                                <tr>
                                    <th><strong>Recent Activities</strong></th>
                                    <th><strong>Activity Timeline</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($Activities as $act) : ?>
                                    <tr>
                                        <th  class="fw-light"><span><?= htmlspecialchars($act["activity_type"]) ?></span></th>
                                        <th  class="fw-light"><span><?= date("F j, Y g:i A", strtotime($act["activity_at"])) ?></span></th>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
         <div class="column p-2 m-0 rounded-2 col-12 col-md-8 height tab-pane fade" role="tabpanel" id="history">
            <div class="card rounded-2 profile-contents col-md-12 col-12" style="overflow-y: scroll;">
                <!-- FAMILY INFORMATION HEADER -->
                <div class="header ps-3 pt-3">
                    <h5 class="m-0 p-0 label-media-name">
                        <i class="fa-solid fa-circle-info me-2"></i>Login History
                    </h5>
                </div>
                <!-- FAMILY INFORMATION CONTENTS -->
                <div class="row flex-wrap col-md-12 col-12 p-3">
                    <?php
                        $stmtHistory = $pdo->prepare("SELECT * FROM login_history WHERE employee_id = '$hr_id' ORDER BY login_time DESC");
                        $stmtHistory->execute();
                        $history = $stmtHistory->fetchAll(PDO::FETCH_ASSOC);

                        
                    ?>
                    <div class="responsive-table">
                        <table class="table table-responsive table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Login Time</th>
                                    <th>Logout Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($history as $his) : ?>
                                    <tr>
                                        <th><?= 'Login at: <strong>' . date("M d Y g:iA", strtotime($his["login_time"])) . '</strong>' ?></th>
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
    <!-- change password modal -->
    <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="changePass_form" class="modal-content">
                <input type="hidden" name="employee_id" value="<?= $hr_id ?>">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-start text-white w-100" id="passwordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="usernameConfim">Current Password:</label>
                    <input type="password" name="current_password" id="usernameConfim" class="form-control" required>
                </div>
                <div class="modal-body">
                    <label for="usernameConfim">New Password:</label>
                    <input type="password" name="new_pass" id="usernameConfim" class="form-control" required>
                </div>
                <div class="modal-body">
                    <label for="usernameConfim">Confirm Password:</label>
                    <input type="password" name="confirm_pass" id="usernameConfim" class="form-control" required>
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
document.addEventListener('DOMContentLoaded', function() {
    const birthdayInput = document.getElementById('birthday');
    const ageInput = document.getElementById('age');
    
    if (birthdayInput && ageInput) {
        // Calculate age when birthday changes
        birthdayInput.addEventListener('change', function() {
            calculateAge(this.value);
        });
        
        // Calculate age on page load if birthday has a value
        if (birthdayInput.value) {
            calculateAge(birthdayInput.value);
        }
        
        // Function to calculate age from date string
        function calculateAge(birthDate) {
            if (!birthDate) {
                ageInput.value = '';
                return;
            }
            
            const today = new Date();
            const birth = new Date(birthDate);
            
            // Check if date is valid
            if (isNaN(birth.getTime())) {
                ageInput.value = '';
                return;
            }
            
            let age = today.getFullYear() - birth.getFullYear();
            const monthDiff = today.getMonth() - birth.getMonth();
            
            // Adjust age if birthday hasn't occurred yet this year
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                age--;
            }
            
            // Don't allow negative ages
            ageInput.value = age >= 0 ? age : '';
        }
        
        // Also recalculate when the input value changes programmatically
        const observer = new MutationObserver(function() {
            if (birthdayInput.value) {
                calculateAge(birthdayInput.value);
            }
        });
        
        observer.observe(birthdayInput, { attributes: true, attributeFilter: ['value'] });
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileContents = document.querySelector('.profile-contents');
    if (profileContents) {
        // Override the scrollbar display property
        profileContents.style.setProperty('scrollbar-width', 'thin', 'important');
        profileContents.style.setProperty('-webkit-scrollbar', 'auto', 'important');
        
        // Add custom scrollbar styling
        const style = document.createElement('style');
        style.textContent = `
            .profile-contents::-webkit-scrollbar {
                display: block !important;
                width: 8px !important;
            }
            .profile-contents::-webkit-scrollbar-track {
                background: #f1f1f1 !important;
                border-radius: 4px !important;
            }
            .profile-contents::-webkit-scrollbar-thumb {
                background: #c1c1c1 !important;
                border-radius: 4px !important;
            }
            .profile-contents::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8 !important;
            }
        `;
        document.head.appendChild(style);
    }
});
</script>