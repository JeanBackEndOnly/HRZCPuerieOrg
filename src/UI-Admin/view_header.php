<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../../view/admin/view.php";
include "../../view/system/view.php";


// GLOBAL COUNTS FOR SYSTEM, EMPLOYEES AND LEAVES =================================
    // Leaves ==========================================
        $leavePendingCounts = leavePendingCounts();
        if (empty($leavePendingCounts)) {
            $_SESSION['error'] = "Failed to load unit sections";
            $leavePendingCounts = null; 
        }
        $leaveRecommendedCounts = leaveRecommendedCounts();
        if (empty($leaveRecommendedCounts)) {
            $_SESSION['error'] = "Failed to load Designations";
            $leaveRecommendedCounts = null; 
        }
        $leaveApprovedCounts = leaveApprovedCounts();
        if (empty($leaveApprovedCounts)) {
            $_SESSION['error'] = "Failed to load Designations";
            $leaveApprovedCounts = null; 
        }
        $leaveDisapprovedCounts = leaveDisapprovedCounts();
        if (empty($leaveDisapprovedCounts)) {
            $_SESSION['error'] = "Failed to load Designations";
            $leaveDisapprovedCounts = null; 
        }
    // Accounts ==========================================
        $AccountPendingCounts = AccountPendingCounts();
        if (empty($AccountPendingCounts)) {
            $_SESSION['error'] = "Failed to load unit sections";
            $AccountPendingCounts = null; 
        }
        $AccountActiveCounts = AccountActiveCounts();
        if (empty($AccountActiveCounts)) {
            $_SESSION['error'] = "Failed to load Designations";
            $AccountActiveCounts = null; 
        }
        $AccountInactiveCounts = AccountInactiveCounts();
        if (empty($AccountInactiveCounts)) {
            $_SESSION['error'] = "Failed to load Designations";
            $AccountInactiveCounts = null; 
        }
    // system ==========================================
        $DepartmentsCounts = DepartmentsCounts();
        if (empty($DepartmentsCounts)) {
            $_SESSION['error'] = "Failed to load unit sections";
            $DepartmentsCounts = null; 
        }
        $UnitsCounts = UnitsCounts();
        if (empty($UnitsCounts)) {
            $_SESSION['error'] = "Failed to load Designations";
            $UnitsCounts = null; 
        }
        $DesignationsCounts = DesignationsCounts();
        if (empty($DesignationsCounts)) {
            $_SESSION['error'] = "Failed to load Designations";
            $DesignationsCounts = null; 
        }
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

// announcement matters ====================================================
$getUsersForAnnouncement = getUsersForAnnouncement();
if(!$getUsersForAnnouncement){
    $_SESSION['error'] = "Failed to fetch employees data";
    $getUsersForAnnouncement = null;
}
$getPrivateMessages = getPrivateMessages();
if(!$getPrivateMessages){
    $_SESSION['error'] = "Failed to fetch employees data";
    $getPrivateMessages = null;
}
$getPublicMessages = getPublicMessages();
if(!$getPublicMessages){
    $_SESSION['error'] = "Failed to fetch employees data";
    $getPublicMessages = null;
}
$getSentMessages = getSentMessages();
if(!$getSentMessages){
    $_SESSION['error'] = "Failed to fetch employees data";
    $getSentMessages = null;
}

// get notifications ============================================
$getNotifications = getNotifications();
if(!$getNotifications){
    $_SESSION['error'] = "Failed to fetch employees data";
    $getNotifications = null;
}
$notificationCounts = notificationCounts();
if(!$notificationCounts){
    $_SESSION['error'] = "Failed to fetch employees data";
    $notificationCounts = null;
}
?>