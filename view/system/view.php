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

