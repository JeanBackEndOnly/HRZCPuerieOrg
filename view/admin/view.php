<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once '../../authentication/config.php';
    // System Fetching ==================================================================================
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
        

