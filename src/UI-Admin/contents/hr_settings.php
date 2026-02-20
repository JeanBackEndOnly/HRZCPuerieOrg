<?php $countEmployee = 1; ?>
<section>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="mx-2">
            <h4><i class="fas fa-calendar-check"></i> HR Settings</h4>
            <small class="text-muted">Create Template for schedules</small>
        </div>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSchedules">
                <i class="fas fa-plus me-1"></i> add schedules
            </button>
        </div>
    </div>
    <div class="card">
        <!-- NAVIAGATIONS OF TABS -->
        <div class="card-body col-md-12 col-12 d-flex justify-content-between pb-4">
            <ul class="nav nav-tabs col-md-7 col-12" id="LeaveRequestTabs">
                <li class="nav-item cursor-pointer col-md-4">
                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#schedule_template"><i
                            class="fa-solid fa-user-tie me-2"></i>Schedule Template</a>
                </li>
                <li class="nav-item cursor-pointer col-md-4">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#employee_schedule"><i
                            class="fa-solid fa-user-plus me-2"></i>Employee Schedules</a>
                </li>
            </ul>
        </div>
        <div class="card-body pt-0 p-0">
            <div class="tab-content" id="employeesTabContent">
                <div class="tab-pane fade show active" id="schedule_template" role="tabpanel"
                    aria-labelledby="approved-tab" tabindex="0">
                    <div class="table-responsive table-body">
                        <table class="table table-bordered table-hover table-sm text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Schedule Type</th>
                                    <th>From</th>
                                    <th>TO</th>
                                    <th>Shift</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $stmt = $pdo->prepare("SELECT * FROM sched_template");
                                $stmt->execute();
                                $SchoolSched = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $count = 1;
                                foreach($SchoolSched as $school) : 
                                ?>
                                <tr>
                                    <th><?= $count++ ?></th>
                                    <th><?= htmlspecialchars($school["scheduleName"]) ?></th>
                                    <th><?= htmlspecialchars(date('h:i A', strtotime($school["schedule_from"]))) ?></th>
                                    <th><?= htmlspecialchars(date('h:i A', strtotime($school["schedule_to"]))) ?></th>
                                    <th><?= htmlspecialchars($school["shift"]) ?></th>
                                    <th>
                                        <button class="btn btn-sm m-0 btn-info editScheduleBtn" data-bs-toggle="modal"
                                            data-bs-target="#editSchedule"
                                            data-id="<?= htmlspecialchars($school["template_id"]) ?>">
                                            EDIT
                                        </button>
                                        <button class="btn btn-sm m-0 btn-danger" id="scheduleTemplateId"
                                            data-bs-toggle="modal" data-bs-target="#scheduleDelete"
                                            data-id="<?= htmlspecialchars($school["template_id"]) ?>">DELETE</button>
                                    </th>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane text-center table-body fade" id="employee_schedule" role="tabpanel">
                    <div class="responsive-table">
                        <table class="table table-responsive table-bordered table-sm">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Name</td>
                                    <td>Department</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($getEmployeeForSchedules as $emp) : ?>
                                    <tr>
                                        <td><?= $countEmployee++ ?></td>
                                        <td><?= htmlspecialchars($emp["lastname"] . ', ' . $emp["firstname"] . ' ' . substr($emp["middlename"], 0, 1) . '.') ?></td>
                                        <td><?= htmlspecialchars($emp["Department_name"] . ' (' . $emp["Department_code"] . ')') ?></td>
                                        <td>
                                            <a href="" class="btn btn-info">View Schedules</a>
                                            <button type="button" class="btn btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#createScheduleForEmployee"
                                            data-id="<?= $emp["employee_id"] ?>"
                                            id="getEmployeeIdForSchedule">Create Schedule</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ===================================== MODAL SECTION ===================================== -->

<!-- =================================== SCHEDULE TEMPLATE =================================== -->
<div class="modal fade" id="createSchedules" tabindex="-1" aria-labelledby="createSchedulesLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="createSchedulesLabel">Create New Schedule Template</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    onclick="location.reload()"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="schedule-template-form" method="post">
                    <div class="mx-2">
                        <label class="form-label">Schedule name</label>
                        <input required type="text" name="scheduleName" class="form-control">
                    </div>
                    <div class="mx-2">
                        <label class="form-label">Schedule From</label>
                        <input required type="time" name="schedule_from" class="form-control">
                    </div>
                    <div class="mx-2">
                        <label class="form-label">Schedule to</label>
                        <input required type="time" name="schedule_to" class="form-control">
                    </div>
                    <div class="mx-2">
                        <label class="form-label">Work Shift</label>
                        <select required name="shift" id="" class="form-select">
                            <option value="">Select Shift</option>
                            <option value="day">Day Shift</option>
                            <option value="night">Night Shift</option>
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
<!-- delete modal -->
<div class="modal fade" id="scheduleDelete" tabindex="-1" aria-labelledby="scheduleDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="delete-template-form">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title text-white" id="scheduleDeleteLabel">Dleete confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this template?
                <input type="hidden" name="TemplateId" id="TemplateId">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
<!-- edit modal -->
<div class="modal fade" id="editSchedule" tabindex="-1" aria-labelledby="editScheduleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="edit-schedule">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title text-white" id="editScheduleLabel">Edit Schdule Inforation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="template_id" id="template_id">

                    <div class="mx-2">
                        <label class="form-label">Schedule name</label>
                        <input required type="text" name="scheduleName" class="form-control">
                    </div>
                    <div class="mx-2">
                        <label class="form-label">Schedule From</label>
                        <input required type="time" name="schedule_from" class="form-control">
                    </div>
                    <div class="mx-2">
                        <label class="form-label">Schedule to</label>
                        <input required type="time" name="schedule_to" class="form-control">
                    </div>
                    <div class="mx-2">
                        <label class="form-label">Work Shift</label>
                        <select required name="shift" id="" class="form-select">
                            <option value="">Select Shift</option>
                            <option value="day">Day Shift</option>
                            <option value="night">Night Shift</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Update Schedule</button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- =================================== SCHEDULE FOR EMPLOYEE =================================== -->
<div class="modal fade" id="createScheduleForEmployee" tabindex="-1" aria-labelledby="createScheduleForEmployeeLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="createScheduleForEmployeeLabel">Create Schedule</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    onclick="location.reload()"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="schedule-for_employee-form" method="post">
                    <input type="hidden" class="form-control" name="employee_id" id="employee_id_for_schedule">
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
                                    '(' . $schedule["scheduleName"] . ') ' . date('h:i A', strtotime($schedule["schedule_from"])) . ' - ' . $schedule["schedule_to"]
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