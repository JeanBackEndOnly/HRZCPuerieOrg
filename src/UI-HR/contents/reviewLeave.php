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
        lc.OthersBalance,
        ld.disapprovalDetails
    FROM leaveReq lr
    INNER JOIN employee_data ed ON lr.employee_id = ed.employee_id
    INNER JOIN leave_details ld ON lr.leave_id = ld.leave_id
    LEFT JOIN hr_data hr ON lr.employee_id = hr.employee_id
    LEFT JOIN jobTitles jt ON hr.jobtitle_id = jt.jobTitles_id
    LEFT JOIN Departments d ON hr.Department_id = d.Department_id
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
            <a href="index.php?page=contents/leave" class="btn btn-danger m-0">Back to leaves</a>
            <h5 class="modal-title text-white" id="leaveDetailsModalLabel">Leave Request Details</h5>
            <button class="btn btn-info btn-sm m-0" type="button" id="print_leave">Print Leave</button>
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
            <?php 
                if($leave["leaveType"] == "Sick_leave"){
            ?>
            <div class="col-md-12 my-2">
                <label class="form-label">Medical Proof</label>
                <a href="../../authentication/uploads/<?= $leave["medical_proof"] ?>" class="form-control" target="_blank"><?= $leave["medical_proof"] ?></a>
            </div>  
            <?php }else{} ?>
            <div class="col-md-12">
                <label class="form-label">COURSE/PURPOSE <span class="text-danger">(required)</span></label>
                <input type="text" readonly name="Purpose" value="<?= htmlspecialchars($leave["Purpose"]) ?>"
                    class="form-control">
            </div>
            <div class="w-100 p-0 m-0 row name-section">
                <?php 
                                            $stmt = $pdo->prepare("SELECT inclusive_date FROM leave_date ld
                                            LEFT JOIN leaveReq lr ON ld.leave_id = lr.leave_id
                                            WHERE lr.employee_id = :employee_id AND lr.leave_id = :leave_id");
                                            $stmt->execute(['employee_id' => $leave["employee_id"], 'leave_id' => $leave["leave_id"]]);
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

                                             echo '<div class="col-md-6 d-flex align-items-center justify-content-center flex-column">
                                                <label class="form-label w-100 text-start">
                                                    Inclusive Date <span class="text-danger">(required)</span>
                                                </label>
                                                <strong class="form-control" readonly>' . implode(' ', $parts) . ' ' . $year . '</strong>
                                             </div>';
                                            }
                                        ?>
                <div class="col-md-6">
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
                            <input disabled type="radio" class="col-md-1 col-1" id="approved" name="leaveStatus"
                                value="Approved" <?= $leave["leaveStatus"] == "approved" ? "checked" : "" ?>>
                            <label class="col-md-1 col-1 text-start" for="approved">Approved</label>
                        </div>
                        <div
                            class="row d-flex col-md-11 col-11 flex-row justify-content-start align-items-center m-0 p-0">
                            <input disabled type="radio" class="col-md-1 col-1" id="Disapproval" name="leaveStatus"
                                value="Disapproved" <?= $leave["leaveStatus"] == "Disapproved" ? "checked" : "" ?>>
                            <label class="col-md-7 col-9 text-start" for="Disapproval">Disapproval due to:</label>
                            <textarea class="form-control ms-3" name="disapprovalDetails"><?= htmlspecialchars($leave["disapprovalDetails"] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
// Auto-calculation script
document.addEventListener("DOMContentLoaded", () => {
    const leaveTypes = ["vacation", "sick", "special"];
    const leaveTypeInput = document.querySelector("input[name='leaveType']:checked");
    const numberOfDaysInput = document.querySelector("input[name='numberOfDays']");

    let selectedLeaveType = "";
    if (leaveTypeInput) {
        const val = leaveTypeInput.value.toLowerCase();
        if (val.includes("vacation")) selectedLeaveType = "vacation";
        else if (val.includes("sick")) selectedLeaveType = "sick";
        else if (val.includes("special")) selectedLeaveType = "special";
    }

    leaveTypes.forEach(type => {
        const balance = document.querySelector(`input[name='${type}Balance']`);
        const earned = document.querySelector(`input[name='${type}Earned']`);
        const credits = document.querySelector(`input[name='${type}Credits']`);
        const lessLeave = document.querySelector(`input[name='${type}LessLeave']`);
        const balanceToDate = document.querySelector(`input[name='${type}BalanceToDate']`);

        function updateCalculation() {
            const balVal = parseFloat(balance.value) || 0;
            const earnedVal = parseFloat(earned.value.replace('+', '')) || 0;
            let lessVal = parseFloat(lessLeave.value) || 0;
            const leaveDays = parseFloat(numberOfDaysInput.value) || 0;

            if (type === selectedLeaveType) {
                lessVal = leaveDays;
                lessLeave.value = leaveDays;
            }

            const totalCredits = balVal + earnedVal;
            const finalBalance = totalCredits - lessVal;

            credits.value = totalCredits.toFixed(2);
            balanceToDate.value = finalBalance.toFixed(2);
        }

        [balance, earned, lessLeave, numberOfDaysInput].forEach(input => {
            input?.addEventListener("input", updateCalculation);
        });

        if (balance && earned && credits && lessLeave && balanceToDate) {
            updateCalculation();
        }
    });
});

// Form submission handling
$(document).ready(function() {
    // Handle confirmation modal submit
    $('#confirmSubmitBtn').on('click', function() {
        // Close confirmation modal
        $('#updateModalEBG').modal('hide');

        // Submit the main form
        $('#leaveProcess-form').submit();
    });

    // Main form submission
    $('#leaveProcess-form').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);

        if ($form.data("isSubmitted")) return;
        $form.data("isSubmitted", true);

        const formData = new FormData(this);
        const $submitBtn = $('#showConfirmationBtn');

        $submitBtn.prop("disabled", true).html(
            '<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

        $.ajax({
            url: base_url + "authentication/action.php?action=leaveProcess_form",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                Swal.fire({
                    title: response.status === 1 ? 'Success!' : 'Error!',
                    text: response.message,
                    icon: response.status === 1 ? 'success' : 'error',
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    $('#leaveDetailsModal').modal('hide');
                    window.location.href = "index.php?page=contents/leave";
                });
            },
            error: function(jqXHR, textStatus, err) {
                console.error("AJAX error:", textStatus, err);
                Swal.fire({
                    title: 'Connection Error',
                    text: 'Please check your connection and try again.',
                    icon: 'error',
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            complete: function() {
                $form.data("isSubmitted", false);
                $submitBtn.prop("disabled", false).html(
                    '<i class="fas fa-check"></i> Submit Leave');
            }


        });
    });
});
</script>
<script>
    document.getElementById('print_leave').addEventListener('click', function() {
    // Store original content
    const originalBody = document.body.innerHTML;
    
    // Get the form content
    const leaveForm = document.getElementById('leaveProcess-form').cloneNode(true);
    
    // Create print wrapper
    const printWrapper = document.createElement('div');
    printWrapper.style.cssText = `
        font-family: Arial, sans-serif;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    `;
    
    // Add header with organization info
    const headerDiv = document.createElement('div');
    headerDiv.style.cssText = 'text-align: center; margin-bottom: 20px;';
    headerDiv.innerHTML = `
        <h4 style="margin: 0; font-weight: bold;">ZAMBOANGA PUERICULTURE CENTER ORG. NO.144 INC.</h4>
        <h5 style="margin: 5px 0 20px 0; font-weight: bold;">APPLICATION FOR LEAVE</h5>
    `;
    printWrapper.appendChild(headerDiv);
    
    // Clone the form content
    const formClone = leaveForm.cloneNode(true);
    
    // Remove buttons and modal classes
    const elementsToRemove = formClone.querySelectorAll(
        'button, .modal-header, .modal-footer, .modal-title, [data-bs-dismiss], .btn, #print_leave'
    );
    elementsToRemove.forEach(el => el.remove());
    
    // Remove modal classes
    formClone.querySelectorAll('.modal-content, .modal-body, .scroll').forEach(el => {
        el.classList.remove('modal-content', 'modal-body', 'scroll');
    });
    
    // Add signature sections
    const signatureSection = document.createElement('div');
    signatureSection.style.cssText = 'margin-top: 40px;';
    signatureSection.innerHTML = `
        <div style="display: flex; justify-content: space-between; margin-top: 30px;">
            <div style="text-align: center; width: 30%;">
                <div style="border-bottom: 1px solid #000; width: 100%; height: 25px; margin-bottom: 5px;"></div>
                <div style="font-size: 12px;">Signature of Applicant</div>
            </div>
            <div style="text-align: center; width: 30%;">
                <div style="border-bottom: 1px solid #000; width: 100%; height: 25px; margin-bottom: 5px;"></div>
                <div style="font-size: 12px;">Section Head</div>
            </div>
            <div style="text-align: center; width: 30%;">
                <div style="border-bottom: 1px solid #000; width: 100%; height: 25px; margin-bottom: 5px;"></div>
                <div style="font-size: 12px;">Department Head</div>
            </div>
        </div>
        
        <div style="margin-top: 50px;">
            <div style="display: flex; justify-content: space-between;">
                <div style="text-align: center; width: 40%;">
                    <div style="border-bottom: 1px solid #000; width: 80%; height: 25px; margin-bottom: 5px; margin-left: 10%;"></div>
                    <div style="font-size: 12px;">Approved by (HR/Admin)</div>
                </div>
                <div style="text-align: center; width: 40%;">
                    <div style="border-bottom: 1px solid #000; width: 80%; height: 25px; margin-bottom: 5px; margin-left: 10%;"></div>
                    <div style="font-size: 12px;">Date</div>
                </div>
            </div>
        </div>
    `;
    
    // Append form content and signature section
    printWrapper.appendChild(formClone);
    printWrapper.appendChild(signatureSection);
    
    // Add print footer
    const footerDiv = document.createElement('div');
    footerDiv.style.cssText = 'margin-top: 30px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ccc; padding-top: 10px;';
    footerDiv.innerHTML = `
        Printed from: Leave Management System | ${new Date().toLocaleDateString()} ${new Date().toLocaleTimeString()}
    `;
    printWrapper.appendChild(footerDiv);
    
    // Create print window
    const printWindow = window.open('', '_blank', 'width=900,height=700');
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Leave Application - ${formClone.querySelector('input[name="lastname"]')?.value || ''}, ${formClone.querySelector('input[name="firstname"]')?.value || ''}</title>
            <style>
                @media print {
                    @page {
                        size: A4;
                        margin: 0.5in;
                    }
                    
                    body {
                        font-family: 'Arial', sans-serif;
                        font-size: 12px;
                        line-height: 1.2;
                    }
                    .name-section{
                        display: flex;
                        flex-direction: row;
                    }
                    .form-control {
                        border: none !important;
                        border-bottom: 1px solid #000 !important;
                        background: transparent !important;
                        padding: 2px 5px !important;
                        box-shadow: none !important;
                    }
                    
                    input[readonly], textarea[readonly] {
                        background-color: transparent !important;
                    }
                    
                    .table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    
                    .table th, .table td {
                        border: 1px solid #000;
                        padding: 4px 8px;
                        text-align: center;
                    }
                    
                    .table th {
                        background-color: #f5f5f5;
                        font-weight: bold;
                    }
                    
                    h4, h5 {
                        margin: 10px 0;
                    }
                    
                    .text-center {
                        text-align: center;
                    }
                    
                    .text-right {
                        text-align: right;
                    }
                    
                    .mb-3 {
                        margin-bottom: 15px;
                    }
                    
                    .mt-3 {
                        margin-top: 15px;
                    }
                    
                    .w-100 {
                        width: 100%;
                    }
                    
                    .border {
                        border: 1px solid #000 !important;
                    }
                    
                    .p-2 {
                        padding: 10px;
                    }
                    
                    .no-print {
                        display: none !important;
                    }
                }
                
                @media screen {
                    body {
                        padding: 20px;
                        background: #f5f5f5;
                    }
                    
                    .print-container {
                        background: white;
                        padding: 30px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    }
                    
                    .print-controls {
                        text-align: center;
                        margin: 20px 0;
                        padding: 15px;
                        background: #f8f9fa;
                        border-radius: 5px;
                    }
                    
                    .print-btn {
                        padding: 10px 25px;
                        background: #007bff;
                        color: white;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        margin: 0 5px;
                        font-size: 14px;
                    }
                    
                    .print-btn:hover {
                        background: #0056b3;
                    }
                    
                    .close-btn {
                        background: #6c757d;
                    }
                    
                    .close-btn:hover {
                        background: #545b62;
                    }
                }
            </style>
        </head>
        <body>
            <div class="print-container">
                <div class="print-controls no-print">
                    <button onclick="window.print()" class="print-btn">🖨️ Print Now</button>
                    <button onclick="window.close()" class="print-btn close-btn">✖ Close Window</button>
                </div>
                ${printWrapper.innerHTML}
            </div>
            
            <script>
                window.onload = function() {
                    // Auto-print after short delay
                    setTimeout(() => {
                        window.print();
                    }, 300);
                };
                
                window.onafterprint = function() {
                    // Optional: Add return logic here
                    console.log("Print completed");
                };
            <\/script>
        </body>
        </html>
    `);
    
    printWindow.document.close();
});
</script>