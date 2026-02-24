<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../../view/admin/view.php";

$getUnit = getUnitSection();
if (empty($getUnit)) {
    $_SESSION['error'] = "Failed to load unit sections";
    $getUnit = []; 
}

$getEmployee = getEmployees();
if (!$getEmployee) {
    $_SESSION['error'] = isset($_GET["id"]) ? "Employee not found" : "No employee ID provided";
    $getEmployee = null; 
}

$getEmployeeForSchedules = getEmployeesForSchedule();
if(!$getEmployeeForSchedules){
    $_SESSION['error'] = "Failed to fetch employees data";
    $getEmployeeForSchedules = null;
}

$get_Employee_Schedules = getEmployeesSchedule();
if(!$get_Employee_Schedules){
    $_SESSION['error'] = "Failed to fetch employees data";
    $get_Employee_Schedules = null;
}
?>