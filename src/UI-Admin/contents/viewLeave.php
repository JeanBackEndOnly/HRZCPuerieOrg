<?php
$leave_id = $_GET["leave_id"];
$stmtGetLEave = $pdo->prepare("
    SELECT 
        lr.*,
        ed.firstname,
        ed.middlename,
        ed.lastname,
        ed.suffix,
        ed.employee_id,
        jt.jobTitle,
        d.Department_name AS department,
        lc.VacationBalance,
        lc.SickBalance,
        lc.SpecialBalance,
        lc.OthersBalance
    FROM leaveReq lr
    INNER JOIN employee_data ed ON lr.employee_id = ed.employee_id
    LEFT JOIN hr_data hr ON lr.employee_id = hr.employee_id
    LEFT JOIN jobTitles jt ON hr.jobtitle_id = jt.jobTitles_id
    LEFT JOIN departments d ON hr.Department_id = d.Department_id
    LEFT JOIN leaveCounts lc ON ed.employee_id = lc.employee_id
    WHERE lr.leave_id = ?
");
$stmtGetLEave->execute([$leave_id]);
$leave = $stmtGetLEave->fetch(PDO::FETCH_ASSOC);
$employee_id = $leave["employee_id"] ?? '';

// Debug: Check what data is actually returned
echo "<!-- Debug: " . print_r($leave, true) . " -->";
?>

<!-- Confirmation Modal -->
<div class="modal fade" id="updateModalEBG" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-start">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="updateModalLabel">Confirm Leave Action</h5>
            </div>
            <div class="modalConfirmation px-3 py-4 text-center">
                <h5 class="mb-0">Are you sure you want to process this leave request?</h5>
                <p class="text-muted mt-2">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="confirmSubmitBtn">Yes, Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal-content">
    <!-- FORM STARTS HERE - WRAPS ENTIRE MODAL CONTENT -->
    <form class="row g-3 w-100" id="leaveProcess-form" method="POST">
        <div class="modal-header bg-primary text-white ms-2">
            <h5 class="modal-title text-white" id="leaveDetailsModalLabel">Leave Request Details</h5>
        </div>

        <div class="modal-body row w-100 scroll leave-height ms-2">
            <!-- Hidden Fields -->
            <input type="hidden" name="employee_id" value="<?= $employee_id ?>">
            <input type="hidden" name="leave_id" id="leave_id" value="<?= htmlspecialchars($leave["leave_id"]) ?>">

            <h5 class="w-100 text-center m-0">ZAMBOANGA PUERICULTURE CENTER ORG. NO.144 INC.</h5>
            <strong class="w-100 text-center m-0">APPLICATION FOR LEAVE</strong>

            <!-- Your existing form content -->
            <div class="w-100 p-0 m-0 row name-section">
                <div class="col-md-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" readonly name="lastname" value="<?= htmlspecialchars($leave["lastname"]) ?>"
                        class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">First Name</label>
                    <input type="text" readonly name="firstname" value="<?= htmlspecialchars($leave["firstname"]) ?>"
                        class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">M.I.</label>
                    <input type="text" readonly name="middlename" value="<?= htmlspecialchars($leave["middlename"]) ?>"
                        class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date of filing <span class="text-danger">(required)</span></label>
                    <input type="date" readonly name="leaveDate" value="<?= htmlspecialchars($leave["leaveDate"]) ?>"
                        class="form-control">
                </div>
            </div>
            <div class="w-100 p-0 m-0 row name-section">
                <div class="col-md-6">
                    <label class="form-label">POSITION</label>
                    <input type="text" readonly name="position" value="<?= htmlspecialchars($leave["jobTitle"]) ?>"
                        class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">DEPARTMENT/SECTION</label>
                    <input type="text" readonly name="department" value="<?= htmlspecialchars($leave["department"]) ?>"
                        class="form-control">
                </div>
            </div>
            <div class="w-100 p-0 m-0 row name-section">
                <div class="col-md-2">
                    <label class="form-label">LEAVE APPLIED FOR <span class="text-danger">(required)</span></label>
                </div>

                <div class="col-md-3 d-flex">
                    <input type="radio" name="leaveType" value="Vacation_leave"
                        <?= $leave["leaveType"] == "Vacation_leave" ? "checked" : "" ?> disabled>
                    <span class="d-flex align-items-center ms-2">Vacation Leave</span>
                </div>
                <div class="col-md-2 d-flex">
                    <input type="radio" name="leaveType" value="Sick_leave"
                        <?= $leave["leaveType"] == "Sick_leave" ? "checked" : "" ?> disabled>
                    <span class="d-flex align-items-center ms-2">Sick Leave</span>
                </div>
                <div class="col-md-3 d-flex">
                    <input type="radio" name="leaveType" value="Special_leave"
                        <?= $leave["leaveType"] == "Special_leave" ? "checked" : "" ?> disabled>
                    <span class="d-flex align-items-center ms-2">Special Leave</span>
                </div>
                <div class="col-md-2 d-flex">
                    <input type="radio" name="leaveType" value="Others" id="leaveTypeOthers"
                        <?= $leave["leaveType"] == "Special_leave" ? "checked" : "" ?> disabled>
                    <span class="d-flex align-items-center ms-2">Others</span>
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label">Others Specify</label>
                <input type="text" readonly name="Others" value="<?= htmlspecialchars($leave["Others"]) ?>"
                    class="form-control">
            </div>
            <div class="col-md-12">
                <label class="form-label">COURSE/PURPOSE <span class="text-danger">(required)</span></label>
                <input type="text" readonly name="Purpose" value="<?= htmlspecialchars($leave["Purpose"]) ?>"
                    class="form-control">
            </div>
            <div class="w-100 p-0 m-0 row name-section">
                <div class="col-md-4">
                    <label class="form-label">INCLUSIVE DATE FROM: <span class="text-danger">(required)</span></label>
                    <input type="date" readonly name="InclusiveFrom"
                        value="<?= htmlspecialchars($leave["InclusiveFrom"]) ?>" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">INCLUSIVE DATES TO: <span class="text-danger">(required)</span></label>
                    <input type="date" readonly name="InclusiveTo" value="<?= htmlspecialchars($leave["InclusiveTo"]) ?>"
                        class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">NO. OF DAYS <span class="text-danger">(required)</span></label>
                    <input type="number" readonly name="numberOfDays"
                        value="<?= htmlspecialchars($leave["numberOfDays"]) ?>" class="form-control">
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label">CONTACT NO. WHILE ON LEAVE <span class="text-danger">(required)</span></label>
                <input type="text" readonly name="contact" value="<?= htmlspecialchars($leave["contact"]) ?>"
                    class="form-control">
            </div>
            <p class="text-start w-100 text-dark">I hereby pledge to report for work immediately the
                following day after expiration of my approved leave of absence unless
                otherwise duly extended. My failure to do so shall subject me to disciplinary action</p>
            <!-- <strong class="col-md-6">Recommending Approval:</strong>
            <div class="col-md-6 d-flex flex-column justify-content-center align-item-center">
                <p class="w-100" style="border-bottom: solid 1px #000; transform: translateY(15px);"></p>
                <span class="w-100 text-center m-0">Signature of Applicant</span>
            </div> -->
            <div class="col-md-12 row">
                <div class="col-md-6">
                    <label class="form-label">Section Head</label>
                    <input type="text" readonly name="sectionHead"
                        value="<?= htmlspecialchars($leave["sectionHead"]) ?>" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Department Head</label>
                    <input type="text" readonly name="departmentHead"
                        value="<?= htmlspecialchars($leave["departmentHead"]) ?>" class="form-control">
                </div>
            </div>

            <!-- Admin Only Section -->
            <div id="approvalContent" class="approvalContent col-md-12 col-11 p-0 m-0 mt-4 d-flex flex-column h-auto"
                style="border:solid 1px #000;">
                <h5 class="text-center my-1" style="border-bottom:solid 1px #000;">DETAILS OF ACTION ON APPLICATION
                </h5>

                <table id="admin-print-table" class="table table-bordered table-sm mb-0">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 15.3rem;"></th>
                            <th style="width: 25%">VACATION</th>
                            <th style="width: 25%">SICK</th>
                            <th style="width: 25%">SPECIAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Balance as of</td>
                            <td><input readonly type="text" name="vacationBalance" class="form-control p-1"
                                    value="<?= htmlspecialchars($leave["VacationBalance"] ?? '0') ?> DAYS"></td>
                            <td><input readonly type="text" name="sickBalance" class="form-control p-1"
                                    value="<?= htmlspecialchars($leave["SickBalance"] ?? '0') ?> DAYS"></td>
                            <td><input readonly type="text" name="specialBalance" class="form-control p-1"
                                    value="<?= htmlspecialchars($leave["SpecialBalance"] ?? '0') ?> DAYS"></td>
                        </tr>
                        <tr>
                            <td>Leave Earned</td>
                            <td><input readonly type="text" name="vacationEarned" class="form-control p-1" value="+0"></td>
                            <td><input readonly type="text" name="sickEarned" class="form-control p-1" value="+0"></td>
                            <td><input readonly type="text" name="specialEarned" class="form-control p-1" value="+0"></td>
                        </tr>
                        <tr>
                            <td>Total Leave Credits as of</td>
                            <td><input readonly type="text" name="vacationCredits" class="form-control p-1"
                                    value="<?= htmlspecialchars($leave["VacationBalance"] ?? '0') ?>"></td>
                            <td><input readonly type="text" name="sickCredits" class="form-control p-1"
                                    value="<?= htmlspecialchars($leave["SickBalance"] ?? '0') ?>"></td>
                            <td><input readonly type="text" name="specialCredits" class="form-control p-1"
                                    value="<?= htmlspecialchars($leave["SpecialBalance"] ?? '0') ?>"></td>
                        </tr>
                        <tr>
                            <td>Less this Leave</td>
                            <td><input readonly type="text" name="vacationLessLeave" class="form-control p-1" value="0"></td>
                            <td><input readonly type="text" name="sickLessLeave" class="form-control p-1" value="0"></td>
                            <td><input readonly type="text" name="specialLessLeave" class="form-control p-1" value="0"></td>
                        </tr>
                        <tr>
                            <td>Balance to Date</td>
                            <td><input readonly type="number" name="vacationBalanceToDate" class="form-control p-1"
                                    value="<?= htmlspecialchars($leave["VacationBalance"] ?? '0') ?>"></td>
                            <td><input readonly type="number" name="sickBalanceToDate" class="form-control p-1"
                                    value="<?= htmlspecialchars($leave["SickBalance"] ?? '0') ?>"></td>
                            <td><input readonly type="number" name="specialBalanceToDate" class="form-control p-1"
                                    value="<?= htmlspecialchars($leave["SpecialBalance"] ?? '0') ?>"></td>
                        </tr>
                    </tbody>
                </table>

                <div id="admin-screen-controls" class="recommendation col-md-12 col-12 mt-4">
                    <div class="d-flex flex-column col-md-12 col-11">
                        <label for="" class="fw-bold ms-3">Recommendation for:</label>
                        <div
                            class="row d-flex col-md-11 col-11 flex-row justify-content-start align-items-center m-0 p-0">
                            <input type="radio" class="col-md-1 col-1" id="approved" name="leaveStatus"
                                value="Approved" <?= $leave["leaveStatus"] == "approved" ? "checked" : "" ?>>
                            <label class="col-md-1 col-1 text-start" for="approved">Approved</label>
                        </div>
                        <div
                            class="row d-flex col-md-11 col-11 flex-row justify-content-start align-items-center m-0 p-0">
                            <input type="radio" class="col-md-1 col-1" id="Disapproval" name="leaveStatus"
                                value="Disapproved" <?= $leave["leaveStatus"] == "Disapproved" ? "checked" : "" ?>>
                            <label class="col-md-7 col-9 text-start" for="Disapproval">Disapproval due to:</label>
                            <textarea class="form-control ms-3" name="disapprovalDetails"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end">
                        <button class="btn btn-danger m-0 my-1 mb-3 me-3">
                            Submit
                        </button>
                    </div>
                    
                </div>
            </div>
        </div>
    </form>
</div>
