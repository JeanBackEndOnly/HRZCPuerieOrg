<?php
   // Fetch Active Employees
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
        u.profile_picture
    FROM users u
    INNER JOIN employee_data ed ON u.user_id = ed.user_id
    LEFT JOIN jobTitles jt ON ed.jobtitle_id = jt.jobTitles_id
    LEFT JOIN departments d ON ed.Department_id = d.Department_id
    WHERE u.status = 'Active' AND u.user_role = 'EMPLOYEE'
    ORDER BY u.lastname, u.firstname
");
$stmtOfficial->execute();
$officialEmployees = $stmtOfficial->fetchAll(PDO::FETCH_ASSOC);

$stmtApplicants = $pdo->prepare("
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
        u.profile_picture
    FROM users u
    INNER JOIN employee_data ed ON u.user_id = ed.user_id
    LEFT JOIN jobTitles jt ON ed.jobtitle_id = jt.jobTitles_id
    LEFT JOIN departments d ON ed.Department_id = d.Department_id
    WHERE u.status = 'Pending' AND u.user_role = 'EMPLOYEE'
    ORDER BY u.lastname, u.firstname
");
$stmtApplicants->execute();
$Applicants = $stmtApplicants->fetchAll(PDO::FETCH_ASSOC);

$countOfficials = 1;
?>
<section>
    <div class="d-flex justify-content-between align-items-center mb-2 col-md-12 col-12 flex-wrap">
        <div class=" col-md-6 col-12">
            <h4 class=""><i class="fa-solid fa-users me-2"></i>201 Management</h4>
            <small class="text-muted ">Create, Update And view employee 201 files</small>
        </div>
        <div class="col-md-4">
            <input type="text" id="searchEmployee" placeholder="Search employees by name or ID....."
                class="form-control">
        </div>

    </div>
    <div class="card">
        <div class="card-body col-md-12 col-12 d-flex justify-content-between">
            <ul class="nav nav-tabs col-md-12 col-12" id="twoZeroOneIni">
                <li class="nav-item cursor-pointer col-md-3">
                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#Officials"><i
                            class="fa-solid me-2 fa-building"></i>Official EMployees</a>
                </li>
                <li class="nav-item cursor-pointer col-md-3">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Applicants"><i
                            class="fa-solid me-2 fa-user-doctor"></i>Applicants</a>
                </li>
            </ul>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">
                <!-- departments -->
                <div class="tab-pane fade show active" id="Officials" role="tabpanel">
                    <!-- EMPLOYEE ACCOUNT DISPLAYS =============================================================================================== -->

                    <div class="row col-md-12">
                        <?php 
                            if($officialEmployees){
                                foreach ($officialEmployees as $officials) : ?>
                        <a href="index.php?page=contents/files&id=<?= htmlspecialchars($officials["user_id"]) ?>"
                            class="col-md-4">
                            <div class="card col-md-12 d-flex flex-row shadow p-2 rounded-3 border">
                                <div class="col-md-2 d-flex align-items-center">
                                    <?php if($officials["profile_picture"] == null){ ?>
                                    <div
                                        class="recruitment-profile-circle d-flex justify-content-center justify-content-center">
                                        <strong
                                            class=" text-white text-center d-flex align-items-center justify-content-center">
                                            <?= htmlspecialchars(strtoupper(substr($officials["firstname"], 0,1) . substr($officials["lastname"], 0,1))) ?>
                                        </strong>
                                    </div>
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
                        <?php 
                                endforeach; 
                                    }else {
                                        echo '<tr><td colspan="6" class="text-center">No employees found</td></tr>';
                                    }  
                                ?>
                    </div>

                </div>
                <div class="tab-pane fade" id="Applicants" role="tabpanel">
                    <!-- EMPLOYEE ACCOUNT DISPLAYS =============================================================================================== -->

                    <div class="row col-md-12">
                        <?php 
                            if($Applicants){
                                foreach ($Applicants as $app) : ?>
                        <a href="index.php?page=contents/files&id=<?= htmlspecialchars($app["user_id"]) ?>"
                            class="col-md-4">
                            <div class="card col-md-12 d-flex flex-row shadow p-2 rounded-3 border">
                                <div class="col-md-2 d-flex align-items-center">
                                    <?php if($app["profile_picture"] == null){ ?>
                                    <div
                                        class="recruitment-profile-circle d-flex justify-content-center justify-content-center">
                                        <strong
                                            class=" text-white text-center d-flex align-items-center justify-content-center">
                                            <?= htmlspecialchars(strtoupper(substr($app["firstname"], 0,1) . substr($app["lastname"], 0,1))) ?>
                                        </strong>
                                    </div>
                                    <?php }else{ ?>
                                    <img src="../../authentication/uploads/<?= $app["profile_picture"] ?>"
                                        style="width: 200px; height: auto; border-radius: 50%;">
                                    <?php } ?>
                                </div>
                                <div class="col-md-10 d-flex flex-column">
                                    <strong
                                        class="font-13"><?= htmlspecialchars($app["firstname"] . ' ' . substr($app["middlename"], 0, 1) . '. ' . $app["lastname"]) ?></strong>
                                    <span
                                        class="font-12"><?= htmlspecialchars($app["jobTitle"] . ' •' . $app["department"]) . ' •EMP-' . $app["employeeID"] ?></span>
                                </div>
                            </div>
                        </a>
                        <?php 
                                endforeach; 
                                    }else {
                                        echo '<strong class="w-100 text-center">No employees found</strong>';
                                    }  
                                ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script src="../../assets/js/hr_js/hr/201.js"></script>