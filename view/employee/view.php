<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once '../../authentication/config.php';

    $employeeID = $_SESSION['employeeData']['employeeID'] ?? '';
    $position = $_SESSION['employeeData']['employee_position'] ?? '';
    $department = $_SESSION['employeeData']['employee_department'] ?? '';
    $firstname = $_SESSION['employeeData']['firstname'] ?? '';
    $middelname = $_SESSION['employeeData']['middlename'] ?? '';
    $lastname = $_SESSION['employeeData']['lastname'] ?? '';
    $profile_picture = $_SESSION['employeeData']['profile_picture'] ?? '';
    $user_id = $_SESSION['employeeData']['user_id'] ?? '';
    verify_init($user_id);

// Get Leaves ========================================================================================
    function getPendingLeave(){
        $pdo = db_connect();
        $user_id = $_SESSION["employeeData"]["user_id"] ?? null;
        $stmt = $pdo->prepare("SELECT 
            lr.leave_id,
            lr.leaveType,
            lr.leaveStatus,
            lr.Purpose,
            lr.numberOfDays,
            lr.contact,
            lr.request_date,
            u.user_id,
            u.firstname,
            u.middlename,
            u.lastname,
            u.suffix,
            u.employeeID
            FROM leaveReq lr
            INNER JOIN users u ON lr.user_id = u.user_id
            WHERE lr.leaveStatus = 'Pending' AND u.user_id = ?
            ORDER BY lr.request_date DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getRecommendedLeave(){
        $pdo = db_connect();
        $user_id = $_SESSION["employeeData"]["user_id"] ?? null;
        $stmt = $pdo->prepare("SELECT 
            lr.leave_id,
            lr.leaveType,
            lr.leaveStatus,
            lr.Purpose,
            lr.numberOfDays,
            lr.contact,
            lr.request_date,
            u.user_id,
            u.firstname,
            u.middlename,
            u.lastname,
            u.suffix,
            u.employeeID
            FROM leaveReq lr
            INNER JOIN users u ON lr.user_id = u.user_id
            WHERE lr.leaveStatus = 'Recommended' AND u.user_id = ?
            ORDER BY lr.request_date DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getApprovedLeave(){
        $pdo = db_connect();
        $user_id = $_SESSION["employeeData"]["user_id"] ?? null;
        $stmt = $pdo->prepare("SELECT 
            lr.leave_id,
            lr.leaveType,
            lr.leaveStatus,
            lr.Purpose,
            lr.numberOfDays,
            lr.contact,
            lr.request_date,
            u.user_id,
            u.firstname,
            u.middlename,
            u.lastname,
            u.suffix,
            u.employeeID
            FROM leaveReq lr
            INNER JOIN users u ON lr.user_id = u.user_id
            WHERE lr.leaveStatus = 'Approved' AND u.user_id = ?
            ORDER BY lr.request_date DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getDisapprovedLeave(){
        $pdo = db_connect();
        $user_id = $_SESSION["employeeData"]["user_id"] ?? null;
        $stmt = $pdo->prepare("SELECT 
            lr.leave_id,
            lr.leaveType,
            lr.leaveStatus,
            lr.Purpose,
            lr.numberOfDays,
            lr.contact,
            lr.request_date,
            u.user_id,
            u.firstname,
            u.middlename,
            u.lastname,
            u.suffix,
            u.employeeID
            FROM leaveReq lr
            INNER JOIN users u ON lr.user_id = u.user_id
            WHERE lr.leaveStatus = 'Disapproved' AND u.user_id = ?
            ORDER BY lr.request_date DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// Fetch own Data =============================================================
    function getEmployeeData(){
        $pdo = db_connect();
        if(isset($_SESSION["employeeData"]["user_id"]) && $_SESSION["employeeData"]["user_id"] !== ''){
            $employee_id = $_SESSION["employeeData"]["user_id"];
        }else{
            $employee_id = null;
        }
        $query = "SELECT jobtitles.*, lc.*, users.*, departments.*, employee_data.*, us.unit_section_id, us.unit_section_name FROM users
        INNER JOIN employee_data ON users.user_id = employee_data.user_id
        INNER JOIN jobtitles ON employee_data.jobtitle_id = jobtitles.jobtitles_id
        INNER JOIN departments ON employee_data.Department_id = departments.Department_id
        INNER JOIN leaveCounts lc ON users.user_id = lc.user_id
        LEFT JOIN unit_section us ON employee_data.unit_section_id = us.unit_section_id
        WHERE users.user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['user_id' => $employee_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

// Career Path History ==============================================================================
    function employeeCareerPath(){
        $pdo = db_connect();
        if(isset($_SESSION["employeeData"]["user_id"]) && $_SESSION["employeeData"]["user_id"] !== ''){
            $user_id = $_SESSION["employeeData"]["user_id"];
        }else{
            $user_id = null;
        }
        $stmt = $pdo->prepare("SELECT 
            jh.job_historyID,
            u.user_id,
            u.firstname,
            u.lastname,
            jh.job_from,
            jh.job_to,
            jh.job_status,
            jh.addAt
            FROM job_history jh
            JOIN users u ON jh.user_id = u.user_id
            WHERE u.user_id = ?
            ORDER BY jh.addAt ASC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// fetch users for announcement ==========================
    function getUsersForAnnouncement(){
        $pdo = db_connect();
        $stmt = $pdo->prepare("SELECT * FROM users u WHERE employee_type = 'head'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getPrivateMessages(){
        $pdo = db_connect();
        $user_id = $_SESSION["employeeData"]["user_id"] ?? null;
        $stmt = $pdo->prepare("SELECT * FROM announcement WHERE user_id = ? AND announcement_type = 'private' ORDER BY announce_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getPublicMessages(){
        $pdo = db_connect();
        $stmt = $pdo->prepare("SELECT * FROM announcement WHERE announcement_type = 'public' ORDER BY announce_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getSentMessages(){
        $pdo = db_connect();
        $user_id = $_SESSION["employeeData"]["user_id"] ?? null;
        $stmt = $pdo->prepare("SELECT * FROM announcement WHERE announce_by = ? ORDER BY announce_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }