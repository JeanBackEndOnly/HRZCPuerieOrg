<?php
    $stmt = $pdo->prepare("SELECT us.unit_section_name, u.firstname, u.lastname, u.middlename, u.suffix, u.profile_picture, u.employeeID, d.Department_name, j.jobTitle
        FROM users u
        INNER JOIN employee_data ed ON u.user_id = ed.user_id 
        LEFT JOIN departments d ON ed.Department_id = d.Department_id 
        LEFT JOIN jobTitles j ON ed.jobtitle_id = j.jobTitles_id 
        LEFT JOIN unit_section us ON ed.unit_section_id = us.unit_section_id 
        WHERE u.user_id = ?");
    $stmt->execute([$user_id]);
    $employeeData = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmtSchedule = $pdo->prepare("SELECT es.*, st.* FROM employee_schedule es
    INNER JOIN sched_template st ON es.schedule_id = st.template_id
    WHERE es.user_id = ? AND es.schedule_at <= CURDATE()
    ORDER BY es.schedule_at DESC");
    $stmtSchedule->execute([$user_id]);
    $scheduleResult = $stmtSchedule->fetchAll(PDO::FETCH_ASSOC);

    $stmtUpcomingSchedule = $pdo->prepare("SELECT es.*, st.* FROM employee_schedule es
    INNER JOIN sched_template st ON es.schedule_id = st.template_id
    WHERE es.user_id = ? AND es.schedule_at > CURDATE()
    ORDER BY es.schedule_at ASC");
    $stmtUpcomingSchedule->execute([$user_id]);
    $scheduleResultUpcoming = $stmtUpcomingSchedule->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="column p-2 m-0 rounded-2 col-12 col-md-3 col-12">
        <div class="card rounded-2">
            <div class="d-flex flex-column w-100 align-items-center justify-content-center p-2">
                <div class="w-100 d-flex justify-content-start ps-3 pt-1">
                </div>
                <?php if($employeeData["profile_picture"] == null){ ?>
                <strong class="py-2 px-3 text-white mb-2"
                    style="
                                border-radius: 50%;
                                font-weight: 500;
                                background-color: rgba(255, 14, 14, 0.70);
                                font-size: 2.5rem;
                                border: solid 2px rgb(255, 14, 14);
                            "><?= htmlspecialchars(strtoupper(substr($employeeData["firstname"], 0,1) . substr($employeeData["lastname"], 0,1))) ?></strong>
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
    <div class="col-md-9 col-12 d-flex justify-content-start align-items-start p-2">
        <div class="card col-md-12 col-12">
            <!-- NAVIAGATIONS OF TABS -->
            <div class="card-body col-md-12 col-12 d-flex justify-content-between pb-4">
                <ul class="nav nav-tabs col-md-8 col-12" id="SchedTabs">
                    <li class="nav-item cursor-pointer col-md-6">
                        <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#Active">
                            <i class="fa-solid fa-calendar-days me-2"></i>Current Schedules</a>
                    </li>
                    <li class="nav-item cursor-pointer col-md-6">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Inactive">
                            <i class="fa-solid fa-calendar me-2"></i>Upcoming Schedules</a>
                    </li>
                </ul>
            </div>
            <div class="card-body pt-0 p-0">
                <div class="tab-content" id="employeesTabContent">
                    <div class="tab-pane fade show active" id="Active" role="tabpanel" aria-labelledby="approved-tab"
                        tabindex="0">
                        <div class="responssive-table">
                            <table class="table table-responssive table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <td class="font-15 fw-bold">Schedule at</td>
                                        <td class="font-15 fw-bold">Schedule From and To</td>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if($scheduleResult){ 
                                        foreach($scheduleResult as $sched) :?>
                                    <tr>
                                        <td class="font-13"><?= date('M d Y', strtotime($sched["schedule_at"])) ?></td>
                                        <td class="font-13">
                                            <?= htmlspecialchars('(' . $sched["scheduleName"] . ') '.date('h:i A', strtotime($sched["schedule_from"])) . ' - ' . date('h:i A', strtotime($sched["schedule_to"]))) ?>
                                        </td>
                                    </tr>
                                    <?php endforeach;
                                        }else { ?>
                                    <tr>
                                        <td colspan="4" class="fw-bold">This Employee doesn't have any Schule</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="employeesTabContent">
                    <div class="tab-pane fade" id="Inactive" role="tabpanel" aria-labelledby="approved-tab"
                        tabindex="0">
                        <div class="responssive-table">
                            <table class="table table-responssive table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <td class="font-15 fw-bold">Schedule at</td>
                                        <td class="font-15 fw-bold">Schedule From and To</td>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if($scheduleResultUpcoming){ 
                                        foreach($scheduleResultUpcoming as $UpSched) :?>
                                    <tr>
                                        <td class="font-13"><?= date('M d Y', strtotime($UpSched["schedule_at"])) ?></td>
                                        <td class="font-13">
                                            <?= htmlspecialchars('(' . $UpSched["scheduleName"] . ') '.date('h:i A', strtotime($UpSched["schedule_from"])) . ' - ' . date('h:i A', strtotime($UpSched["schedule_to"]))) ?>
                                        </td>
                                    </tr>
                                    <?php endforeach;
                                        }else { ?>
                                    <tr>
                                        <td colspan="4" class="fw-bold">This Employee doesn't have any upcoming schedule
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- ========================================== MODAL SECTIONS ========================================== -->
<div class="modal fade" id="editSchedule" tabindex="-1" aria-labelledby="editScheduleLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="editScheduleLabel">Edit Employee Schedule</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    onclick="location.reload()"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="edit_schedule-for_employee-form">
                    <input type="hidden" name="schedule_id" class="form-control" id="edit_schedule_id">
                    <div class="mx-2">
                        <label class="m-0 form-label">Scheduled At</label>
                        <input type="date" class="form-control" name="schedule_at" id="schedule_at_data">
                    </div>
                    <?php
                        $stmt = $pdo->prepare("SELECT * FROM sched_template");
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="mx-2">
                        <label class="form-label">Schedule Type</label>
                        <select required name="template_id" id="template_id_data" class="form-select">
                            <option value="">Select Schedule</option>
                            <?php foreach($result as $schedule) : ?>
                            <option value="<?= $schedule["template_id"] ?>"><?= htmlspecialchars(
                                    '(' . $schedule["scheduleName"] . ') ' . date('h:i A', strtotime($schedule["schedule_from"])) . ' - ' . date('h:i A', strtotime($schedule["schedule_to"]))
                                ) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-person-plus-fill me-1"></i> Edit Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteSchedule" tabindex="-1" aria-labelledby="deleteScheduleLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="deleteScheduleLabel">Delete Employee Schedule</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    onclick="location.reload()"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="delete_schedule-for_employee-form">
                    <input type="hidden" name="schedule_id" class="form-control" id="delete_schedule_id">
                    <span>Are you sure you want to <strong class="text-danger">DELETE</strong> this schedule?</span>
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-person-plus-fill me-1"></i> delete Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- =================================== SCHEDULE FOR EMPLOYEE =================================== -->
<div class="modal fade" id="createScheduleForEmployee" tabindex="-1" aria-labelledby="createScheduleForEmployeeLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="createScheduleForEmployeeLabel">Create Schedule</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    onclick="location.reload()"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="schedule-for_employee-form" method="post">
                    <input type="hidden" class="form-control" name="user_id" id="user_id_for_schedule">
                    <div class="mx-2">
                        <label class="form-label">Scheduled At</label>
                        <input required type="date" name="schedule_at" class="form-control">
                    </div>
                    <?php
                        $stmt = $pdo->prepare("SELECT * FROM sched_template");
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="mx-2">
                        <label class="form-label">Schedule Type</label>
                        <select required name="schedule_id" id="" class="form-select">
                            <option value="">Select Schedule</option>
                            <?php foreach($result as $schedule) : ?>
                            <option value="<?= $schedule["template_id"] ?>"><?= htmlspecialchars(
                                    '(' . $schedule["scheduleName"] . ') ' . date('h:i A', strtotime($schedule["schedule_from"])) . ' - ' . date('h:i A', strtotime($schedule["schedule_to"]))
                                ) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-person-plus-fill me-1"></i> Create Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ========================================== JAVASCRIPT ========================================== -->
<script src="../../assets/js/hr_js/admin/employee_sched.js" defer></script>