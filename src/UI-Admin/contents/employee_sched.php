<?php
    $employee_id = $_GET["employee_id"];
    $stmt = $pdo->prepare("SELECT ed.*, hd.* FROM employee_data ed
        INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id 
        WHERE ed.employee_id = ?");
    $stmt->execute([$employee_id]);
    $employeeData = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmtSchedule = $pdo->prepare("SELECT es.*, st.* FROM employee_schedule es
    INNER JOIN sched_template st ON es.schedule_id = st.template_id
    WHERE es.employee_id = ?");
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
     <div class="column p-2 m-0 rounded-2 col-12 col-md-4">
            <div class="card rounded-2">
                <div class="d-flex flex-column w-100 align-items-center justify-content-center p-2">
                    <div class="w-100 d-flex justify-content-start ps-3 pt-1">
                        <a href="index.php?page=contents/recruitment" class="btn btn-danger btn-sm"><i
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
                        <span class="text-center"><?= isset($employeeData["unit_section_name"]) ? ' (' . htmlspecialchars($employeeData["unit_section_name"]) . ')' : '' ?></span>
                    <span id="employeeJobTitle"><?= htmlspecialchars($employeeData["jobTitle"]) ?></span>
                    <span id="employeeSchedule" class="fw-bold"></span>
                    <a href="index.php?page=contents/pds&employee_id=<?= $employee_id ?>"
                        class="mt-2"><strong>View Personal Data Sheet <i
                                class="fa-solid fa-arrow-up-right-from-square ms-2"></i></strong></a>
                </div>
            </div>
        </div>
    <div class="col-md-8">

    </div>
</main>