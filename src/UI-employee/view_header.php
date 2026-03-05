<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../authentication/view/employee_view.php';
include '../../authentication/view/system_view.php';

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

// Get notifications ============================================
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