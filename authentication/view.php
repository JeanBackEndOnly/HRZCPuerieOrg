<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

function getEmployees(){
    $pdo = db_connect();
    $employee_id = $_GET["id"] ?? null;

    $sql = "
        SELECT 
            j.*,
            ed.*,
            d.*,
            hd.*,
            s.*,
            lc.*,
            us.unit_section_name
        FROM employee_data ed
        INNER JOIN hr_data hd
            ON ed.employee_id = hd.employee_id
        INNER JOIN jobTitles j
            ON hd.jobtitle_id = j.jobTitles_id
        INNER JOIN schedule s
            ON ed.employee_id = s.employee_id
        INNER JOIN departments d
            ON hd.Department_id = d.Department_id
        INNER JOIN leaveCounts lc
            ON ed.employee_id = lc.employee_id
        INNER JOIN unit_section us
            ON hd.unit_section_id = us.unit_section_id
        WHERE ed.employee_id = :employee_id
    ";

    $stmt = $pdo->prepare($sql);

    if (!$stmt) {
        die(print_r($pdo->errorInfo(), true)); 
    }

    $stmt->execute([
        ':employee_id' => $employee_id
    ]);

    return [
        'employee_data' => $stmt->fetch(PDO::FETCH_ASSOC)
    ];
}
