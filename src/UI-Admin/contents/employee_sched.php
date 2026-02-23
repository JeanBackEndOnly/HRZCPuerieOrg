<?php
    $employee_id = $_GET["employee_id"];
    $stmt = $pdo->prepare("SELECT us.unit_section_name, ed.firstname, ed.lastname, ed.middlename, ed.suffix, ed.profile_picture, ed.employeeID, d.Department_name, j.jobTitle FROM employee_data ed
        INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id 
        LEFT JOIN departments d ON hd.Department_id = d.Department_id 
        LEFT JOIN jobTitles j ON hd.jobtitle_id = j.jobTitles_id 
        LEFT JOIN unit_section us ON hd.unit_section_id = us.unit_section_id 
        WHERE ed.employee_id = ?");
    $stmt->execute([$employee_id]);
    $employeeData = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmtSchedule = $pdo->prepare("SELECT es.*, st.* FROM employee_schedule es
    INNER JOIN sched_template st ON es.schedule_id = st.template_id
    WHERE es.employee_id = ? AND es.schedule_at <= CURDATE()");
    $stmtSchedule->execute([$employee_id]);
    $scheduleResult = $stmtSchedule->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="d-flex justify-content-between align-items-center mb-2">
    <div class="mx-2">
        <h4 class=""><i class="fa-solid fa-calendar me-2"></i>SCHEDULE OF
            <?= htmlspecialchars($employeeData["lastname"] . ' ' . $employeeData["firstname"] . ' ' . substr($employeeData["middlename"],0,1) . '.') ?>
        </h4>
        <small class="text-muted ">Manage employee schedules</small>
    </div>
</div>
<main class="col-md-12 d-flex justify-content-start align-items-start">
    <div class="column p-2 m-0 rounded-2 col-12 col-md-4 col-12">
        <div class="card rounded-2">
            <div class="d-flex flex-column w-100 align-items-center justify-content-center p-2">
                <div class="w-100 d-flex justify-content-start ps-3 pt-1">
                    <a href="index.php?page=contents/hr_settings" class="btn btn-danger btn-sm"><i
                            class="fa-solid fa-arrow-left me-1"></i> Back</a>
                </div>
                <?php if($employeeData["profile_picture"] == null){ ?>
                <strong class="py-1 px-5 text-white mb-2" style="
                                border-radius: 50%;
                                background-color: #303030ff;
                                font-size: 5rem;
                            "><?= htmlspecialchars(substr($employeeData["firstname"], 0,1)) ?></strong>
                <?php }else{ ?>
                <img src="../../authentication/uploads/<?= $employeeData["profile_picture"] ?>"
                    style="width: 200px; height: auto; border-radius: 50%;">
                <?php } ?>
                <span id="employeeID"
                    class="text-muted fw-bold"><?= htmlspecialchars($employeeData["employeeID"]) ?></span>
                <span
                    id="employeeName"><?= htmlspecialchars($employeeData["firstname"]) . " " .  substr(htmlspecialchars($employeeData["middlename"]), 0, 1) . ". " . htmlspecialchars($employeeData["lastname"]) ?></span>
                <span class="text-center"
                    id="employeeDept"><?= htmlspecialchars($employeeData["Department_name"]) ?></span>
                <span
                    class="text-center"><?= isset($employeeData["unit_section_name"]) ? ' (' . htmlspecialchars($employeeData["unit_section_name"]) . ')' : '' ?></span>
                <span id="employeeJobTitle"><?= htmlspecialchars($employeeData["jobTitle"]) ?></span>
                <span id="employeeSchedule" class="fw-bold"></span>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-12 d-flex justify-content-start align-items-start p-2">
        <div class="card col-md-12 col-12">
            <!-- NAVIAGATIONS OF TABS -->
            <div class="card-body col-md-12 col-12 d-flex justify-content-between pb-4">
                <ul class="nav nav-tabs col-md-7 col-12" id="LeaveRequestTabs">
                    <li class="nav-item cursor-pointer col-md-6">
                        <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#active"><i
                                class="fa-solid fa-user-tie me-2"></i>Ative Schedules</a>
                    </li>
                    <li class="nav-item cursor-pointer col-md-6">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#inactive"><i
                                class="fa-solid fa-user-plus me-2"></i>Advance Schedules</a>
                    </li>
                </ul>
            </div>
            <div class="card-body pt-0 p-0">
                <div class="tab-content" id="employeesTabContent">
                    <div class="tab-pane fade show active" id="active" role="tabpanel"
                        aria-labelledby="approved-tab" tabindex="0">
                        <div class="responssive-table">
                            <table class="table table-responssive table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <td>Scheule at</td>
                                        <td>Schedule From and To</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if($scheduleResult){ 
                                        foreach($scheduleResult as $sched) :?>
                                            <tr>
                                                <td><?= htmlspecialchars($sched["schedule_at"]) ?></td>
                                                <td><?= htmlspecialchars('(' . $sched["scheduleName"] . ') '.date('h:i A', strtotime($sched["schedule_from"])) . ' - ' . date('h:i A', strtotime($sched["schedule_to"]))) ?></td>
                                                <td>
                                                    <button class="m-0 btn btn-outline-success">edit</button>
                                                    <button class="m-0 btn btn-outline-danger">delete</button>
                                                </td>
                                            </tr>
                                    <?php endforeach;
                                        }else { ?>
                                        <tr><td colspan="4" class="fw-bold">This Employee doesn't have any Schule</td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="employeesTabContent">
                    <div class="tab-pane fade" id="inactive" role="tabpanel"
                        aria-labelledby="approved-tab" tabindex="0">
                            <h1>hello Advance schedules</h1>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>