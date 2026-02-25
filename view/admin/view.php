<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once '../../authentication/config.php';
// System Fetching (GLOBAL) ===================================================================================
    function getUnitSection(){
        try {
            $pdo = db_connect();
            $stmt = $pdo->prepare("SELECT * FROM unit_section");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'An error occured: ' . $e->getMessage();
        }
    }
    function getJobtitles(){
        $pdo = db_connect();
        $stmt = $pdo->prepare("SELECT * FROM jobtitles");
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
        
        $employee_id = (int)$_GET["id"];
        
        $sql = "
            SELECT 
                j.*,
                ed.*,
                d.*,
                hd.*,
                s.*,
                lc.*,
                us.unit_section_name
            FROM employee_data ed
            LEFT JOIN hr_data hd
                ON ed.employee_id = hd.employee_id
            LEFT JOIN jobTitles j
                ON hd.jobtitle_id = j.jobTitles_id
            LEFT JOIN schedule s
                ON ed.employee_id = s.employee_id
            LEFT JOIN departments d
                ON hd.Department_id = d.Department_id
            LEFT JOIN leaveCounts lc
                ON ed.employee_id = lc.employee_id
            LEFT JOIN unit_section us
                ON hd.unit_section_id = us.unit_section_id
            WHERE ed.employee_id = ?
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$employee_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

// HR data fetching ==================================================================================
    function getHrData(){
        $pdo = db_connect();
        if($_SESSION["hrData"]["employee_id"]){
            $hr_id = $_SESSION["hrData"]["employee_id"];
        }else{
            $hr_id = null;
        }
        $query = "SELECT jobtitles.*, employee_data.*, departments.*, hr_data.*, us.unit_section_id, us.unit_section_name FROM employee_data
        INNER JOIN hr_data ON employee_data.employee_id = hr_data.employee_id
        INNER JOIN jobtitles ON hr_data.jobtitle_id = jobtitles.jobtitles_id
        INNER JOIN departments ON hr_data.Department_id = departments.Department_id
        LEFT JOIN unit_section us ON hr_data.unit_section_id = us.unit_section_id
        WHERE employee_data.employee_id = :employee_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['employee_id' => $hr_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

// Get employees for scheduling ======================================================================   
    function getEmployeesForSchedule(){
        $pdo = db_connect();
        $stmt = $pdo->prepare("SELECT ed.profile_picture, hd.employeeID, ed.employee_id, ed.firstname, ed.middlename, ed.lastname, ed.suffix,
            d.Department_name, d.Department_code, ed.employee_id FROM employee_data ed
            INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
            LEFT JOIN departments d ON hd.Department_id = d.Department_id
            ORDER BY ed.lastname DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// Get employees via recruitiment module =============================================================
    function getActiveEmployees(){
        $pdo = db_connect();
        $stmtOfficial = $pdo->prepare("
            SELECT 
                ed.employee_id, 
                ed.firstname, 
                ed.middlename, 
                ed.lastname, 
                ed.suffix,
                ed.profile_picture,
                d.Department_name AS department,
                hd.employeeID,
                jt.jobTitle,
                jt.salary,
                ed.status,
                ed.user_role
            FROM employee_data ed
            INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
            LEFT JOIN jobTitles jt ON hd.jobtitle_id = jt.jobTitles_id
            LEFT JOIN departments d ON hd.Department_id = d.Department_id
            WHERE ed.status = 'Active' AND ed.user_role = 'EMPLOYEE'
            ORDER BY ed.status
        ");
        $stmtOfficial->execute();
        return $stmtOfficial->fetchAll(PDO::FETCH_ASSOC);
    }
    function getPendingEmployees(){
        $pdo = db_connect();
        $stmtPending = $pdo->prepare("
            SELECT 
                ed.employee_id, 
                ed.firstname, 
                ed.middlename, 
                ed.lastname, 
                ed.suffix,
                ed.profile_picture,
                d.Department_name AS department,
                hd.employeeID,
                jt.jobTitle,
                jt.salary,
                ed.status
            FROM employee_data ed
            INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
            LEFT JOIN jobTitles jt ON hd.jobtitle_id = jt.jobTitles_id
            LEFT JOIN departments d ON hd.Department_id = d.Department_id
            WHERE ed.status = 'Pending' AND ed.user_role = 'EMPLOYEE'
            ORDER BY ed.lastname, ed.firstname
        ");
        $stmtPending->execute();
        return $stmtPending->fetchAll(PDO::FETCH_ASSOC);
    }
    function getInactiveEmployees(){
        $pdo = db_connect();
        $stmtInactive = $pdo->prepare("
            SELECT 
                ed.employee_id, 
                ed.firstname, 
                ed.middlename, 
                ed.lastname, 
                ed.suffix,
                ed.profile_picture,
                d.Department_name AS department,
                hd.employeeID,
                jt.jobTitle,
                jt.salary,
                ed.status,
                ed.user_role
            FROM employee_data ed
            INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
            LEFT JOIN jobTitles jt ON hd.jobtitle_id = jt.jobTitles_id
            LEFT JOIN departments d ON hd.Department_id = d.Department_id
            WHERE ed.status = 'Inactive' AND ed.user_role = 'EMPLOYEE'
            ORDER BY ed.lastname, ed.firstname
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
            ed.employee_id,
            ed.firstname,
            ed.middlename,
            ed.lastname,
            ed.suffix,
            hd.employeeID
            FROM leaveReq lr
            INNER JOIN employee_data ed ON lr.employee_id = ed.employee_id
            INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
            WHERE lr.leaveStatus = 'Recommended'
            ORDER BY lr.request_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }