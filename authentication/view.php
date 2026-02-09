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
            jobTitles.*,
            employee_data.*,
            departments.*,
            hr_data.*,
            schedule.*,
            leaveCounts.*
        FROM employee_data
        INNER JOIN hr_data 
            ON employee_data.employee_id = hr_data.employee_id
        INNER JOIN jobTitles 
            ON hr_data.jobtitle_id = jobTitles.jobTitles_id
        INNER JOIN schedule 
            ON employee_data.employee_id = schedule.employee_id
        INNER JOIN departments 
            ON hr_data.Department_id = departments.Department_id
        INNER JOIN leaveCounts 
            ON employee_data.employee_id = leaveCounts.employee_id
        WHERE employee_data.employee_id = :employee_id
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
