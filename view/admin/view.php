<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once '../../authentication/config.php';
// System Fetching (GLOBAL) ===================================================================================
    function getUnitSection(){
        try {
            $pdo = db_connect();
            $stmt = $pdo->prepare("SELECT us.*, d.Department_name, d.Department_code, d.Department_id FROM unit_section us
                LEFT JOIN departments d ON us.department_id = d.Department_id
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'An error occured: ' . $e->getMessage();
        }
    }
    function getJobtitles(){
        $pdo = db_connect();
        $stmt = $pdo->prepare("SELECT j.*, d.Department_name FROM jobtitles j
        LEFT JOIN departments d ON j.department_id = d.Department_id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getDedpartments(){
        $pdo = db_connect();
        $stmt = $pdo->prepare("SELECT * FROM departments");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// employee fetching =================================================================================
    function getEmployees(){
        $pdo = db_connect();
        
        if (!isset($_GET["id"]) || empty($_GET["id"])) {
            return ['employee_data' => null, 'error' => 'No employee ID provided'];
        }
        
        if (!is_numeric($_GET["id"])) {
            return ['employee_data' => null, 'error' => 'Invalid employee ID format'];
        }
        
        $user_id = (int)$_GET["id"];
        
        $sql = "
            SELECT 
                j.*,
                u.*,
                d.*,
                ed.*,
                s.*,
                lc.*,
                us.unit_section_name
            FROM users u
            INNER JOIN employee_data ed
                ON u.user_id = ed.user_id
            LEFT JOIN jobTitles j
                ON ed.jobtitle_id = j.jobTitles_id
            LEFT JOIN schedule s
                ON u.user_id = s.user_id
            LEFT JOIN departments d
                ON ed.Department_id = d.Department_id
            LEFT JOIN leaveCounts lc
                ON u.user_id = lc.user_id
            LEFT JOIN unit_section us
                ON ed.unit_section_id = us.unit_section_id
            WHERE u.user_id = ?
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

// HR data fetching ==================================================================================
    function getHrData(){
        $pdo = db_connect();
        if($_SESSION["hrData"]["user_id"]){
            $hr_id = $_SESSION["hrData"]["user_id"];
        }else{
            $hr_id = null;
        }
        $query = "SELECT jobtitles.*, users.*, departments.*, employee_data.*, us.unit_section_id, us.unit_section_name FROM users
        INNER JOIN employee_data ON users.user_id = employee_data.user_id
        INNER JOIN jobtitles ON employee_data.jobtitle_id = jobtitles.jobtitles_id
        INNER JOIN departments ON employee_data.Department_id = departments.Department_id
        LEFT JOIN unit_section us ON employee_data.unit_section_id = us.unit_section_id
        WHERE users.user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['user_id' => $hr_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

// ADMIN DATA ========================================================================================
    function getAdminData(){
        $pdo = db_connect();
        if($_SESSION["adminData"]["user_id"]){
            $admin_id = $_SESSION["adminData"]["user_id"];
        }else{
            $admin_id = null;
        }
        $query = "SELECT jobtitles.*, users.*, departments.*, employee_data.*, us.unit_section_id, us.unit_section_name 
        FROM users
        INNER JOIN employee_data ON users.user_id = employee_data.user_id
        LEFT JOIN jobtitles ON employee_data.jobtitle_id = jobtitles.jobtitles_id
        LEFT JOIN departments ON employee_data.Department_id = departments.Department_id
        LEFT JOIN unit_section us ON employee_data.unit_section_id = us.unit_section_id
        WHERE users.user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['user_id' => $admin_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

// Get employees for scheduling ======================================================================   
    function getEmployeesForSchedule(){
        $pdo = db_connect();
        $stmt = $pdo->prepare("SELECT u.profile_picture, u.employeeID, u.firstname, u.middlename, u.lastname, u.suffix,
            d.Department_name, d.Department_code, u.user_id FROM users u
            INNER JOIN employee_data ed ON u.user_id = ed.user_id
            LEFT JOIN departments d ON ed.Department_id = d.Department_id
            ORDER BY u.lastname DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// Get employees via recruitiment module =============================================================
    function getActiveEmployees(){
        $pdo = db_connect();
        $stmtOfficial = $pdo->prepare("
            SELECT 
                u.user_id, 
                u.firstname, 
                u.middlename, 
                u.lastname, 
                u.suffix,
                u.profile_picture,
                d.Department_name AS department,
                u.employeeID,
                jt.jobTitle,
                jt.salary,
                u.status,
                u.user_role
            FROM users u
            INNER JOIN employee_data ed ON u.user_id = ed.user_id
            LEFT JOIN jobTitles jt ON ed.jobtitle_id = jt.jobTitles_id
            LEFT JOIN departments d ON ed.Department_id = d.Department_id
            WHERE u.status = 'Active' AND u.user_role = 'EMPLOYEE'
            ORDER BY u.status
        ");
        $stmtOfficial->execute();
        return $stmtOfficial->fetchAll(PDO::FETCH_ASSOC);
    }
    function getPendingEmployees(){
        $pdo = db_connect();
        $stmtPending = $pdo->prepare("
            SELECT 
                u.user_id, 
                u.firstname, 
                u.middlename, 
                u.lastname, 
                u.suffix,
                u.profile_picture,
                d.Department_name AS department,
                u.employeeID,
                jt.jobTitle,
                jt.salary,
                u.status
            FROM users u
            INNER JOIN employee_data ed ON u.user_id = ed.user_id
            LEFT JOIN jobTitles jt ON ed.jobtitle_id = jt.jobTitles_id
            LEFT JOIN departments d ON ed.Department_id = d.Department_id
            WHERE u.status = 'Pending' AND u.user_role = 'EMPLOYEE'
            ORDER BY u.lastname, u.firstname
        ");
        $stmtPending->execute();
        return $stmtPending->fetchAll(PDO::FETCH_ASSOC);
    }
    function getInactiveEmployees(){
        $pdo = db_connect();
        $stmtInactive = $pdo->prepare("
            SELECT 
                u.user_id, 
                u.firstname, 
                u.middlename, 
                u.lastname, 
                u.suffix,
                u.profile_picture,
                d.Department_name AS department,
                u.employeeID,
                jt.jobTitle,
                jt.salary,
                u.status,
                u.user_role
            FROM users u
            INNER JOIN employee_data ed ON u.user_id = ed.user_id
            LEFT JOIN jobTitles jt ON ed.jobtitle_id = jt.jobTitles_id
            LEFT JOIN departments d ON ed.Department_id = d.Department_id
            WHERE u.status = 'Inactive' AND u.user_role = 'EMPLOYEE'
            ORDER BY u.lastname, u.firstname
        ");
        $stmtInactive->execute();
        return $stmtInactive->fetchAll(PDO::FETCH_ASSOC);
    }

// Get Leaves ========================================================================================
    function getRecommendedLeave(){
        $pdo = db_connect();
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
            WHERE lr.leaveStatus = 'Recommended'
            ORDER BY lr.request_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getApprovedLeave(){
        $pdo = db_connect();
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
            WHERE lr.leaveStatus = 'Approved'
            ORDER BY lr.request_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getDisapprovedLeave(){
        $pdo = db_connect();
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
            WHERE lr.leaveStatus = 'Disapproved'
            ORDER BY lr.request_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// Career Path History ==============================================================================
    function getCareerPathHistory(){
        $pdo = db_connect();
        if($_SESSION["adminData"]["user_id"]){
            $user_id = $_SESSION["adminData"]["user_id"];
        }else if($_GET["id"]){
            $user_id = $_GET["id"];
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