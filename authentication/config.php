<?php
function db_connect()
{
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'ZClient_DB';

    try {
        // Step 1: Initial connection to MySQL (no DB yet)
        $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Step 2: Create the database if it doesn't exist
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

        // Step 3: Reconnect using the newly created database
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Step 4: Define table structure
        $tableQueries = [
            "CREATE TABLE IF NOT EXISTS departments(
                Department_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                Department_name VARCHAR(50) NOT NULL,
                Department_code VARCHAR(50),
                addAt datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS unit_section(
                unit_section_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                department_id INT,
                unit_section_name VARCHAR(50) NOT NULL,
                addAt datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY(department_id) REFERENCES departments(Department_id)
            )",
            "CREATE TABLE IF NOT EXISTS jobTitles(
                jobTitles_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                jobTitle VARCHAR(50) NOT NULL,
                jobTitle_code VARCHAR(10) NOT NULL,
                salary DECIMAL(12,2) NOT NULL,
                department_id INT,
                addAt datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY(department_id) REFERENCES departments(Department_id)
                ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS admin (
                admin_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                admin_firstname VARCHAR(50) NOT NULL,
                admin_middlename VARCHAR(50) NOT NULL,
                admin_lastname VARCHAR(50) NOT NULL,
                admin_suffix VARCHAR(5) NOT NULL,
                joined_at VARCHAR(30) NOT NULL,
                admin_cpno VARCHAR(15) NOT NULL,
                admin_religion VARCHAR(50),
                admin_civil_status VARCHAR(50),
                admin_citizenship VARCHAR(50),
                admin_birthPlace VARCHAR(100),
                admin_birth VARCHAR(10) NOT NULL,
                admin_gender VARCHAR(10) NOT NULL,
                admin_admin_status VARCHAR(10) NOT NULL,
                admin_email VARCHAR(100) NOT NULL,
                admin_username VARCHAR(50) NOT NULL,
                admin_password VARCHAR(255) NOT NULL,
                admin_user_role VARCHAR(20) NOT NULL,
                admin_picture VARCHAR(255),
                created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS admin_info (
                admin_info_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                admin_id INT,
                admin_employee_id VARCHAR(20) NOT NULL,
                admin_position_id INT,
                admin_department_id INT,
                unit_section_id INT,
                admin_province VARCHAR(50),
                admin_city VARCHAR(50),
                admin_barangay VARCHAR(50),
                admin_subdivision VARCHAR(50),
                admin_house VARCHAR(50),
                admin_street VARCHAR(50),
                admin_zip_code VARCHAR(50),
                salary DECIMAL(12,2),
                admin_rating VARCHAR(10) NOT NULL,
                created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (unit_section_id) REFERENCES unit_section(unit_section_id),
                FOREIGN KEY (admin_id) REFERENCES admin(admin_id),
                FOREIGN KEY (admin_position_id) REFERENCES jobTitles(jobTitles_id),
                FOREIGN KEY (admin_department_id) REFERENCES departments(Department_id)
            )",
            // SYSTEM TABLE FOR FRONTEND ============================================================
            "CREATE TABLE IF NOT EXISTS system (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                admin_id INT(11) NOT NULL,
                system_title VARCHAR(50) NOT NULL,
                system_description VARCHAR(255) NOT NULL,
                system_logo VARCHAR(20) NOT NULL,
                created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",

            // HUMAN RESOURCES DATABASE =============================================================
            "CREATE TABLE IF NOT EXISTS employee_data (    
                employee_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,

                firstname VARCHAR(50) NOT NULL,
                middlename VARCHAR(50) NOT NULL,
                lastname VARCHAR(50) NOT NULL,
                suffix VARCHAR(5),
                nickname VARCHAR(7),
                employeeID VARCHAR(10) UNIQUE,
                citizenship VARCHAR(50),
                gender ENUM('MALE', 'FEMALE'),
                civil_status VARCHAR(50),
                religion VARCHAR(50),
                age VARCHAR(50),
                birthday VARCHAR(50),
                birthPlace VARCHAR(50),
                contact VARCHAR(50),
        
                status ENUM('Active', 'Inactive', 'Pending') DEFAULT 'Pending',
                username VARCHAR(50) NOT NULL,
                password VARCHAR(255) NOT NULL,
                user_role ENUM('HRSM','EMPLOYEE'),
                email VARCHAR(100) NOT NULL,

                user_request ENUM('Validated','Rejected', 'Pending'),
                reason TEXT,
                profile_picture VARCHAR(255),
                created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",
            // HUMAN RESOURCES DATABASE (PERSONAL DATA SHEET) =======================================
            "CREATE TABLE IF NOT EXISTS personal_data_sheet (
                pds_id           INT AUTO_INCREMENT PRIMARY KEY,
                employee_id INT,       
                accomplished_on DATE NOT NULL DEFAULT CURRENT_DATE,
                FOREIGN KEY (employee_id) REFERENCES employee_data(employee_id) ON DELETE CASCADE ON UPDATE CASCADE
            );",
            "CREATE TABLE IF NOT EXISTS userGovIDs (
                id           INT AUTO_INCREMENT PRIMARY KEY,
                pds_id INT NOT NULL,
                sss_no         VARCHAR(30),
                tin_no         VARCHAR(30),
                pagibig_no     VARCHAR(30),
                philhealth_no  VARCHAR(30),
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS spouseInfo (
                id              INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id        INT(11)      NOT NULL,
                spouse_surname  VARCHAR(60),
                spouse_first    VARCHAR(60),
                spouse_middle   VARCHAR(60),
                spouse_occupation      VARCHAR(80),
                spouse_employer        VARCHAR(120),
                spouse_business_address   VARCHAR(255),
                spouse_tel    VARCHAR(30),
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS children (
                id          INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id    INT(11)      NOT NULL,
                full_name   VARCHAR(120),
                dob         DATE,
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE,
                INDEX idx_child_user (pds_id)
            )",
            "CREATE TABLE IF NOT EXISTS parents (
                id           INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id     INT(11)      NOT NULL,
                relation     ENUM('Father','Mother') NOT NULL,
                surname      VARCHAR(60),
                first_name   VARCHAR(60),
                middle_name  VARCHAR(60),
                occupation   VARCHAR(80),
                address      VARCHAR(255),
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE,
                UNIQUE KEY uq_user_relation (pds_id, relation)
            )",
            "CREATE TABLE IF NOT EXISTS siblings (
                id          INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id    INT(11)      NOT NULL,
                full_name   VARCHAR(120),
                age         TINYINT,
                occupation  VARCHAR(80),
                address     VARCHAR(255),
                birth_order TINYINT UNSIGNED,
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE,
                INDEX idx_sib_user (pds_id)
            )",
            "CREATE TABLE IF NOT EXISTS educationInfo (
                id             INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id       INT(11)      NOT NULL,
                level          ENUM('Elementary','Secondary','Vocational','College','Graduate') NOT NULL,
                school_name    VARCHAR(120),
                degree_course  VARCHAR(120),
                school_address VARCHAR(255),
                year_grad      YEAR,
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE,
                UNIQUE KEY uq_user_level (pds_id, level)
            )",
            "CREATE TABLE IF NOT EXISTS workExperience (
                id              INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id        INT(11)      NOT NULL,
                date_from       DATE,
                date_to         DATE,
                position_title  VARCHAR(120),
                department      VARCHAR(160),
                monthly_salary  DECIMAL(12,2),
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE,
                INDEX idx_work_user (pds_id)
            )",
            "CREATE TABLE IF NOT EXISTS seminarsTrainings (
                id              INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id        INT(11)      NOT NULL,
                inclusive_dates VARCHAR(80),
                title           VARCHAR(180),
                place           VARCHAR(120),
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE,
                INDEX idx_trn_user (pds_id)
            )",
            "CREATE TABLE IF NOT EXISTS otherInfo (
                id              INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id        INT(11)      NOT NULL,
                special_skills    TEXT,
                house_status      ENUM('Owned','Rented'),
                rental_amount     DECIMAL(10,2),
                house_type        ENUM('light','semi_concrete','concrete'),
                household_members TEXT,
                height DECIMAL(4,2),
                weight DECIMAL(5,2),
                blood_type VARCHAR(4),
                emergency_contact VARCHAR(120),
                tel_no VARCHAR(20),
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE
            )",
            // HUMAN RESOURCES DATABASE (JOB, DEPT, REPORTS, HISTORY AND LEAVES) ======================
            "CREATE TABLE IF NOT EXISTS job_history(
                job_historyID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                employee_id INT,
                job_from VARCHAR(50) NOT NULL,
                job_to VARCHAR(50) NOT NULL,
                current_salary DECIMAL(12,2),
                new_salary DECIMAL(12,2),
                job_status ENUM('Promote', 'Demote', 'Update'),
                addAt datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                department_id INT NULL,
                jobTitle_id INT NULL,
                FOREIGN KEY (department_id) REFERENCES departments(Department_id)
                    ON DELETE SET NULL ON UPDATE CASCADE,
                FOREIGN KEY (jobTitle_id) REFERENCES jobTitles(jobTitles_id)
                    ON DELETE SET NULL ON UPDATE CASCADE,
                FOREIGN KEY (employee_id) REFERENCES employee_data(employee_id)
                    ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS admin_schedule(
                schedule_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                admin_id INT(11),
                work_schedule_type VARCHAR(50),
                shift_type VARCHAR(50),
                work_days VARCHAR(50),
                scheduleFrom time,
                scheduleTo time,
                updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (admin_id) REFERENCES admin(admin_id)
                ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS schedule(
                schedule_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                employee_id INT(11),
                work_schedule_type VARCHAR(50),
                shift_type VARCHAR(50),
                work_days VARCHAR(50),
                updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (employee_id) REFERENCES employee_data(employee_id)
                ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS sched_template(
                template_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                scheduleName VARCHAR(50) NOT NULL,
                schedule_from time NOT NULL,
                schedule_to time NOT NULL,
                shift ENUM('night', 'day') NOT NULL,
                -- day VARCHAR(7) NOT NULL,
                -- department ENUM('HOSPITAL', 'ADMIN', 'SCHOOL', 'HR') NOT NULL,
                created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
            )",

            "CREATE TABLE IF NOT EXISTS hr_data (
                hr_data_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                employee_id INT,
                jobtitle_id INT(11),
                Department_id INT(11),
                unit_section_id INT,

                annual_salary DECIMAL(12,2) NOT NULL,      
                net_pay DECIMAL(12,2) NOT NULL,          
                gross_pay DECIMAL(12,2) NOT NULL,        
                deduction_pay DECIMAL(12,2) NOT NULL, 

                employeeID VARCHAR(150) NOT NULL,
                joined_at VARCHAR(20),
                salary DECIMAL(12,2) NOT NULL,
                scheduleFrom time,
                scheduleTo time,
                houseBlock VARCHAR(50),
                street VARCHAR(50) NOT NULL,
                subdivision VARCHAR(50),
                barangay VARCHAR(50) NOT NULL,
                city_muntinlupa VARCHAR(50) NOT NULL,
                province VARCHAR(50) NOT NULL,
                zip_code VARCHAR(10) NOT NULL,
                updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (unit_section_id) REFERENCES unit_section(unit_section_id),
                FOREIGN KEY (employee_id) REFERENCES employee_data(employee_id) ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (jobtitle_id) REFERENCES jobTitles(jobTitles_id),
                FOREIGN KEY (Department_id) REFERENCES departments(Department_id)
                
            )",
            "CREATE TABLE IF NOT EXISTS login_history (
                id INT AUTO_INCREMENT PRIMARY KEY,
                employee_id INT NOT NULL,
                login_time DATETIME NOT NULL,
                logout_time DATETIME DEFAULT NULL,
                FOREIGN KEY (employee_id) REFERENCES employee_data(employee_id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS admin_login_history (
                id INT AUTO_INCREMENT PRIMARY KEY,
                employee_id INT NOT NULL,
                login_time DATETIME NOT NULL,
                logout_time DATETIME DEFAULT NULL
            )",
            "CREATE TABLE IF NOT EXISTS leaveReq (
                leave_id     INT(11) NOT NULL AUTO_INCREMENT,
                employee_id     INT(11) NOT NULL,
                leaveStatus  ENUM('Pending','Recommended','Approved','Disapproved') DEFAULT 'Pending',
                leaveType    VARCHAR(20) NOT NULL,
                leaveDate    DATE NOT NULL,
                Others VARCHAR(255),
                Purpose VARCHAR(255) NOT NULL,
                InclusiveFrom date NOT NULL,
                InclusiveTo date NOT NULL,
                numberOfDays INT NOT NULL,
                contact VARCHAR(13) NOT NULL,
                sectionHead VARCHAR(120),
                departmentHead VARCHAR(120),
                request_date DATE NOT NULL DEFAULT CURRENT_DATE,
                PRIMARY KEY (leave_id),
                FOREIGN KEY (employee_id) REFERENCES employee_data(employee_id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS leaves (
                leaves_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                leave_type VARCHAR(20) NOT NULL,
                leave_description TEXT,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
            )",
            "CREATE TABLE IF NOT EXISTS activities (
                activities_id     INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                employee_id     INT(11) NOT NULL,
                activity_type  VARCHAR(255) NOT NULL,
                activity_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,                     
                FOREIGN KEY (employee_id) REFERENCES employee_data(employee_id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS leave_details (
                leaveDetails_id INT AUTO_INCREMENT PRIMARY KEY,
                leave_id INT NOT NULL,
                balance INT NOT NULL,
                earned BIGINT NOT NULL,
                credits BIGINT NOT NULL, 
                lessLeave BIGINT NOT NULL,
                balanceToDate BIGINT NOT NULL, 
                disapprovalDetails TEXT,
                approved_at date NULL,
                disapproved_at date NULL,
                FOREIGN KEY (leave_id) REFERENCES leaveReq(leave_id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS leaveCounts (
                leaveCountID     INT          AUTO_INCREMENT PRIMARY KEY,
                employee_id         INT          NOT NULL,
                VacationBalance  DECIMAL(6,2) NOT NULL DEFAULT 0.00,
                SickBalance      DECIMAL(6,2) NOT NULL DEFAULT 0.00,
                SpecialBalance   DECIMAL(6,2) NOT NULL DEFAULT 0.00,
                MaternityBalance   DECIMAL(6,2) NOT NULL DEFAULT 0.00,
                OthersBalance    DECIMAL(6,2) NOT NULL DEFAULT 0.00,
                last_earned_month VARCHAR(7) DEFAULT NULL,
                last_updated date,
                FOREIGN KEY (employee_id) REFERENCES employee_data(employee_id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS Family_data (
                Family_data_id     INT          AUTO_INCREMENT PRIMARY KEY,
                employee_id INT(11) NOT NULL,
                Relationship  ENUM('Father', 'Mother', 'Guardian', 'Spouse'),
                firstname VARCHAR(50),
                middlename VARCHAR(50),
                lastname VARCHAR(50),
                occupation VARCHAR(50),
                contact VARCHAR(50),
                house_block VARCHAR(50),
                street VARCHAR(50),
                subdivision VARCHAR(50),
                barangay VARCHAR(50),
                city VARCHAR(50),
                province VARCHAR(50),
                zip_code VARCHAR(50),
                FOREIGN KEY (employee_id) REFERENCES employee_data(employee_id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS educational_data (
                educational_data_id     INT          AUTO_INCREMENT PRIMARY KEY,
                employee_id INT(11) NOT NULL,
                education_level  ENUM('Elementary', 'High_school', 'Senior_high', 'College', 'Graduate'),
                school_name VARCHAR(50),
                year_started VARCHAR(50),
                year_ended VARCHAR(50),
                course_strand VARCHAR(50),
                honors TEXT,
                FOREIGN KEY (employee_id) REFERENCES employee_data(employee_id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS files (
                files_id     INT          AUTO_INCREMENT PRIMARY KEY,
                employee_id INT(11) NOT NULL,
                file_title VARCHAR(100) NOT NULL,
                type ENUM('communication', 'certifications' ,'training_certificates', 'license_eligibility', 'academic_credentials', 'preScreening_requirements', 'medical_certificates') NOT NULL,
                201file VARCHAR(255) NOT NULL,
                added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (employee_id) REFERENCES employee_data(employee_id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS notifications (
                notifications_id INT AUTO_INCREMENT PRIMARY KEY,
                type ENUM('HR', 'ADMIN') NOT NULL,
                status ENUM('Active', 'Inactive'),
                notify_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )"
        ];

        foreach ($tableQueries as $sql) {
            $pdo->exec($sql);
        }
        $count = $pdo->query("SELECT COUNT(*) FROM admin")->fetchColumn();

        if ($count == 0) {

            $stmt = $pdo->prepare("
                INSERT INTO admin (
                    admin_firstname,
                    admin_middlename,
                    admin_lastname,
                    admin_suffix,
                    joined_at,
                    admin_cpno,
                    admin_birth,
                    admin_gender,
                    admin_admin_status,
                    admin_email,
                    admin_username,
                    admin_password,
                    admin_user_role
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                'JULIUS',
                'VENTURA',         
                'BAGUIO',
                '',
                '2024',       
                '09171234567',
                '1999-05-23',
                'Male',
                'Active',
                'admin@example.com',
                'admin',
                password_hash('admin123', PASSWORD_BCRYPT),
                'admin'
            ]);

            // Get the inserted admin_id
            $admin_id = $pdo->lastInsertId();
            
            $stmtInfo = $pdo->prepare("
                    INSERT INTO admin_info (
                        admin_id,
                        admin_employee_id,
                        admin_province,
                        admin_city,
                        admin_barangay,
                        admin_rating
                    ) VALUES (?, ?, ?, ?, ?, ?)
                ");

                $stmtInfo->execute([
                    $admin_id,
                    '0001',
                    'Metro Manila',
                    'Manila',
                    'Barangay 123',
                    'Excellent'
                ]);

        }

        $countSchedule = $pdo->query("SELECT COUNT(*) FROM admin_schedule")->fetchColumn();
        if($countSchedule == 0){
            $stmt = $pdo->prepare("
                INSERT INTO admin_schedule (admin_id) VALUES (1)
            ");
            $stmt->execute();
        }

        // CSRF Token Generation
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $csrf_token = $_SESSION['csrf_token'];

        return $pdo;

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

// Initialize on load
$pdo = db_connect();