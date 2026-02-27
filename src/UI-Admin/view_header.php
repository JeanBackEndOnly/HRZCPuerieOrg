<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../../view/admin/view.php";
include "../../view/system/view.php";
// Global ==========================================================================
$getUnit = getUnitSection();
if (empty($getUnit)) {
    $_SESSION['error'] = "Failed to load unit sections";
    $getUnit = []; 
}
$getDesignations = getJobtitles();
if (empty($getDesignations)) {
    $_SESSION['error'] = "Failed to load Designations";
    $getDesignations = []; 
}
$getDedpartments = getDedpartments();
if (empty($getDedpartments)) {
    $_SESSION['error'] = "Failed to load Designations";
    $getDedpartments = []; 
}

// Global ============================================================================
$getEmployee = getEmployees();
if (!$getEmployee) {
    $_SESSION['error'] = isset($_GET["id"]) ? "Employee not found" : "No employee ID provided";
    $getEmployee = null; 
}

// ADMIN DATA ========================================================================
$getAdminData = getAdminData();
if (!$getAdminData) {
    $_SESSION['error'] = isset($_GET["id"]) ? "Employee not found" : "No employee ID provided";
    $getAdminData = null; 
}

// Schedule settings =================================================================
$getEmployeeForSchedules = getEmployeesForSchedule();
if(!$getEmployeeForSchedules){
    $_SESSION['error'] = "Failed to fetch employees data";
    $getEmployeeForSchedules = null;
}

// Recruitement module =================================================================
$ActiveEmployees = getActiveEmployees();
if(!$ActiveEmployees){
    $_SESSION['error'] = "Failed to fetch employees data";
    $ActiveEmployees = null;
}
$PendingEmployees = getPendingEmployees();
if(!$PendingEmployees){
    $_SESSION['error'] = "Failed to fetch employees data";
    $PendingEmployees = null;
}
$InactiveEmployees = getInactiveEmployees();
if(!$InactiveEmployees){
    $_SESSION['error'] = "Failed to fetch employees data";
    $InactiveEmployees = null;
}

// Leave MOdule ========================================================================
$RecommendedLeave = getRecommendedLeave();
$_SESSION["RecommendedLeaveData"] =  $RecommendedLeave;
if(!$RecommendedLeave){
    $_SESSION['error'] = "Failed to fetch employees data";
    $RecommendedLeave = null;
}
$ApprovedLeave = getApprovedLeave();
if(!$ApprovedLeave){
    $_SESSION['error'] = "Failed to fetch employees data";
    $ApprovedLeave = null;
}
$DisapprovedLeave = getDisapprovedLeave();
if(!$DisapprovedLeave){
    $_SESSION['error'] = "Failed to fetch employees data";
    $DisapprovedLeave = null;
}

// Career Path History ==================================================================
$employeeCareerPath = getCareerPathHistory();
if(!$employeeCareerPath){
    $_SESSION['error'] = "Failed to fetch employees data";
    $employeeCareerPath = null;
}
?>