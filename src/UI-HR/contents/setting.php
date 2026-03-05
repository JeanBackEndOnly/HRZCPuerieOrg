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
                <li class="nav-item cursor-pointer col-md-2 col-12">
                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#Personal">
                        <i class="fa-solid fa-circle-info me-2"></i> Personal
                    </a>
                </li>
                <li class="nav-item cursor-pointer col-md-2 col-12">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Employment"><i
                            class="fa-solid me-2 fa-briefcase"></i>Employment</a>
                </li>
                <li class="nav-item cursor-pointer col-md-2 col-12">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Leave_Credits"><i
                            class="fa-solid fa-person-through-window me-2"></i>Leave</a>
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
                        <i class="fa-solid fa-clock me-2"></i>Login History
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-3">
            <div class="card rounded-2">
                <div class="d-flex flex-column w-100 align-items-center justify-content-center p-2">
                    <div class="w-100 d-flex justify-content-start ps-3 pt-1">
                    </div>
                    <?php if($hr_data["profile_picture"] == null){ ?>
                    <div class="profile-circle d-flex align-items-center justify-content-center mb-1">
                        <strong class="p-0 text-white m-0 font-profile">
                            <?= htmlspecialchars(substr($hr_data["firstname"], 0,1) . substr($hr_data["lastname"], 0,1)) ?>
                        </strong>
                    </div>
                    <?php }else{ ?>
                    <img src="../../authentication/uploads/<?= $hr_data["profile_picture"] ?>"
                        style="width: 150px; height: auto; border-radius: 50%;">
                    <?php } ?>
                    <span id="employeeID"
                        class="text-muted fw-bold font-15"><?= 'EMP-' . htmlspecialchars($hr_data["employeeID"]) ?></span>
                    <span class="font-15 text-center"
                        id="employeeName"><?= htmlspecialchars($hr_data["firstname"]) . " " .  substr(htmlspecialchars($hr_data["middlename"]), 0, 1) . ". " . htmlspecialchars($hr_data["lastname"]) ?></span>
                    <span class="text-center font-15"
                        id="employeeDept"><?= htmlspecialchars($hr_data["Department_name"]) ?></span>
                    <span
                        class="text-center font-15"><?= isset($hr_data["unit_section_name"]) ? ' (' . htmlspecialchars($hr_data["unit_section_name"]) . ')' : '' ?></span>
                    <span class="text-center font-15"
                        id="employeeJobTitle"><?= htmlspecialchars($hr_data["jobTitle"]) ?></span>
                    <span id="employeeSchedule" class="fw-bold"></span>
                    <form class="form_select d-flex align-items-center" id="formSelect">
                        <input type="hidden" name="user_id" value="<?= $hr_data["user_id"] ?>">
                        <?php if($hr_data["status"] == "Active"){ ?>
                        <i class="fa-solid fa-circle font-8 text-success me-1"></i>
                        <?php }else if($hr_data["status"] == "Inactive"){ ?>
                        <i class="fa-solid fa-circle font-8 text-danger me-1"></i>
                        <?php }else{ ?>
                        <i class="fa-solid fa-circle font-8 text-warning me-1"></i>
                        <?php } ?>
                        <select name="status" class="form-select select_status font-15">
                            <option value="">Select Employee Status</option>
                            <option value="Active" <?= ($hr_data["status"] == "Active") ? "selected" : "" ?>>Active
                            </option>
                            <option value="Inactive" <?= ($hr_data["status"] == "Inactive") ? "selected" : "" ?>>
                                Inactive</option>
                        </select>
                    </form>
                    <a class="font-15 mt-2" href="index.php?page=contents/pds&user_id=<?= $hr_idd ?>"
                        class="mt-2"><strong>View
                            Personal Data Sheet <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i></strong></a>
                </div>
            </div>
        </div>

        <!-- PERSONAL INFORMATION TAB -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-9 height tab-pane fade show active" role="tabpanel"
            id="Personal">
            <form id="profile_update">
                <div class="card rounded-2 profile-contents show-scroll">
                    <input type="hidden" name="user_id" value="<?= $hr_id ?>">
                    <!-- PERSONAL INFORMATION HEADER -->
                    <div class="col-md-12 d-flex">
                        <div class="header ps-3 pt-3 col-md-5">
                            <h5 class="m-0 p-0">
                                <i class="fa-solid fa-circle-info me-2"></i>Personal Information
                            </h5>
                        </div>
                        <?php if($hr_data["status"] == 'Active'){ ?>
                        <div class="col-md-7 d-flex justify-content-end me-5">
                            <button type="submit" class="btn btn-sm btn-danger px-3 mt-3 me-5"><i
                                    class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                        </div>
                        <?php } else {} ?>
                    </div>

                    <!-- PERSONAL INFORMATION CONTENTS -->
                    <div class="row flex-wrap col-md-12 col-12 p-3">
                        <div class="col-md-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="firstname" class="form-control"
                                value="<?= htmlspecialchars($hr_data["firstname"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middlename" class="form-control"
                                value="<?= htmlspecialchars($hr_data["middlename"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control"
                                value="<?= htmlspecialchars($hr_data["lastname"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Suffix</label>
                            <select class="form-select" name="suffix">
                                <option value="" <?= empty($hr_data["suffix"] ?? '') ? 'selected' : '' ?>>Select
                                    suffix (optional)</option>
                                <option value="Jr" <?= ($hr_data["suffix"] ?? '') == 'Jr' ? 'selected' : '' ?>>Jr
                                </option>
                                <option value="Sr" <?= ($hr_data["suffix"] ?? '') == 'Sr' ? 'selected' : '' ?>>Sr
                                </option>
                                <option value="II" <?= ($hr_data["suffix"] ?? '') == 'II' ? 'selected' : '' ?>>II
                                </option>
                                <option value="III" <?= ($hr_data["suffix"] ?? '') == 'III' ? 'selected' : '' ?>>
                                    III
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Citizenship</label>
                            <input type="text" name="citizenship" class="form-control"
                                value="<?= htmlspecialchars($hr_data["citizenship"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="">Select Gender</option>
                                <option value="MALE" <?= ($hr_data["gender"] ?? '') == 'MALE' ? 'selected' : '' ?>>
                                    Male</option>
                                <option value="FEMALE" <?= ($hr_data["gender"] ?? '') == 'FEMALE' ? 'selected' : '' ?>>
                                    Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Civil Status</label>
                            <select name="civil_status" id="civil_status" class="form-select">
                                <option value="">Select Civil Status</option>
                                <option value="Single"
                                    <?= ($hr_data["civil_status"] ?? '') == 'Single' ? 'selected' : '' ?>>Single
                                </option>
                                <option value="Married"
                                    <?= ($hr_data["civil_status"] ?? '') == 'Married' ? 'selected' : '' ?>>Married
                                </option>
                                <option value="Widowed"
                                    <?= ($hr_data["civil_status"] ?? '') == 'Widowed' ? 'selected' : '' ?>>Widowed
                                </option>
                                <option value="Separated"
                                    <?= ($hr_data["civil_status"] ?? '') == 'Separated' ? 'selected' : '' ?>>
                                    Separated</option>
                                <option value="Divorced"
                                    <?= ($hr_data["civil_status"] ?? '') == 'Divorced' ? 'selected' : '' ?>>
                                    Divorced
                                </option>
                                <option value="Annulled"
                                    <?= ($hr_data["civil_status"] ?? '') == 'Annulled' ? 'selected' : '' ?>>
                                    Annulled
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Religion</label>
                            <select name="religion" id="religion" class="form-select">
                                <option value="">Select Religion</option>
                                <option value="Roman Catholic"
                                    <?= ($hr_data["religion"] ?? '') == 'Roman Catholic' ? 'selected' : '' ?>>Roman
                                    Catholic</option>
                                <option value="Islam" <?= ($hr_data["religion"] ?? '') == 'Islam' ? 'selected' : '' ?>>
                                    Islam</option>
                                <option value="Iglesia ni Cristo"
                                    <?= ($hr_data["religion"] ?? '') == 'Iglesia ni Cristo' ? 'selected' : '' ?>>
                                    Iglesia ni Cristo</option>
                                <option value="Protestant"
                                    <?= ($hr_data["religion"] ?? '') == 'Protestant' ? 'selected' : '' ?>>
                                    Protestant
                                </option>
                                <option value="Born Again Christian"
                                    <?= ($hr_data["religion"] ?? '') == 'Born Again Christian' ? 'selected' : '' ?>>
                                    Born Again Christian</option>
                                <option value="Seventh-day Adventist"
                                    <?= ($hr_data["religion"] ?? '') == 'Seventh-day Adventist' ? 'selected' : '' ?>>
                                    Seventh-day Adventist</option>
                                <option value="Buddhist"
                                    <?= ($hr_data["religion"] ?? '') == 'Buddhist' ? 'selected' : '' ?>>Buddhist
                                </option>
                                <option value="Jehovah's Witness"
                                    <?= ($hr_data["religion"] ?? '') == 'Jehovah\'s Witness' ? 'selected' : '' ?>>
                                    Jehovah's Witness</option>
                                <option value="Mormon"
                                    <?= ($hr_data["religion"] ?? '') == 'Mormon' ? 'selected' : '' ?>>Mormon
                                </option>
                                <option value="Aglipayan"
                                    <?= ($hr_data["religion"] ?? '') == 'Aglipayan' ? 'selected' : '' ?>>Aglipayan
                                </option>
                                <option value="None" <?= ($hr_data["religion"] ?? '') == 'None' ? 'selected' : '' ?>>
                                    None</option>
                                <option value="Others"
                                    <?= ($hr_data["religion"] ?? '') == 'Others' ? 'selected' : '' ?>>Others
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Birthday</label>
                            <?php
                                $birthday = $hr_data["birthday"] ?? '';
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
                            <input type="text" readonly name="age" id="age" class="form-control"
                                value="<?= htmlspecialchars($hr_data["age"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Birth Place</label>
                            <input type="text" name="birthPlace" id="birthPlace" class="form-control"
                                value="<?= htmlspecialchars($hr_data["birthPlace"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact" id="contact" class="form-control"
                                value="<?= htmlspecialchars($hr_data["contact"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="<?= htmlspecialchars($hr_data["email"] ?? '') ?>">
                        </div>
                    </div>
                    <!-- OTHERS INFORMATION -->
                    <div class="header ps-3 pt-3">
                        <h5 class="m-0 p-0">
                            <i class="fa-solid fa-circle-info me-2"></i>Other Information <span
                                class="fw-light">(optional)</span>
                        </h5>
                    </div>
                    <div class="row flex-wrap col-md-12 col-12 p-3 h-auto">
                        <div class="col-md-4">
                            <label class="form-label">Profession Title</label>
                            <select name="profession_title" class="form-select">
                                <option value="">Select Profession Title</option>
                                <option value="Dr." <?= ($hr_data["profession_title"] == "Dr.") ? 'selected' : '' ?>>Dr.
                                </option>
                                <option value="Prof."
                                    <?= ($hr_data["profession_title"] == "Prof.") ? 'selected' : '' ?>>Prof.
                                </option>
                                <option value="Assoc. Prof."
                                    <?= ($hr_data["profession_title"] == "Assoc. Prof.") ? 'selected' : '' ?>>
                                    Assoc.
                                    Prof.</option>
                                <option value="Asst. Prof."
                                    <?= ($hr_data["profession_title"] == "Asst. Prof.") ? 'selected' : '' ?>>Asst.
                                    Prof.</option>
                                <option value="RN." <?= ($hr_data["profession_title"] == "RN.") ? 'selected' : '' ?>>RN.
                                </option>
                                <option value="Mr." <?= ($hr_data["profession_title"] == "Mr.") ? 'selected' : '' ?>>Mr.
                                </option>
                                <option value="Ms." <?= ($hr_data["profession_title"] == "Ms.") ? 'selected' : '' ?>>Ms.
                                </option>
                                <option value="Mrs." <?= ($hr_data["profession_title"] == "Mrs.") ? 'selected' : '' ?>>
                                    Mrs.</option>
                            </select>

                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Degree</label>
                            <input type="text" name="degrees" id="degrees" class="form-control"
                                value="<?= htmlspecialchars($hr_data["degrees"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Certifications</label>
                            <input type="text" name="fellowship" id="fellowship" class="form-control"
                                value="<?= htmlspecialchars($hr_data["fellowship"] ?? '') ?>">
                        </div>
                    </div>
                    <!-- ADDRESS INFORMATION HEADER -->
                    <div class="header ps-3 pt-3">
                        <h5 class="m-0 p-0">
                            <i class="fa-solid fa-circle-info me-2"></i>Address Information
                        </h5>
                    </div>
                    <!-- ADDRESS INFORMATION CONTENTS -->
                    <div class="row flex-wrap col-md-12 col-12 p-3 h-auto pb-5">
                        <div class="col-md-3">
                            <label class="form-label">House/Block No.</label>
                            <input type="text" name="houseBlock" id="houseBlock" class="form-control"
                                value="<?= htmlspecialchars($hr_data["houseBlock"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Street</label>
                            <input type="text" name="street" id="street" class="form-control"
                                value="<?= htmlspecialchars($hr_data["street"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Subdivision</label>
                            <input type="text" name="subdivision" id="subdivision" class="form-control"
                                value="<?= htmlspecialchars($hr_data["subdivision"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Barangay</label>
                            <input type="text" name="barangay" id="barangay" class="form-control"
                                value="<?= htmlspecialchars($hr_data["barangay"] ?? '') ?>">
                        </div>
                        <div class="col-md-3" style="z-index: 2 !important;">
                            <label class="form-label">City/Municipality</label>
                            <input type="text" name="city_muntinlupa" id="city_muntinlupa" class="form-control"
                                value="<?= htmlspecialchars($hr_data["city_muntinlupa"] ?? '') ?>">
                        </div>
                        <div class="col-md-3" style="z-index: 2 !important;">
                            <label class="form-label">Province</label>
                            <input type="text" name="province" id="province" class="form-control"
                                value="<?= htmlspecialchars($hr_data["province"] ?? '') ?>">
                        </div>
                        <div class="col-md-3" style="z-index: 2 !important;">
                            <label class="form-label">Zip Code</label>
                            <input type="text" name="zip_code" id="zip_code" class="form-control"
                                value="<?= htmlspecialchars($hr_data["zip_code"] ?? '') ?>">
                        </div>
                        <?php if($hr_data["status"] == 'Active'){ ?>
                        <div class="col-md-12 d-flex justify-content-end pb-5">
                            <button type="submit" class="btn btn-sm btn-danger px-3 btn-sm mt-3 me-2"><i
                                    class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                        </div>
                        <?php } else {} ?>
                    </div>
                </div>
            </form>
        </div>
        <!-- WORK INFORMATIONS TAB -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-9 height tab-pane fade" role="tabpanel" id="Employment">
            <div
                class="card rounded-2 align-items-center justify-content-start ps-0 pe-0 profile-contents pb-5 p-0 show-scroll">
                <div class="row flex-wrap col-md-12 col-12 p-1 px-3">
                    <form id="employment_update" class="p-0 col-md-12">
                        <input type="hidden" name="admin_update" value="false">
                        <div class="col-md-12 d-flex">
                            <div class="header pt-3 col-md-5">
                                <h5 class="m-0 p-0">
                                    <i class="fa-solid fa-circle-info me-2"></i>Employment Information
                                </h5>
                            </div>
                            <?php if($hr_data["status"] == 'Active'){ ?>
                            <div class="col-md-7 d-flex justify-content-end me-5">
                                <button type="submit" class="btn btn-sm btn-danger px-3 mt-3 me-5"><i
                                        class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                            </div>
                            <?php } else {} ?>
                        </div>
                        <div class="col-md-12 row">
                            <input type="hidden" name="user_id" value="<?= $hr_id ?>">
                            <div class="col-md-4">
                                <label class="form-label">Employee ID</label>
                                <input readonly type="text" name="employeeID" value="<?= $hr_data["employeeID"] ?>"
                                    id="employeeID_field" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">EMPLOYEE TYPE</label>
                                <select name="employee_type" disabled class="form-select">
                                    <option value="head"
                                        <?= ($hr_data['employee_type'] == 'head') ? 'selected' : '' ?>>
                                        head
                                    </option>

                                    <option value="regular"
                                        <?= ($hr_data['employee_type'] == 'regular') ? 'selected' : '' ?>>
                                        regular
                                    </option>

                                    <option value="probationary"
                                        <?= ($hr_data['employee_type'] == 'probationary') ? 'selected' : '' ?>>
                                        probationary
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Joined at</label>
                                <input type="text" name="joined_at" value="<?= $hr_data["joined_at"] ?>"
                                    id="joined_at_field" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Department</label>
                                <select name="Department_id" class="form-select">
                                    <option value="">Select Department</option>
                                    <?php foreach($getDedpartments as $departments): ?>
                                    <option value="<?= $departments['Department_id'] ?>"
                                        <?= ($departments['Department_id'] == $hr_data['Department_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($departments['Department_name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Designation</label>
                                <select disabled name="jobTitles_id" class="form-select">
                                    <option value="">Select Designation</option>
                                    <?php foreach($getDesignations as $jb): ?>
                                    <option value="<?= $jb['jobTitles_id'] ?>"
                                        <?= ($jb['jobTitles_id'] == $hr_data['jobTitles_id']) ? 'selected' : '' ?>>
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
                                        <?= ($uniSec['unit_section_id'] == $hr_data['unit_section_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($uniSec['unit_section_name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Salary</label>
                                <input type="number" readonly step="0.01" name="salary"
                                    value="<?= $hr_data["salary"] ?>" id="salary" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row flex-wrap col-md-12 col-12 p-1 px-3">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="header pt-3 col-md-7">
                            <h5 class="m-0 p-0">
                                <i class="fa-solid fa-circle-info me-2"></i>Employment History
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end">
                        <button class="btn btn-danger btn-sm px-3 py-2" data-bs-toggle="modal"
                            data-bs-target="#manageCareerPath" onclick="getEmploymentData(
                                <?= $hr_idd ?>,
                                '<?= addslashes($hr_data['jobTitle']) ?>',
                                '<?= $hr_data['salary'] ?>'
                            )"><i class="fa-solid fa-pen-to-square me-2"></i>Manage
                            Career Path</button>
                    </div>
                    <div class="responsive-table mt-1">
                        <table class="table table-responsive table-sm table-bordered text-center table-hover">
                            <thead class="table-light">
                                <tr>
                                    <td>From Position</td>
                                    <td>To Position</td>
                                    <td>Type</td>
                                    <td>Date</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($employeeCareerPath){ 
                                        foreach($employeeCareerPath as $career) : ?>
                                <tr>
                                    <td><?= $career["job_from"] ?></td>
                                    <td><?= $career["job_to"] ?></td>
                                    <td><?= $career["job_status"] ?></td>
                                    <td><?= date('M d Y', strtotime($career["addAt"])) ?></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm m-0 my-2 mx-3"><i
                                                class="fa-solid fa-print me-2"></i>Print</button>
                                    </td>
                                </tr>
                                <?php endforeach; 
                                    }else{ ?>
                                <tr>
                                    <td>Initial Position</td>
                                    <td><?= $hr_data["jobTitle"] ?></td>
                                    <td>Current</td>
                                    <td><?= $hr_data["joined_at"] ?></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm m-0 my-2 mx-3"><i
                                                class="fa-solid fa-print me-2"></i>Print</button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
        <!-- Leave Credits Tab -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-9 height tab-pane fade" role="tabpanel" id="Leave_Credits">
            <form id="leave_update">
                <input type="hidden" name="user_id" value="<?= $hr_id ?>">
                <div class="header pt-3 col-md-5">
                    <h5 class="m-0 p-0">
                        <i class="fa-solid fa-circle-info me-2"></i>Leave Credits
                    </h5>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Sick Leave</label>
                        <input type="number" name="SickBalance" value="<?= $hr_data["SickBalance"] ?? '' ?>"
                            id="SickBalance" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Vacation Leave</label>
                        <input type="number" name="VacationBalance" value="<?= $hr_data["VacationBalance"] ?? '' ?>"
                            id="VacationBalance" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Special Leave</label>
                        <input type="number" name="SpecialBalance" value="<?= $hr_data["SpecialBalance"] ?? '' ?>"
                            id="SpecialBalance" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Others</label>
                        <input type="number" name="OthersBalance" id="OthersBalance"
                            value="<?= $hr_data["OthersBalance"] ?? '' ?>" class="form-control">
                    </div>
                </div>

                <?php if($hr_data["status"] == 'Active'){ ?>
                <div class="col-md-12 d-flex mt-3 justify-content-end me-0">
                    <button type="submit" class="btn  btn-danger px-3 mt-3 me-2 btn-sm"><i
                            class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                </div>
                <?php } else {} ?>
            </form>
        </div>
        <!-- EDUCATIONAL BACKGROUND TAB -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-9 height tab-pane fade" role="tabpanel" id="Education">
            <form id="educational_update" class="profile-contents show-scroll">
                <input type="hidden" name="user_id" value="<?= $hr_id ?>">
                <div class="card rounded-2 show-scroll">
                    <!-- EDUCATIONAL INFORMATION HEADER -->
                    <div class="col-md-12 d-flex">
                        <div class="header ps-3 pt-3 col-md-5">
                            <h5 class="m-0 p-0">
                                <i class="fa-solid fa-circle-info me-2"></i>Educational Background
                            </h5>
                        </div>
                        <?php if($hr_data["status"] == 'Active'){ ?>
                        <div class="col-md-7 d-flex justify-content-end me-5">
                            <button type="submit" class="btn btn-sm btn-danger px-3 mt-3 me-5"><i
                                    class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                        </div>
                        <?php } else {} ?>
                    </div>
                    <?php
                        // Fetch educational data for each level
                        $educationLevels = ['Elementary', 'High_school', 'Senior_high', 'College', 'Graduate'];
                        $educationData = [];
                        
                        foreach($educationLevels as $level) {
                            $stmt = $pdo->prepare("SELECT * FROM educational_data WHERE user_id = ? AND education_level = ?");
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
                    <?php if($hr_data["status"] == 'Active'){ ?>
                    <div class="transform col-md-12 col-12 d-flex justify-content-end pe-4 mt-3 mb-2">
                        <button type="submit" class="btn btn-danger px-5 mt-4"><i
                                class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                    </div>
                    <?php } else {} ?>
                </div>
            </form>
        </div>
        <!-- FAMILY BACKGROUND TAB -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-9 height tab-pane fade" role="tabpanel" id="Family">
            <form id="family_update">
                <input type="hidden" name="user_id" value="<?= $hr_id ?>">
                <div class="card rounded-2 profile-contents show-scroll">
                    <!-- FAMILY INFORMATION HEADER -->
                    <div class="col-md-12 d-flex">
                        <div class="header ps-3 pt-3 col-md-5">
                            <h5 class="m-0 p-0">
                                <i class="fa-solid fa-circle-info me-2"></i>Family Information
                            </h5>
                        </div>
                        <?php if($hr_data["status"] == 'Active'){ ?>
                        <div class="col-md-7 d-flex justify-content-end me-5">
                            <button type="submit" class="btn btn-sm btn-danger px-3 mt-3 me-5"><i
                                    class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                        </div>
                        <?php } ?>
                    </div>
                    <?php
                        $stmtFather = $pdo->prepare("SELECT * FROM Family_data WHERE user_id = '$hr_id' AND Relationship = 'Father'");
                        $stmtFather->execute();
                        $father = $stmtFather->fetch(PDO::FETCH_ASSOC);        
                    
                        $stmtMother = $pdo->prepare("SELECT * FROM Family_data WHERE user_id = '$hr_id' AND Relationship = 'Mother'");
                        $stmtMother->execute();
                        $mother = $stmtMother->fetch(PDO::FETCH_ASSOC);   

                        $stmtGuardian = $pdo->prepare("SELECT * FROM Family_data WHERE user_id = '$hr_id' AND Relationship = 'Guardian'");
                        $stmtGuardian->execute();
                        $guardian = $stmtGuardian->fetch(PDO::FETCH_ASSOC);  
                        
                        $stmtSpouse = $pdo->prepare("SELECT * FROM Family_data WHERE user_id = '$hr_id' AND Relationship = 'Spouse'");
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
                    <?php if($hr_data["status"] == 'Active'){ ?>
                    <div class="col-md-12 d-flex justify-content-end me-5 mb-5">
                        <button type="submit" class="btn btn-sm btn-danger px-3 mt-3 me-5"><i
                                class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                    </div>
                    <?php } ?>
                </div>
            </form>
        </div>
        <!-- Activity tracking -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-9 height tab-pane fade" role="tabpanel" id="Leave">
            <div class="card rounded-2 profile-contents show-scroll">
                <!-- FAMILY INFORMATION HEADER -->
                <div class="header ps-3 pt-3">
                    <h5 class="m-0 p-0">
                        <i class="fa-solid fa-circle-info me-2"></i>Activity Tracking
                    </h5>
                </div>
                <!-- FAMILY INFORMATION CONTENTS -->
                <div class="row flex-wrap col-md-12 col-12 p-3">
                    <?php
                        $stmtActivities = $pdo->prepare("SELECT * FROM activities WHERE user_id = '$hr_id' ORDER BY activity_at DESC");
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
                                    <th class="fw-light"><span><?= htmlspecialchars($act["activity_type"]) ?></span>
                                    </th>
                                    <th class="fw-light">
                                        <span><?= date("F j, Y g:i A", strtotime($act["activity_at"])) ?></span>
                                    </th>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- LOGIN HISTORY TAB -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-9 height tab-pane fade" role="tabpanel" id="history">
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
                            $stmtHistory = $pdo->prepare("SELECT * FROM login_history WHERE user_id = ? ORDER BY login_time DESC");
                            $stmtHistory->execute([$hr_id]);
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
</section>
<!-- =================================== MODALS =================================== -->
<!-- CHANGE PASSWORD MODAL -->
<div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="changePass_form" class="modal-content">
            <input type="hidden" name="admin_id" value="<?= $hr_id ?>">
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
<!-- Career Path Modal -->
<div class="modal fade" id="manageCareerPath" tabindex="-1" aria-labelledby="manageCareerPathLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="career-path-form">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title text-white" id="manageCareerPathLabel">Manage Employee Career Path</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" name="user_id" id="user_id_careerPath">
                <div class="mx-2">
                    <label class="form-label">Current Designation</label>
                    <input class="form-control" readonly type="text" name="job_from" id="currentDesignationId">
                </div>
                <div class="mx-2">
                    <label class="form-label">Current Salary</label>
                    <input class="form-control" readonly type="text" name="current_salary" id="currentSalaryId">
                </div>
                <div class="mx-2">
                    <label class="form-label">New Designation</label>
                    <select name="jobTitles_id" id="newDesignationIdToggle" class="form-select">
                        <option value="">Select Job Title</option>
                        <?php foreach($getDesignations as $jb): ?>
                        <option value="<?= $jb['jobTitles_id'] ?>">
                            <?= htmlspecialchars($jb['jobTitle']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mx-2">
                    <label class="form-label">New salary</label>
                    <input class="form-control" readonly type="text" name="new_salary">
                </div>
                <div class="mx-2">
                    <label class="form-label">Manage Type</label>
                    <select name="job_status" class="form-select">
                        <option value="">Select Type</option>
                        <option value="Update">Update</option>
                        <option value="Promote">Promote</option>
                        <option value="Demote">Demote</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Confirm</button>
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
<script src="../../assets/js/hr_js/admin/setting.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jobTitleSelect = document.getElementById('newDesignationIdToggle');
    const salaryInput = document.querySelector('input[name="new_salary"]');

    if (!jobTitleSelect || !salaryInput) return;

    let jobSalaries = {};

    function loadJobSalaries() {
        <?php
            $jobSalaries = [];
            foreach($getDesignations as $jb) {
                $jobSalaries[$jb['jobTitles_id']] = $jb['salary'];
            }
            ?>

        jobSalaries = <?php echo json_encode($jobSalaries); ?>;
    }

    loadJobSalaries();

    jobTitleSelect.addEventListener('change', function() {
        const selectedJobId = this.value;

        if (selectedJobId && jobSalaries[selectedJobId]) {
            const salary = jobSalaries[selectedJobId];
            salaryInput.value = formatCurrency(salary);
        } else {
            ed
            salaryInput.value = '';
        }
    });

    function formatCurrency(amount) {
        const numAmount = parseFloat(amount);

        return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(numAmount);
    }

    if (jobTitleSelect.value) {
        jobTitleSelect.dispatchEvent(new Event('change'));
    }
});
</script>