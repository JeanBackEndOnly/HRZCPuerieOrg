<?php
    $employee_id = $_GET["employee_id"];
    $stmt = $pdo->prepare("SELECT * FROM employee_schedule es
        INNER JOIN sched_template st ON es.schedule_id = st.template_id 
        WHERE employee_id = ?");
    $stmt->execute([$employee_id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main class="col-md-12 d-flex justify-content-start align-items-start">
    <div class="col-md-6">
        this is for employee profile
    </div>
    <div class="col-md-6">
        this is the time schedules
    </div>
</main>