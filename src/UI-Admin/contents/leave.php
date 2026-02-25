<section>
    <div class="d-flex justify-content-between align-items-center mb-2 col-md-12 col-12 flex-wrap">
        <div class=" col-md-6 col-12">
            <h4 class=""><i class="fa-solid fa-calendar me-2"></i>Leave Management</h4>
            <small class="text-muted ">Accept, Reject and Update Employee Leave Request</small>
        </div>
    </div>
    <!-- EMPLOYEE ACCOUNT DISPLAYS =============================================================================================== -->
    <div class="card">
        <!-- NAVIAGATIONS OF TABS -->
        <div class="card-body col-md-12 col-12 d-flex justify-content-between pb-4">
            <ul class="nav nav-tabs col-md-9 col-12" id="LeaveRequestTabs">
                <li class="nav-item cursor-pointer col-md-4">
                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#Pending_Leave">
                       <i class="fa-solid fa-calendar-plus me-2"></i>Recommended Leaves</a>
                </li>
                <li class="nav-item cursor-pointer col-md-4">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Approved_leave">
                        <i class="fa-solid fa-calendar-check me-2"></i>Approved Leaves</a>
                </li>
                <li class="nav-item cursor-pointer col-md-4">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#Rejected_Leave">
                        <i class="fa-solid fa-calendar-xmark me-2"></i>Disapproved Leaves</a>
                </li>
            </ul>
        </div>
        <!-- CONTENTS -->
        <div class="card-body pt-0">
            <div class="tab-content">
                <!-- Pending Leaves -->
                <div class="tab-pane text-center table-body fade show active" id="Pending_Leave" role="tabpanel">
                    <table class="table table-bordered table-sm">
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
                            if($RecommendedLeave){
                                $count = 1; 
                                    foreach($RecommendedLeave as $recommended) : ?>
                                    <tr>
                                        <th><?= $count++ ?></th>
                                        <th><?= htmlspecialchars($recommended["firstname"]) . " " . htmlspecialchars(substr($recommended["middlename"], 0, 1)) . ". " . htmlspecialchars($recommended["lastname"]) ?></th>
                                        <th><?= htmlspecialchars($recommended["leaveType"]) ?></th>
                                        <th>
                                            <?php 
                                                $stmt = $pdo->prepare("SELECT inclusive_date FROM leave_date ld
                                                LEFT JOIN leaveReq lr ON ld.leave_id = lr.leave_id
                                                WHERE lr.employee_id = :employee_id AND lr.leave_id = :leave_id");
                                                $stmt->execute(['employee_id' => $recommended["employee_id"], 'leave_id' => $recommended["leave_id"]]);
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
                                        <th><?= htmlspecialchars($recommended["leaveStatus"]) ?></th>
                                        <th><a href="index.php?page=contents/viewLeave&leave_id=<?= htmlspecialchars($recommended["leave_id"]) ?>" ><button class="btn btn-sm btn-danger px-3 view-leave-details" data-id="${leave.leave_id}">
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
                        <table class="table table-bordered table-sm">
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
                            $stmt = $pdo->prepare("SELECT 
                                    lr.leave_id,
                                    lr.leaveType,
                                    lr.leaveStatus,
                                    lr.Purpose,
                                    lr.numberOfDays,
                                    lr.contact,
                                    lr.request_date,
                                    ed.employee_id,
                                    ed.firstname,
                                    ed.middlename,
                                    ed.lastname,
                                    ed.suffix,
                                    hd.employeeID
                                FROM leaveReq lr
                                INNER JOIN employee_data ed ON lr.employee_id = ed.employee_id
                                INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
                                WHERE lr.leaveStatus = 'Approved'
                                ORDER BY lr.request_date DESC");
                            $stmt->execute();

                            $countApproved = 1;

                            $ApprovedLeave = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            if($ApprovedLeave){
                            foreach($ApprovedLeave as $approved) : ?>
                            <tr>
                                <th><?= $countApproved++ ?></th>
                                <th><?= htmlspecialchars($approved["firstname"]) . " " . htmlspecialchars(substr($approved["middlename"], 0, 1)) . ". " . htmlspecialchars($approved["lastname"]) ?></th>
                                <th><?= htmlspecialchars($approved["leaveType"]) ?></th>
                                <th>
                                        <?php 
                                            $stmt = $pdo->prepare("SELECT inclusive_date FROM leave_date ld
                                            LEFT JOIN leaveReq lr ON ld.leave_id = lr.leave_id
                                            WHERE lr.employee_id = :employee_id AND lr.leave_id = :leave_id");
                                            $stmt->execute(['employee_id' => $approved["employee_id"], 'leave_id' => $approved["leave_id"]]);
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
                                <th><?= htmlspecialchars($approved["leaveStatus"]) ?></th>
                                <th><a href="index.php?page=contents/reviewLeave&leave_id=<?= htmlspecialchars($approved["leave_id"]) ?>" ><button class="btn btn-sm btn-danger px-3 view-leave-details" data-id="${leave.leave_id}">
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
                    <table class="table table-bordered table-sm">
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
                            $stmt = $pdo->prepare("SELECT 
                                    lr.leave_id,
                                    lr.leaveType,
                                    lr.leaveStatus,
                                    lr.Purpose,
                                    lr.numberOfDays,
                                    lr.contact,
                                    lr.request_date,
                                    ed.employee_id,
                                    ed.firstname,
                                    ed.middlename,
                                    ed.lastname,
                                    ed.suffix,
                                    hd.employeeID
                                FROM leaveReq lr
                                INNER JOIN employee_data ed ON lr.employee_id = ed.employee_id
                                INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
                                WHERE lr.leaveStatus = 'Disapproved'
                                ORDER BY lr.request_date DESC");
                            $stmt->execute();
                            $disapprovedLeave = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $countDisapproved = 1;
                            if($disapprovedLeave){

                            foreach($disapprovedLeave as $disapproved) : ?>
                            <tr>
                                <th><?= $countDisapproved++ ?></th>
                                <th><?= htmlspecialchars($disapproved["firstname"]) . " " . htmlspecialchars(substr($disapproved["middlename"], 0, 1)) . ". " . htmlspecialchars($disapproved["lastname"]) ?></th>
                                <th><?= htmlspecialchars($disapproved["leaveType"]) ?></th>
                                <th>
                                        <?php 
                                            $stmt = $pdo->prepare("SELECT inclusive_date FROM leave_date ld
                                            LEFT JOIN leaveReq lr ON ld.leave_id = lr.leave_id
                                            WHERE lr.employee_id = :employee_id AND lr.leave_id = :leave_id");
                                            $stmt->execute(['employee_id' => $disapproved["employee_id"], 'leave_id' => $disapproved["leave_id"]]);
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
<script src="../../assets/js/hr_js/admin/leave.js" defer></script>