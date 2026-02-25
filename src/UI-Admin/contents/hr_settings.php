<?php $countEmployee = 1; ?>
<section>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="mx-2">
            <h4><i class="fas fa-calendar-check"></i> Schedule Settings</h4>
            <small class="text-muted">Create Template for schedules</small>
        </div>
        <div class="col-md-3 justify-content-end" style="display: none;" id="display-csv">
            <button class="btn btn-success m-0 py-2 px-3" id="download-csv">Download csv</button>
        </div>
        <div id="displayButton">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSchedules">
                <i class="fas fa-plus me-1"></i> add schedules
            </button>
        </div>
    </div>
    <div class="card p-2">
        <div class="card-body col-md-12 col-12 d-flex justify-content-between p-2 max-width-hr-settings">
            <ul class="nav nav-tabs col-md-8 col-12" id="hr_settingsTabs">
                <li class="nav-item cursor-pointer col-md-4">
                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#schedule_template">
                        <i class="fa-solid fa-calendar-plus me-2"></i>Schedule Template</a>
                </li>
                <li class="nav-item cursor-pointer col-md-4">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#employee_schedule">
                        <i class="fa-solid fa-user-clock me-2"></i>Employee Schedules</a>
                </li>
                <li class="nav-item cursor-pointer col-md-4">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#print_schedule">
                        <i class="fa-solid fa-calendar-days me-2"></i>CSV Schedules
                    </a>
                </li>
            </ul>
            <div class="col-md-4 ps-4 justify-content-end gap-1 pb-2" id="displayFilter" style="display: none;">
                <div class="col-md-6">
                    <select name="filter_department" id="filter_department" class="form-select">
                        <option value="">All Departments</option>
                        <?php 
                            $stmt = $pdo->prepare("SELECT * FROM departments ORDER BY Department_name");
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($result as $dept) :
                        ?>
                        <option value="<?= $dept["Department_id"] ?>">
                            <?= $dept["Department_name"] . ' (' . $dept["Department_code"] . ')' ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="scheduleFrom" id="scheduleFrom">
                </div>
                <strong class="h-100 d-flex align-items-center justify-content-center"> - </strong>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="scheduleTo" id="scheduleTo">
                </div>
            </div>
            <div class="col-md-4 ps-3 justify-content-end pb-2" id="displaySearch" style="display: none;">
                <input type="text" name="search" id="searchEmployee" class="form-control"
                    placeholder="Search by name and id.....">
            </div>
        </div>
        <div class="card-body pt-0 p-0">
            <div class="tab-content" id="employeesTabContent">
                <div class="tab-pane col-md-12 fade show active" id="schedule_template" role="tabpanel"
                    aria-labelledby="approved-tab" tabindex="0">
                    <div class="table-responsive table-body w-100">
                        <table class="table table-bordered table-hover table-sm text-center w-100">
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
                <div class="tab-pane row fade col-md-12" id="employee_schedule" role="tabpanel">
                    <?php foreach($getEmployeeForSchedules as $emp) : ?>
                    <a href="index.php?page=contents/employee_sched&employee_id=<?= $emp["employee_id"] ?>"
                        class="col-md-4">
                        <div class="card col-md-12 d-flex flex-row shadow p-2 rounded-3 border">
                            <div class="col-md-2 d-flex align-items-center">
                                <?php if($emp["profile_picture"] == null){ ?>
                                <strong class="py-2 px-2 text-white"
                                    style="
                                                    border-radius: 50%;
                                                    font-weight: 500 !important;
                                                    background-color: rgba(255, 14, 14, 0.70);
                                                    font-size: 15px;
                                                    border: solid 1px #fff;
                                                "><?= htmlspecialchars(strtoupper(substr($emp["firstname"], 0,1) . substr($emp["lastname"], 0,1))) ?></strong>
                                <?php }else{ ?>
                                <img src="../../authentication/uploads/<?= $emp["profile_picture"] ?>"
                                    style="width: 200px; height: auto; border-radius: 50%;">
                                <?php } ?>
                            </div>
                            <div class="col-md-10 d-flex flex-column">
                                <strong
                                    class="font-13"><?= htmlspecialchars($emp["firstname"] . ' ' . substr($emp["middlename"], 0, 1) . '. ' . $emp["lastname"]) ?></strong>
                                <span
                                    class="font-12"><?= htmlspecialchars($emp["Department_name"]) . ' •EMP-' . $emp["employeeID"] ?></span>
                            </div>
                        </div>
                    </a>

                    <?php endforeach; ?>
                </div>
                <style>
                #print_schedule {
                    max-width: 80vw !important;
                }
                </style>
                <div class="tab-pane text-center table-body col-md-12 fade" id="print_schedule" role="tabpanel">
                    <div class="responsive-table w-100">
                        <div class="col-md-12">
                            <strong id="selected-department"></strong>
                        </div>
                        <table class="table table-bordered table-sm w-100" id="scheduleTable">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th id="dates-header">Select dates to view schedules</th>
                                </tr>
                            </thead>
                            <tbody id="scheduleTableBody">
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Please select department and date
                                        range to view schedules</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ===================================== MODAL SECTION ===================================== -->

<!-- add modal  -->
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
<script src="../../assets/js/hr_js/admin/hr_settings.js" defer></script>