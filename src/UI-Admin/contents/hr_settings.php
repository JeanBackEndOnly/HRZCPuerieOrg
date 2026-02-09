<section>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="mx-2">
            <h4><i class="fas fa-calendar-check"></i> HR Settings</h4>
            <small class="text-muted">Create Template for schedules</small>
        </div>
    </div>

    <!-- ADD SCHEDULES MODAL (Keep your existing modal) -->
    <div class="modal fade" id="createSchedules" tabindex="-1" aria-labelledby="createSchedulesLabel"
        aria-hidden="true">
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
                        <div class="mx-2">
                            <label class="form-label">Work Days</label>
                            <input type="text" name="day" class="form-control" placeholder="ex. M-W-F">
                        </div>
                        <div class="mx-2">
                            <label class="form-label">Department</label>
                            <select required name="department" id="" class="form-select">
                                <option value="">Select Department</option>
                                <option value="SCHOOL">SCHOOL</option>
                                <option value="HOSPITAL">HOSPITAL</option>
                                <option value="ADMIN">ADMIN</option>
                                <option value="HR">HR</option>
                            </select>
                        </div>
                        <!-- Form Submission -->
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
    <!-- Add leave -->
    <div class="modal fade" id="createLeave" tabindex="-1" aria-labelledby="addDepartmentsLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="createAccountsLabel">Add New Leave
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        onclick="location.reload()"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="leave-types-form">
                        <div class="m-2">
                            <label class="form-label">Leave Type</label>
                            <input required type="text" class="form-control" name="leave_type">
                        </div>
                        <div class="m-2">
                            <label class="form-label">Leave Description</label>
                            <input required type="text" class="form-control" name="leave_description">
                        </div>
                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-danger px-5">
                                <i class="bi bi-person-plus-fill me-1"></i> Add Leave
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body col-md-12 col-12 d-flex justify-content-between flex-wrap">
            <ul class="nav nav-tabs col-md-8 col-12" id="mainTabs" role="tablist">
                <li class="nav-item col-md-3" role="presentation">
                    <button class="nav-link active w-100 h-100" id="time-schedule-tab" data-bs-toggle="tab"
                        data-bs-target="#time-schedule" type="button" role="tab" aria-controls="time-schedule"
                        aria-selected="true">
                        <i class="fa-solid fa-user-tie me-2"></i>Time Schedule
                    </button>
                </li>
                <li class="nav-item col-md-3" role="presentation">
                    <button class="nav-link w-100 h-100" id="manage-leave-tab" data-bs-toggle="tab"
                        data-bs-target="#manage-leave" type="button" role="tab" aria-controls="manage-leave"
                        aria-selected="false">
                        <i class="fa-solid fa-user-plus me-2"></i>Manage Leave
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body pt-0">
            <!-- Main Tab Content -->
            <div class="tab-content" id="mainTabContent">
                <!-- Time Schedule Tab -->
                <div class="tab-pane fade show active" id="time-schedule" role="tabpanel"
                    aria-labelledby="time-schedule-tab" tabindex="0">
                    <div>
                        <div class="col-md-12 d-flex justify-content-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSchedules">
                                <i class="fas fa-plus me-1"></i> add schedules
                            </button>
                        </div>

                    </div>
                    <!-- Department Tabs Navigation -->
                    <ul class="nav nav-tabs" id="SchedulesTabs" role="tablist">
                        <li class="nav-item col-md-3" role="presentation">
                            <button class="nav-link active w-100 h-100" id="school-tab" data-bs-toggle="tab"
                                data-bs-target="#school" type="button" role="tab" aria-controls="school"
                                aria-selected="true">
                                <i class="fa-solid fa-user-tie me-2"></i>School
                            </button>
                        </li>
                        <li class="nav-item col-md-3" role="presentation">
                            <button class="nav-link w-100 h-100" id="hr-tab" data-bs-toggle="tab" data-bs-target="#hr"
                                type="button" role="tab" aria-controls="hr" aria-selected="false">
                                <i class="fa-solid fa-user-plus me-2"></i>HR
                            </button>
                        </li>
                        <li class="nav-item col-md-3" role="presentation">
                            <button class="nav-link w-100 h-100" id="hospital-tab" data-bs-toggle="tab"
                                data-bs-target="#hospital" type="button" role="tab" aria-controls="hospital"
                                aria-selected="false">
                                <i class="fa-solid fa-user-minus me-2"></i>Hospital
                            </button>
                        </li>
                        <li class="nav-item col-md-3" role="presentation">
                            <button class="nav-link w-100 h-100" id="admin-tab" data-bs-toggle="tab"
                                data-bs-target="#admin" type="button" role="tab" aria-controls="admin"
                                aria-selected="false">
                                <i class="fa-solid fa-user-minus me-2"></i>Admin
                            </button>
                        </li>
                    </ul>

                    <!-- Department Tab Content -->
                    <div class="tab-content mt-3">
                        <!-- School Department -->
                        <div class="tab-pane fade show active" id="school" role="tabpanel" aria-labelledby="school-tab"
                            tabindex="0">
                            <div class="table-responsive table-body">
                                <table class="table table-bordered table-hover table-sm text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Schedule Type</th>
                                            <th>From</th>
                                            <th>TO</th>
                                            <th>Shift</th>
                                            <th>Days</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $stmt = $pdo->prepare("SELECT * FROM sched_template WHERE department = 'SCHOOL'");
                                        $stmt->execute();
                                        $SchoolSched = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        $count = 1;
                                        foreach($SchoolSched as $school) : 
                                        ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= htmlspecialchars($school["scheduleName"]) ?></td>
                                            <td><?= htmlspecialchars($school["schedule_from"]) ?></td>
                                            <td><?= htmlspecialchars($school["schedule_to"]) ?></td>
                                            <td><?= htmlspecialchars($school["shift"]) ?></td>
                                            <td><?= htmlspecialchars($school["day"]) ?></td>
                                            <td>
                                                <button class="btn btn-sm m-0 btn-info editScheduleBtn"
                                                    data-bs-toggle="modal" data-bs-target="#editSchedule"
                                                    data-id="<?= htmlspecialchars($school["template_id"]) ?>">
                                                    EDIT
                                                </button>
                                                <button class="btn btn-sm m-0 btn-danger scheduleTemplateId"
                                                    data-bs-toggle="modal" data-bs-target="#scheduleDelete"
                                                    data-id="<?= htmlspecialchars($school["template_id"]) ?>">DELETE</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- HR Department -->
                        <div class="tab-pane fade" id="hr" role="tabpanel" aria-labelledby="hr-tab" tabindex="0">
                            <div class="table-responsive table-body">
                                <table class="table table-bordered table-hover table-sm text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Schedule Type</th>
                                            <th>From</th>
                                            <th>TO</th>
                                            <th>Shift</th>
                                            <th>Days</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $stmt = $pdo->prepare("SELECT * FROM sched_template WHERE department = 'HR'");
                                        $stmt->execute();
                                        $hrSched = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        $count = 1;
                                        foreach($hrSched as $hr) : 
                                        ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= htmlspecialchars($hr["scheduleName"]) ?></td>
                                            <td><?= htmlspecialchars($hr["schedule_from"]) ?></td>
                                            <td><?= htmlspecialchars($hr["schedule_to"]) ?></td>
                                            <td><?= htmlspecialchars($hr["shift"]) ?></td>
                                            <td><?= htmlspecialchars($hr["day"]) ?></td>
                                            <td>
                                                <button class="btn btn-sm m-0 btn-info editScheduleBtn"
                                                    data-bs-toggle="modal" data-bs-target="#editSchedule"
                                                    data-id="<?= htmlspecialchars($hr["template_id"]) ?>">
                                                    EDIT
                                                </button>
                                                <button class="btn btn-sm m-0 btn-danger scheduleTemplateId"
                                                    data-bs-toggle="modal" data-bs-target="#scheduleDelete"
                                                    data-id="<?= htmlspecialchars($hr["template_id"]) ?>">DELETE</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Hospital Department -->
                        <div class="tab-pane fade" id="hospital" role="tabpanel" aria-labelledby="hospital-tab"
                            tabindex="0">
                            <div class="table-responsive table-body">
                                <table class="table table-bordered table-hover table-sm text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Schedule Type</th>
                                            <th>From</th>
                                            <th>TO</th>
                                            <th>Shift</th>
                                            <th>Days</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $stmt = $pdo->prepare("SELECT * FROM sched_template WHERE department = 'HOSPITAL'");
                                        $stmt->execute();
                                        $hospitalSched = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        $count = 1;
                                        foreach($hospitalSched as $hospital) : 
                                        ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= htmlspecialchars($hospital["scheduleName"]) ?></td>
                                            <td><?= htmlspecialchars($hospital["schedule_from"]) ?></td>
                                            <td><?= htmlspecialchars($hospital["schedule_to"]) ?></td>
                                            <td><?= htmlspecialchars($hospital["shift"]) ?></td>
                                            <td><?= htmlspecialchars($hospital["day"]) ?></td>
                                            <td>
                                                <button class="btn btn-sm m-0 btn-info editScheduleBtn"
                                                    data-bs-toggle="modal" data-bs-target="#editSchedule"
                                                    data-id="<?= htmlspecialchars($hospital["template_id"]) ?>">
                                                    EDIT
                                                </button>
                                                <button class="btn btn-sm m-0 btn-danger scheduleTemplateId"
                                                    data-bs-toggle="modal" data-bs-target="#scheduleDelete"
                                                    data-id="<?= htmlspecialchars($hospital["template_id"]) ?>">DELETE</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Admin Department -->
                        <div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="admin-tab" tabindex="0">
                            <div class="table-responsive table-body">
                                <table class="table table-bordered table-hover table-sm text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Schedule Type</th>
                                            <th>From</th>
                                            <th>TO</th>
                                            <th>Shift</th>
                                            <th>Days</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $stmt = $pdo->prepare("SELECT * FROM sched_template WHERE department = 'ADMIN'");
                                        $stmt->execute();
                                        $adminSched = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        $count = 1;
                                        foreach($adminSched as $admin) : 
                                        ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= htmlspecialchars($admin["scheduleName"]) ?></td>
                                            <td><?= htmlspecialchars($admin["schedule_from"]) ?></td>
                                            <td><?= htmlspecialchars($admin["schedule_to"]) ?></td>
                                            <td><?= htmlspecialchars($admin["shift"]) ?></td>
                                            <td><?= htmlspecialchars($admin["day"]) ?></td>
                                            <td>
                                                <button class="btn btn-sm m-0 btn-info editScheduleBtn"
                                                    data-bs-toggle="modal" data-bs-target="#editSchedule"
                                                    data-id="<?= htmlspecialchars($admin["template_id"]) ?>">
                                                    EDIT
                                                </button>
                                                <button class="btn btn-sm m-0 btn-danger scheduleTemplateId"
                                                    data-bs-toggle="modal" data-bs-target="#scheduleDelete"
                                                    data-id="<?= htmlspecialchars($admin["template_id"]) ?>">DELETE</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- End department tab content -->
                </div> <!-- End time-schedule tab -->

                <!-- Manage Leave Tab -->
                <div class="tab-pane fade" id="manage-leave" role="tabpanel" aria-labelledby="manage-leave-tab"
                    tabindex="0">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createLeave">
                            <i class="fas fa-plus me-1"></i> add Leave
                        </button>
                    </div>
                    <?php
                        $stmt = $pdo->prepare("SELECT * FROM leaves");
                        $stmt->execute();
                        $getLeaves = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $leaveCounts = 1;
                    ?>
                    <div class="responsive-table p-3 text-center">
                        <table class="table-responsive table table-bordered tabled-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Leave Type</th>
                                    <th>Leave Description</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($getLeaves as $leave) : ?>
                                    <tr>
                                        <th><?= $leaveCounts++ ?></th>
                                        <th>
                                            <?= htmlspecialchars($leave["leave_type"]) ?>
                                        </th>
                                        <th>
                                            <?= htmlspecialchars($leave["leave_description"]) ?>
                                        </th>
                                        <th>
                                            <?= htmlspecialchars($leave["created_at"]) ?>
                                        </th>
                                        <th>
                                            <button class="btn btn-sm btn-info"
                                                onclick="getValuesEdit(
                                                    <?= $leave['leaves_id'] ?>, 
                                                    '<?= addslashes($leave['leave_type']) ?>',
                                                    '<?= addslashes($leave['leave_description']) ?>'
                                                    )"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editLeave">Edit</button>
                                            <button class="btn btn-sm btn-danger"
                                            id="getLeaveIdDelete"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteLeaveType"
                                            data-id="<?= $leave["leaves_id"] ?>">Delete</button>
                                        </th>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- End main tab content -->
        </div>
    </div>
</section>

<!-- delete modal -->
<div class="modal fade" id="scheduleDelete" tabindex="-1" aria-labelledby="scheduleDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="delete-template-form">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title text-white" id="scheduleDeleteLabel">Delete confirmation</h5>
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
                    <div class="mx-2">
                        <label class="form-label">Work Days</label>
                        <input type="text" name="day" class="form-control" placeholder="ex. M-W-F">
                    </div>
                    <div class="mx-2">
                        <label class="form-label">Department</label>
                        <select required name="department" id="" class="form-select">
                            <option value="">Select Department</option>
                            <option value="SCHOOL">SCHOOL</option>
                            <option value="HOSPITAL">HOSPITAL</option>
                            <option value="ADMIN">ADMIN</option>
                            <option value="HR">HR</option>
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

<!-- edit leave -->
 <div class="modal fade" id="editLeave" tabindex="-1" aria-labelledby="editLeaveLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="edit-leave_type">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title text-white" id="editLeaveLabel">Edit Leave information
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="leaves_id" id="leave_id_info">

                    <div class="mx-2">
                        <label class="form-label">Leave Type</label>
                        <input required type="text" name="leave_type" id="leave_type_info" class="form-control">
                    </div>
                    <div class="mx-2">
                        <label class="form-label">Leave Description</label>
                        <input required type="text" name="leave_description" id="leave_description_info" class="form-control">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Update Leave</button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- delete leave -->
<div class="modal fade" id="deleteLeaveType" tabindex="-1" aria-labelledby="deleteLeaveTypeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="delete-leave_type-form">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title text-white" id="deleteLeaveTypeLabel">Delete confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this leave type?
                <input type="hidden" name="leaves_id" id="delete_leaves_id">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
<script>
function getValuesEdit(leaveId, type, desc){
    document.getElementById('leave_id_info').value = leaveId;
    document.getElementById('leave_type_info').value = type;
    document.getElementById('leave_description_info').value = desc;

    console.log(leaveId + type + desc)
}
document.addEventListener('DOMContentLoaded', function() {
    // Initialize both tab systems
    MainTabs();
    SchedulesTab();

    // Add event listeners for delete buttons
    document.querySelectorAll('.scheduleTemplateId').forEach(button => {
        button.addEventListener('click', function() {
            const templateId = this.getAttribute('data-id');
            document.getElementById('TemplateId').value = templateId;
        });
    });

    // Add event listeners for edit buttons
    document.querySelectorAll('.editScheduleBtn').forEach(button => {
        button.addEventListener('click', function() {
            const templateId = this.getAttribute('data-id');
            document.getElementById('template_id').value = templateId;
        });
    });
});

function MainTabs() {
    const mainTabButtons = document.querySelectorAll('#mainTabs .nav-link');
    const mainTabContents = document.querySelectorAll('#mainTabContent .tab-pane');

    console.log('Main tab buttons:', mainTabButtons.length);
    console.log('Main tab contents:', mainTabContents.length);

    // Initialize tabs - hide all except active
    mainTabContents.forEach(content => {
        if (!content.classList.contains('active')) {
            content.style.display = 'none';
        }
    });

    mainTabButtons.forEach((button) => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Update active button
            mainTabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Hide all tab contents
            mainTabContents.forEach(content => {
                content.style.display = 'none';
                content.classList.remove('show', 'active');
            });

            // Show the selected tab
            const targetId = this.getAttribute('data-bs-target');
            console.log('Main tab target:', targetId);
            const targetContent = document.querySelector(targetId);
            if (targetContent) {
                targetContent.style.display = 'block';
                targetContent.classList.add('show', 'active');

                // If switching to time-schedule, initialize department tabs
                if (targetId === '#time-schedule') {
                    // Re-initialize department tabs if needed
                    setTimeout(() => {
                        const firstDeptTab = document.querySelector(
                            '#SchedulesTabs .nav-link.active');
                        if (firstDeptTab) {
                            firstDeptTab.click();
                        }
                    }, 50);
                }
            }
        });
    });
}

function SchedulesTab() {
    const tabButtons = document.querySelectorAll('#SchedulesTabs .nav-link');
    const tabContents = document.querySelectorAll('#time-schedule .tab-pane');

    console.log('Department tab buttons:', tabButtons.length);
    console.log('Department tab contents:', tabContents.length);

    // Initialize tabs - hide all except active
    tabContents.forEach(content => {
        if (!content.classList.contains('active')) {
            content.style.display = 'none';
        }
    });

    tabButtons.forEach((button) => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Update active button
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Hide all tab contents
            tabContents.forEach(content => {
                content.style.display = 'none';
                content.classList.remove('show', 'active');
            });

            // Show the selected tab
            const targetId = this.getAttribute('data-bs-target');
            console.log('Department tab target:', targetId);
            const targetContent = document.querySelector(targetId);
            if (targetContent) {
                targetContent.style.display = 'block';
                targetContent.classList.add('show', 'active');

                // Load data if needed
                if (targetId === '#school') {
                    console.log('School tab clicked');
                } else if (targetId === '#hr') {
                    console.log('HR tab clicked');
                } else if (targetId === '#hospital') {
                    console.log('Hospital tab clicked');
                } else if (targetId === '#admin') {
                    console.log('Admin tab clicked');
                }
            }
        });
    });
}
</script>