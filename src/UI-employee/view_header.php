<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../../view/employee/view.php";
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

// Leave MOdule ========================================================================
$PendingLeave = getPendingLeave();
if(!$PendingLeave){
    $_SESSION['error'] = "Failed to fetch employees leave data";
    $PendingLeave = null;
}
$RecommendedLeave = getRecommendedLeave();
if(!$RecommendedLeave){
    $_SESSION['error'] = "Failed to fetch employees leave data";
    $RecommendedLeave = null;
}
$ApprovedLeave = getApprovedLeave();
if(!$ApprovedLeave){
    $_SESSION['error'] = "Failed to fetch employees leave data";
    $ApprovedLeave = null;
}
$DisapprovedLeave = getDisapprovedLeave();
if(!$DisapprovedLeave){
    $_SESSION['error'] = "Failed to fetch employees leave data";
    $DisapprovedLeave = null;
}

// Own employee data ==================================================================
$getEmployeeData = getEmployeeData(); 
if(!$getEmployeeData){
    $_SESSION['error'] = "Failed to fetch employees leave data";
    $getEmployeeData = null;
}
$employeeCareerPath = employeeCareerPath(); 
if(!$employeeCareerPath){
    $_SESSION['error'] = "Failed to fetch employees leave data";
    $employeeCareerPath = null;
}
?>