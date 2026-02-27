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
                <li class="nav-item cursor-pointer col-md-3 col-12">
                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#Personal">
                        <i class="fa-solid fa-circle-info me-2"></i> Personal Information
                    </a>
                </li>
                <li class="nav-item cursor-pointer col-md-3 col-12">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Employment">
                        <i class="fa-solid fa-circle-info me-2"></i> Employement
                    </a>
                </li>
                <li class="nav-item cursor-pointer col-md-3 col-12">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#hrEmployees">
                        <i class="fa-solid fa-circle-info me-2"></i> HRMS Activation
                    </a>
                </li>
                <li class="nav-item cursor-pointer col-md-3 col-12">
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
                    <?php if($getAdminData["profile_picture"] == null){ ?>
                    <div class="profile-circle d-flex align-items-center justify-content-center mb-1">
                        <strong class="p-0 text-white m-0 font-profile">
                            <?= htmlspecialchars(substr($getAdminData["firstname"], 0,1) . substr($getAdminData["lastname"], 0,1)) ?>
                        </strong>
                    </div>
                    <?php }else{ ?>
                    <img src="../../authentication/uploads/<?= $getAdminData["profile_picture"] ?>"
                        style="width: 150px; height: auto; border-radius: 50%;">
                    <?php } ?>
                    <span id="employeeID"
                        class="text-muted fw-bold font-15"><?= 'EMP-' . htmlspecialchars($getAdminData["employeeID"]) ?></span>
                    <span class="font-15 text-center"
                        id="employeeName"><?= htmlspecialchars($getAdminData["firstname"]) . " " .  substr(htmlspecialchars($getAdminData["middlename"]), 0, 1) . ". " . htmlspecialchars($getAdminData["lastname"]) ?></span>
                    <span class="text-center font-15"
                        id="employeeDept"><?= htmlspecialchars($getAdminData["Department_name"]) ?></span>
                    <span
                        class="text-center font-15"><?= isset($getAdminData["unit_section_name"]) ? ' (' . htmlspecialchars($getAdminData["unit_section_name"]) . ')' : '' ?></span>
                    <span class="text-center font-15"
                        id="employeeJobTitle"><?= htmlspecialchars($getAdminData["jobTitle"]) ?></span>
                    <span id="employeeSchedule" class="fw-bold"></span>
                    <form class="form_select d-flex align-items-center" id="formSelect">
                        <input type="hidden" name="user_id" value="<?= $getAdminData["user_id"] ?>">
                        <?php if($getAdminData["status"] == "Active"){ ?>
                        <i class="fa-solid fa-circle font-8 text-success me-1"></i>
                        <?php }else if($getAdminData["status"] == "Inactive"){ ?>
                        <i class="fa-solid fa-circle font-8 text-danger me-1"></i>
                        <?php }else{ ?>
                        <i class="fa-solid fa-circle font-8 text-warning me-1"></i>
                        <?php } ?>
                        <select name="status" class="form-select select_status font-15">
                            <option value="">Select Employee Status</option>
                            <option value="Active" <?= ($getAdminData["status"] == "Active") ? "selected" : "" ?>>Active
                            </option>
                            <option value="Inactive" <?= ($getAdminData["status"] == "Inactive") ? "selected" : "" ?>>
                                Inactive</option>
                        </select>
                    </form>
                    <a class="font-15 mt-2" href="index.php?page=contents/pds&user_id=<?= $user_id ?>"
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
                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                    <!-- PERSONAL INFORMATION HEADER -->
                    <div class="col-md-12 d-flex">
                        <div class="header ps-3 pt-3 col-md-5">
                            <h5 class="m-0 p-0">
                                <i class="fa-solid fa-circle-info me-2"></i>Personal Information
                            </h5>
                        </div>
                        <?php if($getAdminData["status"] == 'Active'){ ?>
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
                                value="<?= htmlspecialchars($getAdminData["firstname"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middlename" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["middlename"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["lastname"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Suffix</label>
                            <select class="form-select" name="suffix">
                                <option value="" <?= empty($getAdminData["suffix"] ?? '') ? 'selected' : '' ?>>Select
                                    suffix (optional)</option>
                                <option value="Jr" <?= ($getAdminData["suffix"] ?? '') == 'Jr' ? 'selected' : '' ?>>Jr
                                </option>
                                <option value="Sr" <?= ($getAdminData["suffix"] ?? '') == 'Sr' ? 'selected' : '' ?>>Sr
                                </option>
                                <option value="II" <?= ($getAdminData["suffix"] ?? '') == 'II' ? 'selected' : '' ?>>II
                                </option>
                                <option value="III" <?= ($getAdminData["suffix"] ?? '') == 'III' ? 'selected' : '' ?>>
                                    III
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Citizenship</label>
                            <input type="text" name="citizenship" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["citizenship"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="">Select Gender</option>
                                <option value="MALE" <?= ($getAdminData["gender"] ?? '') == 'MALE' ? 'selected' : '' ?>>
                                    Male</option>
                                <option value="FEMALE"
                                    <?= ($getAdminData["gender"] ?? '') == 'FEMALE' ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Civil Status</label>
                            <select name="civil_status" id="civil_status" class="form-select">
                                <option value="">Select Civil Status</option>
                                <option value="Single"
                                    <?= ($getAdminData["civil_status"] ?? '') == 'Single' ? 'selected' : '' ?>>Single
                                </option>
                                <option value="Married"
                                    <?= ($getAdminData["civil_status"] ?? '') == 'Married' ? 'selected' : '' ?>>Married
                                </option>
                                <option value="Widowed"
                                    <?= ($getAdminData["civil_status"] ?? '') == 'Widowed' ? 'selected' : '' ?>>Widowed
                                </option>
                                <option value="Separated"
                                    <?= ($getAdminData["civil_status"] ?? '') == 'Separated' ? 'selected' : '' ?>>
                                    Separated</option>
                                <option value="Divorced"
                                    <?= ($getAdminData["civil_status"] ?? '') == 'Divorced' ? 'selected' : '' ?>>
                                    Divorced
                                </option>
                                <option value="Annulled"
                                    <?= ($getAdminData["civil_status"] ?? '') == 'Annulled' ? 'selected' : '' ?>>
                                    Annulled
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Religion</label>
                            <select name="religion" id="religion" class="form-select">
                                <option value="">Select Religion</option>
                                <option value="Roman Catholic"
                                    <?= ($getAdminData["religion"] ?? '') == 'Roman Catholic' ? 'selected' : '' ?>>Roman
                                    Catholic</option>
                                <option value="Islam"
                                    <?= ($getAdminData["religion"] ?? '') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                <option value="Iglesia ni Cristo"
                                    <?= ($getAdminData["religion"] ?? '') == 'Iglesia ni Cristo' ? 'selected' : '' ?>>
                                    Iglesia ni Cristo</option>
                                <option value="Protestant"
                                    <?= ($getAdminData["religion"] ?? '') == 'Protestant' ? 'selected' : '' ?>>
                                    Protestant
                                </option>
                                <option value="Born Again Christian"
                                    <?= ($getAdminData["religion"] ?? '') == 'Born Again Christian' ? 'selected' : '' ?>>
                                    Born Again Christian</option>
                                <option value="Seventh-day Adventist"
                                    <?= ($getAdminData["religion"] ?? '') == 'Seventh-day Adventist' ? 'selected' : '' ?>>
                                    Seventh-day Adventist</option>
                                <option value="Buddhist"
                                    <?= ($getAdminData["religion"] ?? '') == 'Buddhist' ? 'selected' : '' ?>>Buddhist
                                </option>
                                <option value="Jehovah's Witness"
                                    <?= ($getAdminData["religion"] ?? '') == 'Jehovah\'s Witness' ? 'selected' : '' ?>>
                                    Jehovah's Witness</option>
                                <option value="Mormon"
                                    <?= ($getAdminData["religion"] ?? '') == 'Mormon' ? 'selected' : '' ?>>Mormon
                                </option>
                                <option value="Aglipayan"
                                    <?= ($getAdminData["religion"] ?? '') == 'Aglipayan' ? 'selected' : '' ?>>Aglipayan
                                </option>
                                <option value="None"
                                    <?= ($getAdminData["religion"] ?? '') == 'None' ? 'selected' : '' ?>>None</option>
                                <option value="Others"
                                    <?= ($getAdminData["religion"] ?? '') == 'Others' ? 'selected' : '' ?>>Others
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Birthday</label>
                            <?php
                                $birthday = $getAdminData["birthday"] ?? '';
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
                                value="<?= htmlspecialchars($getAdminData["age"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Birth Place</label>
                            <input type="text" name="birthPlace" id="birthPlace" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["birthPlace"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact" id="contact" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["contact"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["email"] ?? '') ?>">
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
                                <option value="Dr."
                                    <?= ($getAdminData["profession_title"] == "Dr.") ? 'selected' : '' ?>>Dr.</option>
                                <option value="Prof."
                                    <?= ($getAdminData["profession_title"] == "Prof.") ? 'selected' : '' ?>>Prof.
                                </option>
                                <option value="Assoc. Prof."
                                    <?= ($getAdminData["profession_title"] == "Assoc. Prof.") ? 'selected' : '' ?>>
                                    Assoc.
                                    Prof.</option>
                                <option value="Asst. Prof."
                                    <?= ($getAdminData["profession_title"] == "Asst. Prof.") ? 'selected' : '' ?>>Asst.
                                    Prof.</option>
                                <option value="RN."
                                    <?= ($getAdminData["profession_title"] == "RN.") ? 'selected' : '' ?>>RN.</option>
                                <option value="Mr."
                                    <?= ($getAdminData["profession_title"] == "Mr.") ? 'selected' : '' ?>>Mr.</option>
                                <option value="Ms."
                                    <?= ($getAdminData["profession_title"] == "Ms.") ? 'selected' : '' ?>>Ms.</option>
                                <option value="Mrs."
                                    <?= ($getAdminData["profession_title"] == "Mrs.") ? 'selected' : '' ?>>Mrs.</option>
                            </select>

                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Degree</label>
                            <input type="text" name="degrees" id="degrees" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["degrees"] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Certifications</label>
                            <input type="text" name="fellowship" id="fellowship" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["fellowship"] ?? '') ?>">
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
                                value="<?= htmlspecialchars($getAdminData["houseBlock"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Street</label>
                            <input type="text" name="street" id="street" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["street"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Subdivision</label>
                            <input type="text" name="subdivision" id="subdivision" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["subdivision"] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Barangay</label>
                            <input type="text" name="barangay" id="barangay" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["barangay"] ?? '') ?>">
                        </div>
                        <div class="col-md-3" style="z-index: 2 !important;">
                            <label class="form-label">City/Municipality</label>
                            <input type="text" name="city_muntinlupa" id="city_muntinlupa" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["city_muntinlupa"] ?? '') ?>">
                        </div>
                        <div class="col-md-3" style="z-index: 2 !important;">
                            <label class="form-label">Province</label>
                            <input type="text" name="province" id="province" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["province"] ?? '') ?>">
                        </div>
                        <div class="col-md-3" style="z-index: 2 !important;">
                            <label class="form-label">Zip Code</label>
                            <input type="text" name="zip_code" id="zip_code" class="form-control"
                                value="<?= htmlspecialchars($getAdminData["zip_code"] ?? '') ?>">
                        </div>
                        <?php if($getAdminData["status"] == 'Active'){ ?>
                        <div class="col-md-12 d-flex justify-content-end pb-5">
                            <button type="submit" class="btn btn-sm btn-danger px-3 btn-sm mt-3 me-2"><i
                                    class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                        </div>
                        <?php } else {} ?>
                    </div>
                </div>
            </form>
        </div>
        <!-- Employement -->
        <div class="column p-2 m-0 rounded-2 col-12 col-md-9 height tab-pane fade" role="tabpanel" id="Employment">
            <div
                class="card rounded-2 align-items-center justify-content-start ps-0 pe-0 profile-contents pb-5 p-0 show-scroll">
                <div class="row flex-wrap col-md-12 col-12 p-1 px-3">
                    <form id="employment_update" class="p-0 col-md-12">
                        <div class="col-md-12 d-flex">
                            <div class="header pt-3 col-md-5">
                                <h5 class="m-0 p-0">
                                    <i class="fa-solid fa-circle-info me-2"></i>Employment Information
                                </h5>
                            </div>
                            <?php if($getAdminData["status"] == 'Active'){ ?>
                            <div class="col-md-7 d-flex justify-content-end me-5">
                                <button type="submit" class="btn btn-sm btn-danger px-3 mt-3 me-5"><i
                                        class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                            </div>
                            <?php } else {} ?>
                        </div>
                        <div class="col-md-12 row">
                            <input type="hidden" name="user_id" value="<?= $admin_id ?>">
                            <div class="col-md-4">
                                <label class="form-label">Employee ID</label>
                                <input readonly type="text" name="employeeID" value="<?= $getAdminData["employeeID"] ?>"
                                    id="employeeID_field" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Joined at</label>
                                <input type="text" name="joined_at" value="<?= $getAdminData["joined_at"] ?>"
                                    id="joined_at_field" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Department</label>
                                <select name="Department_id" class="form-select">
                                    <option value="">Select Department</option>
                                    <?php foreach($getDedpartments as $departments): ?>
                                    <option value="<?= $departments['Department_id'] ?>"
                                        <?= ($departments['Department_id'] == $getAdminData['Department_id']) ? 'selected' : '' ?>>
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
                                        <?= ($jb['jobTitles_id'] == $getAdminData['jobTitles_id']) ? 'selected' : '' ?>>
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
                                        <?= ($uniSec['unit_section_id'] == $getAdminData['unit_section_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($uniSec['unit_section_name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Salary</label>
                                <input type="number" readonly step="0.01" name="salary"
                                    value="<?= $getAdminData["salary"] ?>" id="salary" class="form-control">
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
                                <?= $admin_id ?>,
                                '<?= addslashes($getAdminData['jobTitle'] ?? '') ?>',
                                '<?= $getAdminData['salary'] ?? '' ?>'
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
                                    <td><?= $career["jobTitle"] ?></td>
                                    <td>Current</td>
                                    <td><?= $career["joined_at"] ?></td>
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
                                u.user_id, 
                                u.firstname, 
                                u.middlename, 
                                u.lastname, 
                                u.suffix,
                                d.Department_name AS department,
                                u.employeeID,
                                jt.jobTitle,
                                jt.salary,
                                u.status,
                                u.user_role
                            FROM users u
                            INNER JOIN employee_data ed ON u.user_id = ed.user_id
                            LEFT JOIN jobTitles jt ON ed.jobtitle_id = jt.jobTitles_id
                            LEFT JOIN departments d ON ed.Department_id = d.Department_id
                            WHERE u.user_role = 'HR' || u.user_role = 'PAYROLL'
                            ORDER BY u.status
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
                                href="index.php?page=contents/profile&id=<?= htmlspecialchars($officials["user_id"]) ?>">
                                <button class="btn btn-sm btn-danger px-3 py-2 m-0">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </a>

                            <form class="form_select d-flex align-items-center">
                                <input type="hidden" name="user_id"
                                    value="<?= htmlspecialchars($officials['user_id']) ?>">
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
                            $stmtHistory = $pdo->prepare("SELECT * FROM login_history WHERE user_id = ? ORDER BY login_time DESC");
                            $stmtHistory->execute([$admin_id]);
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

        if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
            age--;
        }

        ageInput.value = age;
    }

    birthdayInput.addEventListener("change", calculateAge);

    calculateAge();
});

function getEmploymentData(user_id, designation, salary) {
    document.getElementById('user_id_careerPath').value = user_id;
    document.getElementById('currentDesignationId').value = designation;
    document.getElementById('currentSalaryId').value = salary;
}
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
            } else {ed
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