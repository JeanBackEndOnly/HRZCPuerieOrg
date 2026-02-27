<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../../view/hr/view.php";
include "../../view/system/view.php";

// Global fetching ========================================================================
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


// Get Employee for profiling ============================================================
    $getEmployee = getEmployees();
    if (!$getEmployee) {
        $_SESSION['error'] = isset($_GET["id"]) ? "Employee not found" : "No employee ID provided";
        $getEmployee = null; 
    }

// Get own data for Settings =============================================================
    $hr_data = getHrData();
    if(!$hr_data){
        $hr_data = null;
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

// Employee careerpath ====================================================================
    $employeeCareerPath = getCareerPathHistory();
    if(!$employeeCareerPath){
        $_SESSION['error'] = "Failed to fetch employees data";
        $employeeCareerPath = null;
    }

// Leave MOdule ========================================================================
    $RecommendedLeave = getRecommendedLeave();
    if(!$RecommendedLeave){
        $_SESSION['error'] = "Failed to fetch employees data";
        $RecommendedLeave = null;
    }
    $PendingLeave = getPendingLeave();
    if(!$PendingLeave){
        $_SESSION['error'] = "Failed to fetch employees data";
        $PendingLeave = null;
    }
    $DisapprovedLeave = getDisapprovedLeave();
    if(!$DisapprovedLeave){
        $_SESSION['error'] = "Failed to fetch employees data";
        $DisapprovedLeave = null;
    }

// EMployee schedules fetching ============================================================
    $getEmployeeForSchedules = getEmployeesForSchedule();
    if(!$getEmployeeForSchedules){
        $_SESSION['error'] = "Failed to fetch employees data";
        $getEmployeeForSchedules = null;
    }
?>