<section>
    <div class="d-flex justify-content-between align-items-center mb-2 col-md-12 col-12 flex-wrap">
        <div class=" col-md-6 col-12">
            <h4 class=""><i class="fa-solid fa-calendar me-2"></i>Leave Management</h4>
            <small class="text-muted ">Accept, Reject and Update Employee Leave Request</small>
        </div>
        <div class="col-md-2 d-flex justify-content-end">
            <button class="btn btn-danger m-0" data-bs-toggle="modal" data-bs-target="#create_leave">Request
                Leave</button>
        </div>
    </div>
    <!-- EMPLOYEE ACCOUNT DISPLAYS =============================================================================================== -->
    <div class="card">
        <!-- NAVIAGATIONS OF TABS -->
        <div class="card-body col-md-12 col-12 d-flex justify-content-between pb-4">
            <ul class="nav nav-tabs col-md-9 col-12" id="LeaveRequestTabs">
                <li class="nav-item cursor-pointer col-md-4">
                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#Pending_Leave">
                       <i class="fa-solid fa-calendar-plus me-2"></i>Pending Leaves</a>
                </li>
                <li class="nav-item cursor-pointer col-md-4">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Approved_leave">
                        <i class="fa-solid fa-calendar-check me-2"></i>Recommended Leaves</a>
                </li>
                <li class="nav-item cursor-pointer col-md-4">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Rejected_Leave">
                        <i class="fa-solid fa-calendar-xmark me-2"></i>Disapproved Leaves</a>
                </li>
            </ul>
            <div class="col-md-3 ps-2">
                <input type="text" id="searchForAllLeave" class="form-control" placeholder="search by: name and leave type........">
            </div>
        </div>
        <!-- CONTENTS -->
        <div class="card-body pt-0">
            <div class="tab-content">
                <!-- Pending Leaves -->
                <div class="tab-pane text-center table-body fade show active" id="Pending_Leave" role="tabpanel">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="table-light col-md-12">
                            <tr class="col-md-12 font-15">
                                <th>#</th>
                                <th>Complete Name</th>
                                <th>Leave Type</th>
                                <th>From-To</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody style="color: #666;" >
                            <?php 
                            if($PendingLeave){
                                $count = 1; 
                                    foreach($PendingLeave as $Pending) : ?>
                                    <tr class="font-14">
                                        <th><?= $count++ ?></th>
                                        <th><?= htmlspecialchars($Pending["firstname"]) . " " . htmlspecialchars(substr($Pending["middlename"], 0, 1)) . ". " . htmlspecialchars($Pending["lastname"]) ?></th>
                                        <th><?= htmlspecialchars($Pending["leaveType"]) ?></th>
                                        <th>
                                            <?php 
                                                $stmt = $pdo->prepare("SELECT inclusive_date FROM leave_date ld
                                                LEFT JOIN leaveReq lr ON ld.leave_id = lr.leave_id
                                                WHERE lr.user_id = :user_id AND lr.leave_id = :leave_id");
                                                $stmt->execute(['user_id' => $Pending["user_id"], 'leave_id' => $Pending["leave_id"]]);
                                                $getDate = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <?php
                                                if (!empty($getDate)) {

                                                    $timestamps = array_map(fn($d) => strtotime($d['inclusive_date']), $getDate);

                                                    sort($timestamps);

                                                    $months = [];
                                                    foreach ($timestamps as $ts) {
                                                        $month = strtoupper(date('M', $ts));
                                                        $day   = date('j', $ts); 
                                                        $months[$month][] = $day;
                                                    }

                                                    $year = date('Y', $timestamps[0]);

                                                    $parts = [];
                                                    foreach ($months as $month => $days) {
                                                        if (count($days) > 1) {
                                                            $lastDay = array_pop($days);
                                                            $parts[] = $month . ' ' . implode(', ', $days) . ', ' . $lastDay;
                                                        } else {
                                                            $parts[] = $month . ' ' . $days[0];
                                                        }
                                                    }

                                                    echo implode(' ', $parts) . ' ' . $year;
                                                }
                                            ?>

                                        </th>
                                        <th><?= htmlspecialchars($Pending["leaveStatus"]) ?></th>
                                        <th><a href="index.php?page=contents/viewLeave&leave_id=<?= htmlspecialchars($Pending["leave_id"]) ?>" ><button class="btn btn-sm btn-danger px-3 view-leave-details" data-id="${leave.leave_id}">
                                                <i class="fas fa-eye"></i> View
                                            </button></a>
                                        </th>
                                    </tr>
                                    
                            <?php endforeach;
                            }else{?>
                                <tr><td colspan="6" class="text-center"><strong>No Recommended Leave Data</strong></td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Approved Leaves -->
                <div class="tab-pane text-center table-body fade" id="Approved_leave" role="tabpanel">
                    <div class="table-responsive table-body">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="table-light col-md-12">
                                <tr class="col-md-12">
                                    <th>#</th>
                                    <th>Complete Name</th>
                                    <th>Leave Type</th>
                                    <th>From-To</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                                                    <tbody style="color: #666;">
                            <?php 
                            $countApproved = 1;
                            if($RecommendedLeave){
                            foreach($RecommendedLeave as $Recommended) : ?>
                            <tr>
                                <th><?= $countApproved++ ?></th>
                                <th><?= htmlspecialchars($Recommended["firstname"]) . " " . htmlspecialchars(substr($Recommended["middlename"], 0, 1)) . ". " . htmlspecialchars($Recommended["lastname"]) ?></th>
                                <th><?= htmlspecialchars($Recommended["leaveType"]) ?></th>
                                <th>
                                        <?php 
                                            $stmt = $pdo->prepare("SELECT inclusive_date FROM leave_date ld
                                            LEFT JOIN leaveReq lr ON ld.leave_id = lr.leave_id
                                            WHERE lr.user_id = :user_id AND lr.leave_id = :leave_id");
                                            $stmt->execute(['user_id' => $Recommended["user_id"], 'leave_id' => $Recommended["leave_id"]]);
                                            $getDate = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        ?>
                                        <?php
                                            if (!empty($getDate)) {

                                                $timestamps = array_map(fn($d) => strtotime($d['inclusive_date']), $getDate);

                                                sort($timestamps);

                                                $months = [];
                                                foreach ($timestamps as $ts) {
                                                    $month = strtoupper(date('M', $ts));
                                                    $day   = date('j', $ts); 
                                                    $months[$month][] = $day;
                                                }

                                                $year = date('Y', $timestamps[0]);

                                                $parts = [];
                                                foreach ($months as $month => $days) {
                                                    if (count($days) > 1) {
                                                        $lastDay = array_pop($days);
                                                        $parts[] = $month . ' ' . implode(', ', $days) . ', ' . $lastDay;
                                                    } else {
                                                        $parts[] = $month . ' ' . $days[0];
                                                    }
                                                }

                                                echo implode(' ', $parts) . ' ' . $year;
                                            }
                                        ?>

                                    </th>
                                <th><?= htmlspecialchars($Recommended["leaveStatus"]) ?></th>
                                <th><a href="index.php?page=contents/reviewLeave&leave_id=<?= htmlspecialchars($Recommended["leave_id"]) ?>" ><button class="btn btn-sm btn-danger px-3 view-leave-details" data-id="${leave.leave_id}">
                                        <i class="fas fa-eye"></i> Review Leave
                                    </button></a>
                                </th>
                            </tr>
                            <?php endforeach;
                            }else{ ?>
                                <tr><td colspan="6" class="text-center"><strong>No Approved Leave Data</strong></td></tr>
                            <?php } ?>
                        </tbody>
                        </table>
                    </div>
                </div>

                <!-- Rejected Leaves -->
                <div class="tab-pane text-center table-body fade" id="Rejected_Leave" role="tabpanel">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="table-light col-md-12">
                            <tr class="col-md-12">
                                <th>#</th>
                                <th>Complete Name</th>
                                <th>Leave Type</th>
                                <th>From-To</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                         <tbody style="color: #666;">
                            <?php 
                            $countDisapproved = 1;
                            if($DisapprovedLeave){

                            foreach($DisapprovedLeave as $disapproved) : ?>
                            <tr>
                                <th><?= $countDisapproved++ ?></th>
                                <th><?= htmlspecialchars($disapproved["firstname"]) . " " . htmlspecialchars(substr($disapproved["middlename"], 0, 1)) . ". " . htmlspecialchars($disapproved["lastname"]) ?></th>
                                <th><?= htmlspecialchars($disapproved["leaveType"]) ?></th>
                                <th>
                                        <?php 
                                            $stmt = $pdo->prepare("SELECT inclusive_date FROM leave_date ld
                                            LEFT JOIN leaveReq lr ON ld.leave_id = lr.leave_id
                                            WHERE lr.user_id = :user_id AND lr.leave_id = :leave_id");
                                            $stmt->execute(['user_id' => $disapproved["user_id"], 'leave_id' => $disapproved["leave_id"]]);
                                            $getDate = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        ?>
                                        <?php
                                            if (!empty($getDate)) {

                                                $timestamps = array_map(fn($d) => strtotime($d['inclusive_date']), $getDate);

                                                sort($timestamps);

                                                $months = [];
                                                foreach ($timestamps as $ts) {
                                                    $month = strtoupper(date('M', $ts));
                                                    $day   = date('j', $ts); 
                                                    $months[$month][] = $day;
                                                }

                                                $year = date('Y', $timestamps[0]);

                                                $parts = [];
                                                foreach ($months as $month => $days) {
                                                    if (count($days) > 1) {
                                                        $lastDay = array_pop($days);
                                                        $parts[] = $month . ' ' . implode(', ', $days) . ', ' . $lastDay;
                                                    } else {
                                                        $parts[] = $month . ' ' . $days[0];
                                                    }
                                                }

                                                echo implode(' ', $parts) . ' ' . $year;
                                            }
                                        ?>

                                    </th>
                                <th><?= htmlspecialchars($disapproved["leaveStatus"]) ?></th>
                                <th><a href="index.php?page=contents/reviewLeave&leave_id=<?= htmlspecialchars($disapproved["leave_id"]) ?>" ><button class="btn btn-sm btn-danger px-3 view-leave-details" data-id="${leave.leave_id}">
                                        <i class="fas fa-eye"></i> Review Leave
                                    </button></a>
                                </th>
                            </tr>
                            <?php endforeach;
                            }else{ ?>
                                <tr><td colspan="6" class="text-center"><strong>No Disapproved Leave Data</strong></td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- MODAL SECTION -->
 <!-- create leave modal -->
<div class="modal fade" id="create_leave" tabindex="-1" aria-labelledby="create_leaveLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="create_leaveLabel">Request a leave</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="leave-form" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($hr_id) ?>">
                    <input type="hidden" name="leaveStatus" value="Pending">
                    <h5 class="w-100 text-center m-0">ZAMBOANGA PUERICULTURE CENTER ORG. NO.144 INC.</h5>
                    <strong class="w-100 text-center m-0">APPLICATION FOR LEAVE</strong>
                    <?php 
                            date_default_timezone_set('Asia/Manila');
                            $date = date('Y-m-d');
                       ?>
                    <input type="hidden" name="leaveDate" value="<?= $date ?>" class="form-control">
                    <div class="col-md-3">
                        <label class="form-label m-0">LEAVE APPLIED FOR <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <input type="radio" name="leaveType" value="Vacation_leave" required onclick="hide_medical()">
                        <span class="d-flex align-items-center ms-2">Vacation Leave</span>
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <input type="radio" name="leaveType" value="Sick_leave" required onclick="show_medical()">
                        <span class="d-flex align-items-center ms-2">Sick Leave</span>
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <input type="radio" name="leaveType" value="Special_leave" required onclick="hide_medical()">
                        <span class="d-flex align-items-center ms-2">Special Leave</span>
                    </div>
                    <div class="col-md-12 align-items-center" style="display: none;" id="show-medical">
                        <label class="form-label m-0 me-3">Medical Proof <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="file" name="medical_proof" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <input type="radio" name="leaveType" value="Others" id="leaveTypeOthers" required
                            onclick="hide_medical()">
                        <label class="form-label d-flex align-items-center m-0 ms-2">Others Specify</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" name="Others" class="form-control" id="othersInput" disabled>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">COURSE/PURPOSE <span class="text-danger">(required)</span></label>
                        <input type="text" required name="Purpose" class="form-control">
                    </div>
                    <div class="col-md-12 row">
                        <div class="col-md-12 d-flex justify-content-start align-items-center mt-3">
                            <button type="button" id="addDateBtn" class="btn btn-danger">Add date</button>
                        </div>

                        <div id="dateContainer" class="row">
                            <div class="col-md-4">
                                <label class="form-label">
                                    INCLUSIVE DATE: <span class="text-danger">(required)</span>
                                </label>
                                <input type="date" id="Inclusive_date" required name="inclusive_date[]"
                                    class="form-control mb-2 inclusive-date">
                            </div>
                        </div>
                        <script>
                        document.getElementById("addDateBtn").addEventListener("click", function() {

                            const container = document.getElementById("dateContainer");

                            const div = document.createElement("div");
                            div.className = "col-md-4";

                            div.innerHTML = `
                                        <label class="form-label">
                                            INCLUSIVE DATE: <span class="text-danger">(required)</span>
                                        </label>
                                        <input type="date" required name="inclusive_date[]" 
                                            class="form-control mb-2 inclusive-date">
                                    `;

                            container.appendChild(div);

                            attachDateListeners();
                        });
                        </script>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">NO. OF DAYS <span class="text-danger">(required)</span></label>
                            <input type="number" required name="numberOfDays" class="form-control" id="numberOfDays"
                                readonly>
                            <div id="daysError" class="text-danger small mt-1"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CONTACT NO. WHILE ON LEAVE <span
                                    class="text-danger">(required)</span></label>
                            <input type="number" name="contact" required class="form-control">
                        </div>
                    </div>
                    <p class="text-start w-100 text-dark">I hereby pledge to report for work immediately the
                        following day after expiration of my approved leave of absence unless
                        otherwise duly extended. My failure to do so shall subject me to disciplinary action</p>

                    <div class="col-md-6">
                        <label class="form-label">Section Head<span class="text-dark"> (optional)</span></label>
                        <input type="text" name="sectionHead" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Department Head<span class="text-dark"> (optional)</span></label>
                        <input type="text" name="departmentHead" class="form-control">
                    </div>
                    <!-- Form Submission -->
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-person-plus-fill me-1"></i> Submit request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../../assets/js/hr_js/admin/leave.js" defer></script>
<script>
const daysInput = document.getElementById('numberOfDays');
const daysError = document.getElementById('daysError');

function calculateDays() {
    const dates = document.querySelectorAll('.inclusive-date');
    const uniqueDates = new Set();

    dates.forEach(date => {
        if (date.value) {
            uniqueDates.add(date.value);
        }
    });

    const count = uniqueDates.size;

    if (count === 0) {
        daysInput.value = '';
        daysError.textContent = "Please select at least one date.";
    } else {
        daysInput.value = count;
        daysError.textContent = "";
    }
}

function attachDateListeners() {
    const dates = document.querySelectorAll('.inclusive-date');
    dates.forEach(date => {
        date.removeEventListener('change', calculateDays);
        date.addEventListener('change', calculateDays);
    });
}

attachDateListeners();

document.addEventListener('DOMContentLoaded', function() {

    const othersRadio = document.getElementById('leaveTypeOthers');
    const othersInput = document.getElementById('othersInput');
    const leaveTypeRadios = document.querySelectorAll('input[name="leaveType"]');

    function toggleOthersInput() {
        if (othersRadio.checked) {
            othersInput.disabled = false;
            othersInput.required = true;
            othersInput.focus();
        } else {
            othersInput.disabled = true;
            othersInput.required = false;
            othersInput.value = '';
        }
    }

    leaveTypeRadios.forEach(radio => {
        radio.addEventListener('change', toggleOthersInput);
    });
});
</script>