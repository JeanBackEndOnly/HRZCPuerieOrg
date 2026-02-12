<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../assets/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Action
{
    private $db;

    public function __construct()
    {

        include 'config.php';

        if (!isset($pdo)) {
            die("Database not connected.");
        }
        $this->db = $pdo;
    }

    function __destruct()
    {
        $this->db = null;
    }
// LOGIN ===============================================================================================================
    // Comment this login if you want to login without verification code !!!!!!! =============================================================
    // final login
    // function login(){
    //         try {
    //             $username = $_POST['username'] ?? '';
    //             $password = $_POST['password'] ?? '';

    //             if (empty($username) || empty($password)) {
    //                 return json_encode(['status' => 0, 'message' => 'Username and password are required.']);
    //             }

    //             // First, check if it's an admin account
    //             $stmt = $this->db->prepare("SELECT * FROM admin WHERE admin_username = ?");
    //             $stmt->execute([$username]);
    //             $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    //             if ($admin && password_verify($password, $admin['admin_password'])) {
    //                 // Generate verification code for admin
    //                 $verification = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    //                 $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    //                 $_SESSION["username"] = $username;
    //                 $_SESSION["user_role"] = $admin['admin_user_role'];
    //                 $_SESSION["is_admin"] = true;
    //                 $_SESSION["verification"] = $verification;
    //                 $_SESSION["password"] = $password; // Store password for verification form

    //                 // Email details for admin
    //                 $email = $admin["admin_email"];
    //                 $firstName = $admin["admin_firstname"];
    //                 $lastName = $admin["admin_lastname"];

    //                 // Send email to admin
    //                 $mail = new PHPMailer(true);
    //                 try {
    //                     $mail->isSMTP();
    //                     $mail->Host = 'smtp.gmail.com';
    //                     $mail->SMTPAuth = true;
    //                     $mail->Username = 'pagotaisidromarcojean123@gmail.com';
    //                     $mail->Password = 'piji jfrn znjb eaey'; // Gmail App Password
    //                     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    //                     $mail->Port = 587;

    //                     $mail->setFrom('pagotaisidromarcojean123@gmail.com', 'HR OFFICE');
    //                     $mail->addAddress($email, $firstName . ' ' . $lastName);

    //                     $mail->isHTML(true);
    //                     $mail->Subject = 'Verify Your Admin Account';
    //                     $mail->Body = "
    //                         <h3>Hello " . htmlspecialchars($firstName) . "!</h3>
    //                         <p>Welcome to Zamboanga Puericulture Center Org. No. 144 - Admin Portal.</p>
    //                         <p>Your verification code is:</p>
    //                         <h2 style='color:#2e6c80;'>" . htmlspecialchars($verification) . "</h2>
    //                         <p>This code will expire in 10 minutes.</p>
    //                     ";
    //                     $mail->AltBody = 'Hello ' . $firstName . ', your admin verification code is: ' . $verification;

    //                     $mail->send();

    //                     return json_encode([
    //                         'status' => 1,
    //                         'message' => 'Admin verification code sent successfully! Please check your email.',
    //                         'is_admin' => true,
    //                         'requires_verification' => true
    //                     ]);
    //                 } catch (Exception $e) {
    //                     return json_encode([
    //                         'status' => 2,
    //                         'message' => 'Email could not be sent. Error: ' . $mail->ErrorInfo
    //                     ]);
    //                 }
    //             }

    //             // If not admin, check employee accounts (ORIGINAL EMPLOYEE CODE - UNTOUCHED)
    //             $stmt = $this->db->prepare("SELECT * FROM employee_data WHERE username = ?");
    //             $stmt->execute([$username]);
    //             $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //             if ($user && password_verify($password, $user['password'])) {

    //                 if ((int)$user['is_verified'] === 1) {
    //                     // Already verified
    //                     $_SESSION["username"] = $username;
    //                     return json_encode([
    //                         'status' => 1,
    //                         'message' => 'Login successful. Account already verified.'
    //                     ]);
    //                 }

    //                 // Generate verification code
    //                 $verification = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    //                 $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    //                 // Store verification in DB
    //                 $update = $this->db->prepare("UPDATE employee_data SET verification_code = ?, verification_code_expires = ? WHERE username = ?");
    //                 $update->execute([$verification, $expiry, $username]);

    //                 // Save in session
    //                 $_SESSION["username"] = $username;
    //                 $_SESSION["password"] = $password;
    //                 $_SESSION["verification"] = $verification;

    //                 // Email details
    //                 $email = $user["email"];
    //                 $firstName = $user["firstname"];
    //                 $lastName = $user["lastname"];

    //                 // Send email
    //                 $mail = new PHPMailer(true);
    //                 try {
    //                     $mail->isSMTP();
    //                     $mail->Host = 'smtp.gmail.com';
    //                     $mail->SMTPAuth = true;
    //                     $mail->Username = 'pagotaisidromarcojean123@gmail.com';
    //                     $mail->Password = 'piji jfrn znjb eaey'; // Gmail App Password
    //                     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    //                     $mail->Port = 587;

    //                     $mail->setFrom('pagotaisidromarcojean123@gmail.com', 'HR OFFICE');
    //                     $mail->addAddress($email, $firstName . ' ' . $lastName);

    //                     $mail->isHTML(true);
    //                     $mail->Subject = 'Verify Your Account';
    //                     $mail->Body = "
    //                         <h3>Hello " . htmlspecialchars($firstName) . "!</h3>
    //                         <p>Welcome to Zamboanga Puericulture Center Org. No. 144.</p>
    //                         <p>Your verification code is:</p>
    //                         <h2 style='color:#2e6c80;'>" . htmlspecialchars($verification) . "</h2>
    //                         <p>This code will expire in 10 minutes.</p>
    //                     ";
    //                     $mail->AltBody = 'Hello ' . $firstName . ', your verification code is: ' . $verification;

    //                     $mail->send();

    //                     return json_encode([
    //                         'status' => 1,
    //                         'redirectUrl'=>'./authentication/verification_action.php',
    //                         'message' => 'Verification code sent successfully! Please check your email.'
    //                     ]);
    //                 } catch (Exception $e) {
    //                     return json_encode([
    //                         'status' => 2,
    //                         'message' => 'Email could not be sent. Error: ' . $mail->ErrorInfo
    //                     ]);
    //                 }

    //             } else {
    //                 return json_encode([
    //                     'status' => 0,
    //                     'message' => 'Incorrect username or password, please try again.'
    //                 ]);
    //             }

    //         } catch (Exception $e) {
    //             return json_encode(['status' => 2, 'message' => 'Database error: ' . $e->getMessage()]);
    //         }
    //     }
    //     function login_verification_form(){
    //         try {
    //             $verification_code = $_POST["verification_code"];
    //             $verification = $_SESSION["verification"];
    //             $username = $_SESSION["username"];
    //             $password = $_SESSION["password"];
    //             $is_admin = $_SESSION["is_admin"] ?? false;

    //             if($verification_code !== $verification){
    //                 return json_encode([
    //                     'status' => 0,
    //                     'message' => 'Incorrect Verification code! please try again!'
    //                 ]);
    //             } else {
    //                 // ==== Admin Login ====
    //                 if ($is_admin) {
    //                     $stmt = $this->db->prepare("SELECT * FROM admin WHERE admin_username = ?");
    //                     $stmt->execute([$username]);
    //                     $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    //                     if ($admin && password_verify($password, $admin['admin_password'])) {
    //                         $_SESSION['adminData'] = [
    //                             'admin_firstname' => $admin['admin_firstname'],
    //                             'admin_middlename' => $admin['admin_middlename'],
    //                             'admin_lastname' => $admin['admin_lastname'],
    //                             'admin_email' => $admin['admin_email'],
    //                             'admin_user_role' => $admin['admin_user_role'],
    //                             'admin_username' => $admin['admin_username'],
    //                             'admin_id' => $admin['admin_id']
    //                         ];

    //                         return json_encode([
    //                             'status' => 1,
    //                             'message' => 'Admin login successful.',
    //                             'redirect_url' => 'src/UI-admin/index.php', // Adjust this URL as needed
    //                             'user_role' => $admin['admin_firstname'] . " " . $admin['admin_lastname']
    //                         ]);
    //                     } else {
    //                         return json_encode(['status' => 2, 'message' => 'Admin verification failed.']);
    //                     }
    //                 }

    //                 // ==== Employee Login ==== (ORIGINAL EMPLOYEE CODE - UNTOUCHED)
    //                 $stmt = $this->db->prepare("SELECT * FROM employee_data WHERE username = ? OR email = ?");
    //                 $stmt->execute([$username, $username]);
    //                 $employees = $stmt->fetch();

    //                 if ($employees['user_role'] === 'EMPLOYEE' && $employees["status"] === 'Active') {

    //                     if (password_verify($password, $employees['password'])) {
    //                         $_SESSION['employeeData'] = [
    //                             'firstname' => $employees['firstname'],
    //                             'middlename' => $employees['middlename'],
    //                             'lastname' => $employees['lastname'],
    //                             'email' => $employees['email'],
    //                             'user_role' => $employees['user_role'],
    //                             'username' => $employees['username'],
    //                             'employee_id' => $employees['employee_id'],
    //                             'created_date' => $employees['created_date']
    //                         ];

    //                         $employee_id = $employees['employee_id'];
    //                         $stmtHistory = $this->db->prepare("INSERT INTO login_history (employee_id, login_time) VALUES ('$employee_id', NOW())");
    //                         $stmtHistory->execute();

    //                         return json_encode([
    //                             'status' => 1,
    //                             'message' => 'Login successful.',
    //                             'redirect_url' => 'src/UI-employee/index.php',
    //                             'user_role' => $employees['firstname'] . " " . $employees['lastname']
    //                         ]);
    //                     } else {
    //                         return json_encode(['status' => 2, 'message' => 'Incorrect password.']);
    //                     }
    //                 } else if($employees['user_role'] === 'EMPLOYEE' && $employees["status"] === 'Pending'){
    //                     if (password_verify($password, $employees['password'])) {
    //                         $_SESSION['employeeData'] = [
    //                             'firstname' => $employees['firstname'],
    //                             'middlename' => $employees['middlename'],
    //                             'lastname' => $employees['lastname'],
    //                             'email' => $employees['email'],
    //                             'user_role' => $employees['user_role'],
    //                             'username' => $employees['username'],
    //                             'employee_id' => $employees['employee_id'],
    //                             'created_date' => $employees['created_date']
    //                         ];
    //                         return json_encode([
    //                             'status' => 1,
    //                             'message' => 'Login successful.',
    //                             'redirect_url' => 'src/UI-employee/pending.php',
    //                             'user_role' => $employees['firstname'] . " " . $employees['lastname']
    //                         ]);
    //                     } else {
    //                         return json_encode(['status' => 2, 'message' => 'Incorrect password.']);
    //                     }
    //                 } else if($employees['user_role'] === 'EMPLOYEE' && $employees["status"] === 'Inactive'){
    //                     if (password_verify($password, $employees['password'])) {
    //                         $_SESSION['employeeData'] = [
    //                             'firstname' => $employees['firstname'],
    //                             'middlename' => $employees['middlename'],
    //                             'lastname' => $employees['lastname'],
    //                             'email' => $employees['email'],
    //                             'user_role' => $employees['user_role'],
    //                             'username' => $employees['username'],
    //                             'employee_id' => $employees['employee_id'],
    //                             'created_date' => $employees['created_date']
    //                         ];
    //                         return json_encode([
    //                             'status' => 1,
    //                             'message' => 'Login successful.',
    //                             'redirect_url' => 'src/UI-employee/inactive.php',
    //                             'user_role' => $employees['firstname'] . " " . $employees['lastname']
    //                         ]);
    //                     } else {
    //                         return json_encode(['status' => 2, 'message' => 'Incorrect password.']);
    //                     }
    //                 }

    //                 if ($employees['user_role'] === 'HRSM' && $employees["status"] === 'Active') {

    //             if (password_verify($password, $employees['password'])) {
    //                 $_SESSION['hrData'] = [
    //                     'firstname' => $employees['firstname'],
    //                     'middlename' => $employees['middlename'],
    //                     'lastname' => $employees['lastname'],
    //                     'email' => $employees['email'],
    //                     'user_role' => $employees['user_role'],
    //                     'username' => $employees['username'],
    //                     'employee_id' => $employees['employee_id'],
    //                     'created_date' => $employees['created_date']
    //                 ];

    //                 $employee_id = $employees['employee_id'];
    //                 $stmtHistory = $this->db->prepare("INSERT INTO login_history (employee_id, login_time) VALUES ('$employee_id', NOW())");
    //                 $stmtHistory->execute();

    //                 return json_encode([
    //                     'status' => 1,
    //                     'message' => 'Login successful.',
    //                     'redirect_url' => 'src/UI-HR/index.php',
    //                     'user_role' => $employees['firstname'] . " " . $employees['lastname']
    //                 ]);
    //             } else {
    //                 return json_encode(['status' => 2, 'message' => 'Incorrect password.']);
    //             }
    //         }else if ($employees['user_role'] === 'HRSM' && $employees["status"] === 'Inactive') {

    //             if (password_verify($password, $employees['password'])) {
    //                 $_SESSION['hrData'] = [
    //                     'firstname' => $employees['firstname'],
    //                     'middlename' => $employees['middlename'],
    //                     'lastname' => $employees['lastname'],
    //                     'email' => $employees['email'],
    //                     'user_role' => $employees['user_role'],
    //                     'username' => $employees['username'],
    //                     'employee_id' => $employees['employee_id'],
    //                     'created_date' => $employees['created_date']
    //                 ];

    //                 $employee_id = $employees['employee_id'];
    //                 $stmtHistory = $this->db->prepare("INSERT INTO login_history (employee_id, login_time) VALUES ('$employee_id', NOW())");
    //                 $stmtHistory->execute();

    //                 return json_encode([
    //                     'status' => 1,
    //                     'message' => 'Login successful.',
    //                     'redirect_url' => 'src/UI-HR/inactive.php',
    //                     'user_role' => $employees['firstname'] . " " . $employees['lastname']
    //                 ]);
    //             } else {
    //                 return json_encode(['status' => 2, 'message' => 'Incorrect password.']);
    //             }
    //         }else if ($employees['user_role'] === 'HRSM' && $employees["status"] === 'Pending') {

    //             if (password_verify($password, $employees['password'])) {
    //                 $_SESSION['hrData'] = [
    //                     'firstname' => $employees['firstname'],
    //                     'middlename' => $employees['middlename'],
    //                     'lastname' => $employees['lastname'],
    //                     'email' => $employees['email'],
    //                     'user_role' => $employees['user_role'],
    //                     'username' => $employees['username'],
    //                     'employee_id' => $employees['employee_id'],
    //                     'created_date' => $employees['created_date']
    //                 ];

    //                 $employee_id = $employees['employee_id'];
    //                 $stmtHistory = $this->db->prepare("INSERT INTO login_history (employee_id, login_time) VALUES ('$employee_id', NOW())");
    //                 $stmtHistory->execute();

    //                 return json_encode([
    //                     'status' => 1,
    //                     'message' => 'Login successful.',
    //                     'redirect_url' => 'src/UI-HR/pending.php',
    //                     'user_role' => $employees['firstname'] . " " . $employees['lastname']
    //                 ]);
    //             } else {
    //                 return json_encode(['status' => 2, 'message' => 'Incorrect password.']);
    //             }
    //         }

    //                 return json_encode([
    //                     'status' => 2,
    //                     'message' => 'User not found. Please check your username/email.'
    //                 ]);
    //             }
                
    //         } catch (PDOException $e) {
    //             return json_encode([
    //                 'status' => 0,
    //                 'message' => 'An error occured: ' . $e->getMessage()
    //             ]);
    //         }
    //     }
    // ========================================================================================================================================

    // ===============================================================================================
    // login without verification code !!!!!!!!!! Uncomment to use!!!!!
    function login()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;

        if (empty($username) || empty($password)) {
            return json_encode(['status' => 0, 'message' => 'Username and password are required.']);
        }

        try {
            // ==== Admin Login ====
            $stmt = $this->db->prepare("SELECT a.*, ai.admin_employee_id,
            d.Department_name AS admin_department, j.jobTitle AS admin_position
            FROM admin a
            INNER JOIN admin_info ai ON a.admin_id = ai.admin_id
            LEFT JOIN jobTitles j ON ai.admin_position_id = j.jobTitles_id
            LEFT JOIN departments d ON ai.admin_department_id = d.Department_id
            WHERE admin_username = ? OR admin_email = ?");
            $stmt->execute([$username, $username]);
            $admin = $stmt->fetch();

            if ($admin && $admin['admin_user_role'] === 'admin') {
                if (password_verify($password, $admin['admin_password'])) {
                    $_SESSION['adminData'] = [
                        'admin_firstname' => $admin['admin_firstname'],
                        'admin_middlename' => $admin['admin_middlename'],
                        'admin_lastname' => $admin['admin_lastname'],
                        'admin_email' => $admin['admin_email'],
                        'admin_department' => $admin['admin_department'],
                        'admin_position' => $admin['admin_position'],
                        'admin_user_role' => $admin['admin_user_role'],
                        'admin_username' => $admin['admin_username'],
                        'admin_id' => $admin['admin_id'],
                        'admin_employee_id' => $admin['admin_employee_id'],
                        'joined_at' => $admin['joined_at'],
                        'admin_picture' => $admin['admin_picture'],
                        'created_date' => $admin['created_date']
                    ];
                    $admin_id = $admin['admin_id'];
                    $stmtHistory = $this->db->prepare("INSERT INTO admin_login_history (employee_id, login_time) VALUES ('$admin_id', NOW())");
                    $stmtHistory->execute();
                    return json_encode([
                        'status' => 1,
                        'message' => 'Logging in...',
                        'redirect_url' => 'src/UI-Admin/index.php',
                        'user_role' => $admin['admin_firstname'] . " " . $admin['admin_lastname']
                    ]);
                } else {
                    return json_encode(['status' => 0, 'message' => 'Incorrect password.']);
                }
            }


            // ==== Employee Login ====
            $stmt = $this->db->prepare("SELECT ed.*, hd.employeeID,
            d.Department_name AS employee_department,
            j.jobTitle AS employee_position
            FROM employee_data ed
            INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
            LEFT JOIN departments d ON hd.Department_id = d.Department_id
            LEFT JOIN jobTitles j ON hd.jobtitle_id = j.jobTitles_id
            WHERE ed.username = ? OR ed.email = ?");
            $stmt->execute([$username, $username]);
            $employees = $stmt->fetch();



            if ($employees['user_role'] === 'EMPLOYEE' && $employees["status"] === 'Active') {

                if (password_verify($password, $employees['password'])) {
                    $_SESSION['employeeData'] = [
                        'firstname' => $employees['firstname'],
                        'middlename' => $employees['middlename'],
                        'lastname' => $employees['lastname'],
                        'email' => $employees['email'],
                        'user_role' => $employees['user_role'],
                        'username' => $employees['username'],
                        'employee_id' => $employees['employee_id'],
                        'employeeID' => $employees['employeeID'],
                        'employee_department' => $employees['employee_department'],
                        'employee_position' => $employees['employee_position'],
                        'profile_picture' => $employees['profile_picture'],
                        'created_date' => $employees['created_date']
                    ];

                    $employee_id = $employees['employee_id'];
                    $stmtHistory = $this->db->prepare("INSERT INTO login_history (employee_id, login_time) VALUES ('$employee_id', NOW())");
                    $stmtHistory->execute();

                    return json_encode([
                        'status' => 1,
                        'message' => 'Login successful.',
                        'redirect_url' => 'src/UI-employee/index.php',
                        'user_role' => $employees['firstname'] . " " . $employees['lastname']
                    ]);
                } else {
                    return json_encode(['status' => 0, 'message' => 'Incorrect password.']);
                }
            }else if($employees['user_role'] === 'EMPLOYEE' && $employees["status"] === 'Pending'){
                if (password_verify($password, $employees['password'])) {
                    $_SESSION['employeeData'] = [
                        'firstname' => $employees['firstname'],
                        'middlename' => $employees['middlename'],
                        'lastname' => $employees['lastname'],
                        'email' => $employees['email'],
                        'user_role' => $employees['user_role'],
                        'username' => $employees['username'],
                        'employee_id' => $employees['employee_id'],
                        'created_date' => $employees['created_date']
                    ];
                    return json_encode([
                        'status' => 1,
                        'message' => 'Login successful.',
                        'redirect_url' => 'src/UI-employee/pending.php',
                        'user_role' => $employees['firstname'] . " " . $employees['lastname']
                    ]);
                } else {
                    return json_encode(['status' => 0, 'message' => 'Incorrect password.']);
                }
            }else if($employees['user_role'] === 'EMPLOYEE' && $employees["status"] === 'Inactive'){
                if (password_verify($password, $employees['password'])) {
                    $_SESSION['employeeData'] = [
                        'firstname' => $employees['firstname'],
                        'middlename' => $employees['middlename'],
                        'lastname' => $employees['lastname'],
                        'email' => $employees['email'],
                        'user_role' => $employees['user_role'],
                        'username' => $employees['username'],
                        'employee_id' => $employees['employee_id'],
                        'created_date' => $employees['created_date']
                    ];
                    return json_encode([
                        'status' => 1,
                        'message' => 'Login successful.',
                        'redirect_url' => 'src/UI-employee/inactive.php',
                        'user_role' => $employees['firstname'] . " " . $employees['lastname']
                    ]);
                } else {
                    return json_encode(['status' => 0, 'message' => 'Incorrect password.']);
                }
            }

            if ($employees['user_role'] === 'HRSM' && $employees["status"] === 'Active') {

                if (password_verify($password, $employees['password'])) {
                    $_SESSION['hrData'] = [
                        'firstname' => $employees['firstname'],
                        'middlename' => $employees['middlename'],
                        'lastname' => $employees['lastname'],
                        'employeeID' => $employees['employeeID'],
                        'employee_department' => $employees['employee_department'],
                        'employee_position' => $employees['employee_position'],
                        'email' => $employees['email'],
                        'user_role' => $employees['user_role'],
                        'username' => $employees['username'],
                        'employee_id' => $employees['employee_id'],
                        'profile_picture' => $employees['profile_picture'],
                        'created_date' => $employees['created_date']
                    ];

                    $employee_id = $employees['employee_id'];
                    $stmtHistory = $this->db->prepare("INSERT INTO login_history (employee_id, login_time) VALUES ('$employee_id', NOW())");
                    $stmtHistory->execute();

                    return json_encode([
                        'status' => 1,
                        'message' => 'Login successful.',
                        'redirect_url' => 'src/UI-HR/index.php',
                        'user_role' => $employees['firstname'] . " " . $employees['lastname']
                    ]);
                } else {
                    return json_encode(['status' => 0, 'message' => 'Incorrect password.']);
                }
            }else if ($employees['user_role'] === 'HRSM' && $employees["status"] === 'Inactive') {

                if (password_verify($password, $employees['password'])) {
                    $_SESSION['hrData'] = [
                        'firstname' => $employees['firstname'],
                        'middlename' => $employees['middlename'],
                        'lastname' => $employees['lastname'],
                        'email' => $employees['email'],
                        'user_role' => $employees['user_role'],
                        'username' => $employees['username'],
                        'employee_id' => $employees['employee_id'],
                        'created_date' => $employees['created_date']
                    ];

                    $employee_id = $employees['employee_id'];
                    $stmtHistory = $this->db->prepare("INSERT INTO login_history (employee_id, login_time) VALUES ('$employee_id', NOW())");
                    $stmtHistory->execute();

                    return json_encode([
                        'status' => 1,
                        'message' => 'Login successful.',
                        'redirect_url' => 'src/UI-HR/inactive.php',
                        'user_role' => $employees['firstname'] . " " . $employees['lastname']
                    ]);
                } else {
                    return json_encode(['status' => 0, 'message' => 'Incorrect password.']);
                }
            }else if ($employees['user_role'] === 'HRSM' && $employees["status"] === 'Pending') {

                if (password_verify($password, $employees['password'])) {
                    $_SESSION['hrData'] = [
                        'firstname' => $employees['firstname'],
                        'middlename' => $employees['middlename'],
                        'lastname' => $employees['lastname'],
                        'email' => $employees['email'],
                        'user_role' => $employees['user_role'],
                        'username' => $employees['username'],
                        'employee_id' => $employees['employee_id'],
                        'created_date' => $employees['created_date']
                    ];

                    $employee_id = $employees['employee_id'];
                    $stmtHistory = $this->db->prepare("INSERT INTO login_history (employee_id, login_time) VALUES ('$employee_id', NOW())");
                    $stmtHistory->execute();

                    return json_encode([
                        'status' => 1,
                        'message' => 'Login successful.',
                        'redirect_url' => 'src/UI-HR/pending.php',
                        'user_role' => $employees['firstname'] . " " . $employees['lastname']
                    ]);
                } else {
                    return json_encode(['status' => 0, 'message' => 'Incorrect password.']);
                }
            }

            return json_encode([
                'status' => 0,
                'message' => 'User not found. Please check your username/email.'
            ]);
        } catch (Exception $e) {
            return json_encode(['status' => 0, 'message' => 'Database error. Please try again later.']);
        }
    }
    // ===============================================================================================

    function logout(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // ✅ Get employee ID before destroying the session
        $employee_id = null;

        if (!empty($_SESSION['employeeData']['employee_id'])) {
            $employee_id = $_SESSION['employeeData']['employee_id'];
        } elseif (!empty($_SESSION['hrData']['employee_id'])) {
            $employee_id = $_SESSION['hrData']['employee_id'];
        } elseif (!empty($_SESSION['adminData']['admin_id'])) {
            $admin_id = $_SESSION['adminData']['admin_id'];
        }

        // ✅ Update logout_time only if we got an employee_id
        if ($employee_id !== null) {
            $sql = "UPDATE login_history 
                    SET logout_time = NOW() 
                    WHERE employee_id = :employee_id 
                    AND logout_time IS NULL 
                    ORDER BY login_time DESC 
                    LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['employee_id' => $employee_id]);
        }else if($admin_id !== null){
            $sql = "UPDATE admin_login_history 
                    SET logout_time = NOW() 
                    WHERE employee_id = :employee_id 
                    AND logout_time IS NULL 
                    ORDER BY login_time DESC 
                    LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['employee_id' => $admin_id]);
        }

        // ✅ Now clear and destroy the session
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_unset();
        session_destroy();

        return json_encode([
            'status' => 1,
            'message' => 'Logout successful.',
            'redirect_url' => './src/index.php'
        ]);
    }

// FORGOT ACCOUNT =======================================================
    function changePassword_form(){
        try {
            $current_password = $_POST["current_password"] ?? '';
            $new_pass = $_POST["new_pass"] ?? '';
            $confirm_pass = $_POST["confirm_pass"] ?? '';
            
            // Validate match
            if ($new_pass !== $confirm_pass) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Password not match. Please try again.'
                ]);
            }

            // Determine employee id
            $employee_id = $_SESSION["employee_id"] ?? $_POST["employee_id"] ?? null;

            if ($employee_id === null) {
                $admin_id = $_POST["admin_id"];
                $stmt = $this->db->prepare("SELECT admin_password FROM admin WHERE admin_id = :admin_id");
                $stmt->execute(['admin_id' => $admin_id]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$admin) {
                    return json_encode([
                        'status' => 0,
                        'message' => 'Employee does not exist.'
                    ]);
                }
                // Verify old password
                if (!password_verify($current_password, $admin["admin_password"])) {
                    return json_encode([
                        'status' => 0,
                        'message' => 'Current password incorrect.'
                    ]);
                }

                // Create new hash
                $hash = password_hash($new_pass, PASSWORD_BCRYPT);

                // FIXED: Added WHERE clause
                $stmt = $this->db->prepare("UPDATE admin SET admin_password = :admin_password WHERE admin_id = :admin_id");
                $stmt->execute([
                    'admin_password' => $hash,
                    'admin_id' => $admin_id
                ]);
            }else if($employee_id !== null){
                $stmt = $this->db->prepare("SELECT password FROM employee_data WHERE employee_id = :employee_id");
                $stmt->execute(['employee_id' => $employee_id]);
                $employee = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$employee) {
                    return json_encode([
                        'status' => 0,
                        'message' => 'Employee does not exist.'
                    ]);
                }

                // Verify old password
                if (!password_verify($current_password, $employee["password"])) {
                    return json_encode([
                        'status' => 0,
                        'message' => 'Current password incorrect.'
                    ]);
                }

                // Create new hash
                $hash = password_hash($new_pass, PASSWORD_BCRYPT);

                // FIXED: Added WHERE clause
                $stmt = $this->db->prepare("UPDATE employee_data SET password = :password WHERE employee_id = :employee_id");
                $stmt->execute([
                    'password' => $hash,
                    'employee_id' => $employee_id
                ]);
            }
            return json_encode([
                'status' => 1,
                'message' => 'Password changed successfully!'
            ]);

        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }
    function forget_account_form()
    {
        try {
            $username = $_POST['username'] ?? '';
            
            // Use proper prepared statements
            $stmt = $this->db->prepare("SELECT username, email, firstname, lastname, employee_id FROM employee_data WHERE username = :username OR email = :username");
            $stmt->execute([':username' => $username]);
            $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

            if($userExists){
                $verification = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

                // Use correct array keys (lowercase as in SQL query)
                $email = $userExists["email"];
                $firstName = $userExists["firstname"]; // lowercase
                $lastName = $userExists["lastname"];   // lowercase
                $employee_id = $userExists["employee_id"];

                $_SESSION["email"] = $email;
                $_SESSION["employee_id"] = $employee_id;
                $_SESSION["email_verification"] = $verification;

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'pagotaisidromarcojean123@gmail.com';
                    $mail->Password = 'piji jfrn znjb eaey';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('pagotaisidromarcojean123@gmail.com', 'HR OFFICE');
                    $mail->addAddress($email, $firstName . ' ' . $lastName);

                    $mail->isHTML(true);
                    $mail->Subject = 'Verify Your Account';
                    $mail->Body = "
                        <h3>Hello " . htmlspecialchars($firstName) . "!</h3>
                        <p>Welcome to Zamboanga Puericulture Center Org. No. 144.</p>
                        <p>Your verification code is:</p>
                        <h2 style='color:#2e6c80;'>" . htmlspecialchars($verification) . "</h2>
                        <p>This code will expire in 10 minutes.</p>
                    ";
                    $mail->AltBody = 'Hello ' . $firstName . ', your verification code is: ' . $verification;

                    $mail->send();

                    return json_encode([
                        'status' => 1,
                        'redirectUrl'=>'./authentication/verification_action.php',
                        'message' => 'Verification code sent successfully! Please check your email.'
                    ]);
                } catch (Exception $e) {
                    return json_encode([
                        'status' => 2,
                        'message' => 'Email could not be sent. Error: ' . $mail->ErrorInfo
                    ]);
                }
            } else {
                return json_encode([
                    'status' => 0,
                    'message' => 'Username or email not exist'
                ]);
            }
        } catch (Exception $e) {
            return json_encode(['status' => 2, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
    function changePassword_verification_form(){
        try {
            
            $verification_code = $_POST["verification_code"] ?? '';
            
            // Check if session variables exist
            if (!isset($_SESSION["email_verification"])) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Verification session expired or not found. Please request a new code.'
                ]);
            }
            
            $stored_verification = $_SESSION["email_verification"];
            
            if ($verification_code !== $stored_verification) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Incorrect verification code! Please try again.'
                ]);
            } else {
                // Mark verification as completed
                $_SESSION["email_verified"] = true;
                
                return json_encode([
                    'status' => 1,
                    'message' => 'Verification successful!'
                ]);
            }
            
        } catch (Exception $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }
    function password_form(){
        try {
            $employee_id = $_SESSION["employee_id"];
            $new_pass = $_POST["new_pass"];
            $confirm_pass = $_POST["confirm_pass"];

            if($new_pass != $confirm_pass){
                return json_encode([
                    'status' => 0,
                    'message' => 'New password not match!'
                ]);
            }
            $hash = password_hash($new_pass, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("UPDATE employee_data SET password = :password WHERE employee_id = :employee_id");
            $stmt->execute([
                'password' => $hash,
                'employee_id' => $employee_id
            ]);

            return json_encode([
                'status' => 1,
                'message' => 'Password changed successfully!'
            ]);

        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }

// DEPARTMENTS =======================================================================
    function department_form(){
        $department_name = htmlspecialchars(trim($_POST["department_name"]));
        $department_code = htmlspecialchars(trim($_POST["department_code"]));
        // Validation code remains the same...

        try {
            // Check if username exists using prepared statement
            $stmt = $this->db->prepare("SELECT department_name FROM departments WHERE department_name = ?");
            $stmt->execute([$department_name]);
            $department_nameTaken = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($department_nameTaken) {
                return json_encode([
                    'status' => 0,
                    'message' => 'department_name ' . $department_nameTaken["department_name"] . ' already taken please try another department_name'
                ]);
            }
            $stmt = $this->db->prepare("SELECT department_code FROM departments WHERE department_code = ?");
            $stmt->execute([$department_code]);
            $department_codeTaken = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($department_codeTaken) {
                return json_encode([
                    'status' => 0,
                    'message' => 'department_code ' . $department_codeTaken["department_code"] . ' already taken please try another department_name'
                ]);
            }

            $stmt = $this->db->prepare("INSERT INTO departments (department_name, department_code) VALUES ('$department_name', '$department_code')");
            $stmt->execute();

            return json_encode([
                'status' => 1,
                'message' => 'department created successfully!'
            ]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }
    function edit_department(){
        $department_id = htmlspecialchars($_POST["department_id"] ?? '');
        $department_name = htmlspecialchars($_POST["department_name"] ?? '');
        $department_code = htmlspecialchars($_POST["department_code"] ?? '');

        try {

            $stmt = $this->db->prepare("UPDATE departments SET Department_name = :Department_name, Department_code = :Department_code WHERE Department_id = :Department_id ");
            $stmt->execute(['Department_name' => $department_name, 'Department_code' => $department_code, 'Department_id' => $department_id]);

            return json_encode([
                'status' => 1,
                'message' => 'Department Edited successfully!'
            ]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }
    function department_delete_form(){
        try {
            $department_id = $_POST["department_id"];

                $stmt = $this->db->prepare("SELECT * FROM departments d
                    INNER JOIN hr_data hd ON d.Department_id = hd.Department_id
                    WHERE d.Department_id = :Department_id");

                $stmt->execute([
                    'Department_id' => $department_id  
                ]);

                $employee_exist = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($employee_exist) {
                    return json_encode([
                        'status' => 0,
                        'message' => 'Employee already registred in this department, Cant delete!'
                    ]);
                }

                $query = "DELETE FROM departments WHERE Department_id = '$department_id'";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                
                return json_encode([
                    'status' => 1,
                    'message' => 'Department Deleted Successfully!'
                ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }

// Unit/Sections =======================================================================
    function unitsection_form(){
        $unit_section_name = htmlspecialchars(trim($_POST["unit_section_name"]));
        $department_id = htmlspecialchars(trim($_POST["department_id"]));

        try {
            $stmt = $this->db->prepare("SELECT unit_section_name FROM unit_section WHERE unit_section_name = ?");
            $stmt->execute([$unit_section_name]);
            $unit_section_nameTaken = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($unit_section_nameTaken) {
                return json_encode([
                    'status' => 0,
                    'message' => 'unit_section_name ' . $unit_section_nameTaken["unit_section_name"] . ' already taken please try another unit_section_name'
                ]);
            }

            $stmt = $this->db->prepare("INSERT INTO unit_section (unit_section_name, department_id) VALUES (?, ?)");
            $stmt->execute([$unit_section_name, $department_id]);

            return json_encode([
                'status' => 1,
                'message' => 'Unit Section created successfully!'
            ]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }
    function edit_unitsection(){
        $department_id = htmlspecialchars($_POST["department_id"] ?? '');
        $unit_section_id = htmlspecialchars($_POST["unit_section_id"] ?? '');
        $unit_section_name = htmlspecialchars($_POST["unit_section_name"] ?? '');

        try {

            $stmt = $this->db->prepare("UPDATE unit_section SET unit_section_name = :unit_section_name, department_id = :department_id WHERE unit_section_id = :unit_section_id");
            $stmt->execute(['unit_section_name' => $unit_section_name, 'department_id' => $department_id, 'unit_section_id' => $unit_section_id]);

            return json_encode([
                'status' => 1,
                'message' => 'Unit/Section Edited successfully!'
            ]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }
    function unitsection_delete_form(){
        try {
            $unit_section_id = $_POST["unit_section_id"];

                $stmt = $this->db->prepare("DELETE FROM unit_section WHERE unit_section_id = ?");
                $stmt->execute([$unit_section_id]);
                
                return json_encode([
                    'status' => 1,
                    'message' => 'Unit/Section Deleted Successfully!'
                ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }

// JOB TITLE ==============================================================================
    function update_jobInfo(){
        $jobTitles_id = htmlspecialchars($_POST["jobTitles_id"] ?? '');
        $jobTitle = htmlspecialchars($_POST["jobTitle"] ?? '');
        $jobTitle_code = htmlspecialchars($_POST["jobTitle_code"] ?? '');
        $salary = htmlspecialchars($_POST["salary"] ?? '');

        try {

            $stmt = $this->db->prepare("UPDATE jobTitles SET jobTitle = :jobTitle, jobTitle_code = :jobTitle_code,salary = :salary WHERE jobTitles_id = :jobTitles_id ");
            $stmt->execute(['jobTitle' => $jobTitle, 'jobTitle_code' => $jobTitle_code, 'salary' => $salary, 'jobTitles_id' => $jobTitles_id]);

            return json_encode([
                'status' => 1,
                'message' => 'Job title Edited successfully!'
            ]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }
    function jobtitle_delete_form(){
       try {
            $jobTitles_id = $_POST["jobTitles_id"];

                $stmt = $this->db->prepare("SELECT * FROM jobTitles jt
                    INNER JOIN hr_data hd ON jt.jobTitles_id = hd.jobtitle_id
                    WHERE jt.jobTitles_id = :jobTitles_id");

                $stmt->execute([
                    'jobTitles_id' => $jobTitles_id  
                ]);

                $employee_exist = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($employee_exist) {
                    return json_encode([
                        'status' => 0,
                        'message' => 'Employee already registred in with this job title, Cant delete!'
                    ]);
                }

                $query = "DELETE FROM jobTitles WHERE jobTitles_id = '$jobTitles_id'";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                
                return json_encode([
                    'status' => 1,
                    'message' => 'Job Title Deleted Successfully!'
                ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }
    function jobtitle_form(){
        $jobTitle = htmlspecialchars(trim($_POST["jobTitle"]));
        $jobTitle_code = htmlspecialchars(trim($_POST["jobTitle_code"]));
        $salary = htmlspecialchars(trim($_POST["salary"]));
        $department_id = ($_POST["department_id"]) ?? '';

        try {
            // Check if username exists using prepared statement
            $stmt = $this->db->prepare("SELECT jobTitle FROM jobTitles WHERE jobTitle = ?");
            $stmt->execute([$jobTitle]);
            $jobTitleTaken = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($jobTitleTaken) {
                return json_encode([
                    'status' => 0,
                    'message' => 'jobTitle ' . $jobTitleTaken["jobTitle"] . ' already taken please try another jobTitle'
                ]);
            }

            $stmt = $this->db->prepare("INSERT INTO jobTitles (jobTitle, jobTitle_code, salary, Department_id) VALUES (:jobTitle, :jobTitle_code, :salary, :Department_id)");
            $stmt->execute([
                'jobTitle' => $jobTitle,
                'jobTitle_code' => $jobTitle_code,
                'salary' => $salary,
                'Department_id' => $department_id
            ]);

            return json_encode([
                'status' => 1,
                'message' => 'job title created successfully!'
            ]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }

// ACCOUNT MANAGEMENT =====================================================================
    function validation_form(){
        // extract($_POST);
        $lastName = htmlspecialchars(trim($_POST["lastName"]));
        $firstName = htmlspecialchars(trim($_POST["firstName"]));
        $middleName = htmlspecialchars(trim($_POST["middleName"] ?? ''));
        $suffix = htmlspecialchars(trim($_POST["suffix"] ?? ''));
        $jobTitle_id  = htmlspecialchars(trim($_POST["jobTitle_id"]));
        $Department_id = filter_var(trim($_POST["Department_id"]), FILTER_SANITIZE_EMAIL);
        $gender = htmlspecialchars(trim($_POST["gender"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $user_role = htmlspecialchars($_POST["user_role"]);
        $contact = $_POST["contact"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];

        // Validation code remains the same...

        try {
            $stmtGetSalary = $this->db->prepare("SELECT salary FROM jobTitles WHERE jobTitles_id = '$jobTitle_id'");
            $stmtGetSalary->execute();
            $salaryResult = $stmtGetSalary->fetch(PDO::FETCH_ASSOC);
            $salary = $salaryResult["salary"] ?? '';

            // Check if username exists using prepared statement
            $stmt = $this->db->prepare("SELECT username FROM employee_data WHERE username = ?");
            $stmt->execute([$username]);
            $usernameTaken = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usernameTaken) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Username ' . $usernameTaken["username"] . ' already taken please try another username'
                ]);
            }

            // Check if email exists
            $stmt = $this->db->prepare("SELECT email FROM employee_data WHERE email = ?");
            $stmt->execute([$email]);
            $emailTaken = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($emailTaken) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Email address already registered'
                ]);
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            // FIXED: Use $this->db instead of $pdo
            $query = "INSERT INTO employee_data (firstname, middlename, lastname, suffix, email, contact, gender, username, password, user_role, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Active')";

            $stmt = $this->db->prepare($query); // CHANGED: $pdo to $this->db
            $stmt->execute([
                $firstName,
                $middleName,
                $lastName,
                $suffix,
                $email,
                $contact,
                $gender,
                $username,
                $hashedPassword,
                $user_role
            ]);

            $employee_id = $this->db->lastInsertId();
            $plusOne = $employee_id + 1;
            $employeeID = sprintf("%04d", $plusOne);
            
            $stmtUpdate = $this->db->prepare("UPDATE employee_data SET employeeID = :employeeID WHERE employee_id = :employee_id");
            $stmtUpdate->execute([
                'employeeID' => $employeeID,
                'employee_id' => $employee_id,
            ]);

            $stmtLeaveCounts = $this->db->prepare("
                INSERT INTO leaveCounts (employee_id, last_updated) 
                VALUES (:employee_id, CURDATE())
            ");

            $stmtLeaveCounts->execute([
                'employee_id' => $employee_id
            ]);

            $stmt = $this->db->prepare("INSERT INTO hr_data (employee_id, jobTitle_id, employeeID, Department_id, salary) VALUES ('$employee_id', '$jobTitle_id', '$employeeID', '$Department_id', '$salary')");
            $stmt->execute();

            $stmtSchedule = $this->db->prepare("INSERT INTO schedule (employee_id) VALUES ('$employee_id')");
            $stmtSchedule->execute();

            $stmtFamily = $this->db->prepare("INSERT INTO Family_data (employee_id, Relationship) 
            VALUES ('$employee_id', 'Father'), ('$employee_id', 'Mother'), ('$employee_id', 'Guardian')");
            $stmtFamily->execute();

            $stmtEducation = $this->db->prepare("INSERT INTO educational_data (employee_id, education_level) 
            VALUES ('$employee_id', 'Elementary'), ('$employee_id', 'High_school'), ('$employee_id', 'Senior_high')
            , ('$employee_id', 'College'), ('$employee_id', 'Graduate')");
            $stmtEducation->execute();

            $personal_data_sheet = $this->db->prepare("INSERT INTO personal_data_sheet (employee_id) VALUES ('$employee_id')");
            $personal_data_sheet->execute();

            $pds_id = $this->db->lastInsertId();
            
            $userGovIDs = $this->db->prepare("INSERT INTO userGovIDs (pds_id) VALUES ('$pds_id')");
            $userGovIDs->execute();



            $spouseInfo = $this->db->prepare("INSERT INTO spouseInfo (pds_id) VALUES ('$pds_id')");
            $spouseInfo->execute();

            $children = $this->db->prepare("INSERT INTO children (pds_id) VALUES ('$pds_id')");
            $children->execute();

            $parents = $this->db->prepare("INSERT INTO parents (pds_id) VALUES ('$pds_id')");
            $parents->execute();

            $siblings = $this->db->prepare("INSERT INTO siblings (pds_id) VALUES ('$pds_id')");
            $siblings->execute();

            $educationInfo = $this->db->prepare("INSERT INTO educationInfo (pds_id) VALUES ('$pds_id')");
            $educationInfo->execute();

            $workExperience = $this->db->prepare("INSERT INTO workExperience (pds_id) VALUES ('$pds_id')");
            $workExperience->execute();

            $seminarsTrainings = $this->db->prepare("INSERT INTO seminarsTrainings (pds_id) VALUES ('$pds_id')");
            $seminarsTrainings->execute();

            $otherInfo = $this->db->prepare("INSERT INTO otherInfo (pds_id) VALUES ('$pds_id')");
            $otherInfo->execute();
            
            return json_encode([
                'status' => 1,
                'message' => 'Account created successfully!'
            ]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }
    function registration_form() {
        $lastName = htmlspecialchars(trim($_POST["lastName"]));
        $firstName = htmlspecialchars(trim($_POST["firstName"]));
        $middleName = htmlspecialchars(trim($_POST["middleName"] ?? ''));
        $suffix = htmlspecialchars(trim($_POST["suffix"] ?? ''));
        $jobTitle_id = htmlspecialchars(trim($_POST["jobTitle_id"]));
        $Department_id = htmlspecialchars(trim($_POST["Department_id"]));
        $gender = htmlspecialchars(trim($_POST["gender"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $contact = htmlspecialchars(trim($_POST["contact"]));
        $username = htmlspecialchars(trim($_POST["username"]));
        $password = htmlspecialchars(trim($_POST["password"]));
        $cpassword = htmlspecialchars(trim($_POST["cpassword"]));

        // Check passwords match
        if ($password !== $cpassword) {
            return json_encode([
                'status' => 0,
                'message' => 'Passwords do not match!'
            ]);
        }

        // Store data in session
        $_SESSION["registration_data"] = [
            "lastName" => $lastName,
            "firstName" => $firstName,
            "middleName" => $middleName,
            "suffix" => $suffix,
            "jobTitle_id" => $jobTitle_id,
            "Department_id" => $Department_id,
            "gender" => $gender,
            "email" => $email,
            "contact" => $contact,
            "username" => $username,
            "password" => $password,
            "cpassword" => $cpassword
        ];

        try {
            // ------------------ Check if username exists ------------------
            $stmt = $this->db->prepare("SELECT username FROM employee_data WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                return json_encode(['status' => 0, 'message' => 'Username already taken']);
            }

            // ------------------ Check if email exists ------------------
            $stmt = $this->db->prepare("SELECT email FROM employee_data WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                return json_encode(['status' => 0, 'message' => 'Email already registered']);
            }

            // ------------------ Generate 6-digit verification code ------------------
            $verification = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $_SESSION["verification"] = $verification;

            // ------------------ Send email ------------------
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'pagotaisidromarcojean123@gmail.com';
            $mail->Password = 'piji jfrn znjb eaey'; // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('pagotaisidromarcojean123@gmail.com', 'HR OFFICE');
            $mail->addAddress($email, $firstName . ' ' . $lastName);

            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Account';
            $mail->Body = "
                <h3>Hello " . htmlspecialchars($firstName) . "!</h3>
                <p>Welcome to Zamboanga Puericulture Center Org. No. 144.</p>
                <p>Your verification code is:</p>
                <h2 style='color:#2e6c80;'>" . htmlspecialchars($verification) . "</h2>
                <p>Enter this code in the verification form to activate your account.</p>
            ";
            $mail->AltBody = 'Hello ' . $firstName . ', your verification code is: ' . $verification;

            $mail->send();

            return json_encode([
                'status' => 1,
                'redirectUrl'=>'./authentication/verification_action.php',
                'message' => 'Verification code sent successfully! Please check your email.'
            ]);

        } catch (Exception $e) {
            error_log("PHPMailer Error: " . $e->getMessage());
            return json_encode(['status' => 0, 'message' => 'Email could not be sent.']);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return json_encode(['status' => 0, 'message' => 'An internal error occurred.']);
        }
    }
    function verification_form() {
        extract($_POST);
        try {
            $verification_code_input = $_POST["verification_code"] ?? '';
            $verification_code = $_SESSION["verification"] ?? '';

            if ($verification_code_input !== $verification_code) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Verification code is incorrect!'
                ]);
            }

            if (!isset($_SESSION["registration_data"])) {
                return json_encode([
                    'status' => 0,
                    'message' => 'No registration data found. Please register again.'
                ]);
            }

            $data = $_SESSION["registration_data"];

            $lastName = $data["lastName"];
            $firstName = $data["firstName"];
            $middleName = $data["middleName"];
            $suffix = $data["suffix"];
            $jobTitle_id = $data["jobTitle_id"];
            $Department_id = $data["Department_id"];
            $gender = $data["gender"];
            $email = $data["email"];
            $contact = $data["contact"];
            $username = $data["username"];
            $password = $data["password"];

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $user_role = "EMPLOYEE";

            // Get salary for job title
            $stmt = $this->db->prepare("SELECT salary FROM jobTitles WHERE jobTitles_id = ?");
            $stmt->execute([$jobTitle_id]);
            $salaryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $salary = $salaryResult["salary"] ?? 0;

            // Insert into employee_data
            $stmt = $this->db->prepare("
                INSERT INTO employee_data 
                (firstname, middlename, lastname, suffix, email, contact, gender, username, password, user_role)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$firstName, $middleName, $lastName, $suffix, $email, $contact, $gender, $username, $hashedPassword, $user_role]);

            
            $employee_id = $this->db->lastInsertId();
            $plusOne = $employee_id + 1;
            $employeeID = sprintf("%04d", $plusOne);
            
            $stmtUpdate = $this->db->prepare("UPDATE employee_data SET employeeID = :employeeID WHERE employee_id = :employee_id");
            $stmtUpdate->execute([
                'employeeID' => $employeeID,
                'employee_id' => $employee_id,
            ]);

            $stmtLeaveCounts = $this->db->prepare("
                INSERT INTO leaveCounts (employee_id, last_updated) 
                VALUES (:employee_id, CURDATE())
            ");

            $stmtLeaveCounts->execute([
                'employee_id' => $employee_id
            ]);


            // Insert into hr_data
            $stmt = $this->db->prepare("
                INSERT INTO hr_data (employee_id, jobTitle_id, employeeID, Department_id, salary)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$employee_id, $jobTitle_id, $employeeID, $Department_id, $salary]);

            $stmt = $this->db->prepare("INSERT INTO schedule (employee_id) VALUES (?)");
            $stmt->execute([$employee_id]);
    

            // Insert Family data
            $relationships = ['Father', 'Mother', 'Guardian'];
            $values = [];
            foreach ($relationships as $rel) {
                $values[] = "($employee_id, '$rel')";
            }
            $this->db->exec("INSERT INTO Family_data (employee_id, Relationship) VALUES " . implode(',', $values));

            // Personal Data Sheet
            $stmt = $this->db->prepare("INSERT INTO personal_data_sheet (employee_id) VALUES (?)");
            $stmt->execute([$employee_id]);
            $pds_id = $this->db->lastInsertId();

            $tablesPDS = ['userGovIDs', 'spouseInfo', 'children', 'parents', 'siblings', 'educationInfo', 'workExperience', 'seminarsTrainings', 'otherInfo'];
            foreach ($tablesPDS as $table) {
                $stmt = $this->db->prepare("INSERT INTO $table (pds_id) VALUES (?)");
                $stmt->execute([$pds_id]);
            }

            // Clean session
            unset($_SESSION["registration_data"]);
            unset($_SESSION["verification"]);

            return json_encode([
                'status' => 1,
                'message' => 'Account created successfully!'
            ]);

        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
    function delete_employee_form(){
        $employee_id = htmlspecialchars($_POST["employee_id"] ?? '');

        if (empty($employee_id)) {
            return json_encode([
                'status' => 0,
                'message' => 'Employee ID is required.'
            ]);
        }

        try {

            $stmt = $this->db->prepare("DELETE FROM employee_data WHERE employee_id = ?");
            $stmt->execute([$employee_id]);

            return json_encode([
                'status' => 1,
                'message' => 'Account deleted successfully!'
            ]);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }
    function approval_form(){
        $employee_ID = htmlspecialchars($_POST["employee_ID"] ?? '');

        if (empty($employee_ID)) {
            return json_encode([
                'status' => 0,
                'message' => 'Employee ID is required.'
            ]);
        }

        try {
            // Get employee data
            $stmt = $this->db->prepare("SELECT email, firstname, lastname FROM employee_data WHERE employee_id = :employee_id");
            $stmt->execute(['employee_id' => $employee_ID]);
            $employee_data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$employee_data) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Employee not found.'
                ]);
            }

            $email = $employee_data["email"];
            $firstname = $employee_data["firstname"];
            $lastname = $employee_data["lastname"];

            // Update status first
            $stmt = $this->db->prepare("UPDATE employee_data SET status = 'Active' WHERE employee_id = :employee_id");
            $stmt->execute(['employee_id' => $employee_ID]);

            // Send email with short timeout
            $this->quickEmailSend($email, $firstname, $lastname);

            return json_encode([
                'status' => 1,
                'message' => 'Account validated successfully!'
            ]);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }
    function rejection_form(){
        $employee_ID = htmlspecialchars($_POST["employee_ID"] ?? '');

        // Validate input
        if (empty($employee_ID)) {
            return json_encode([
                'status' => 0,
                'message' => 'Employee ID is required.'
            ]);
        }

        try {
            // Fetch employee info
            $stmt = $this->db->prepare("SELECT email, firstname, lastname FROM employee_data WHERE employee_id = :employee_id");
            $stmt->execute(['employee_id' => $employee_ID]);
            $employee_data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$employee_data) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Employee not found.'
                ]);
            }

            $email = $employee_data["email"];
            $firstname = $employee_data["firstname"];
            $lastname = $employee_data["lastname"];

            // Update employee status to Inactive
            $stmt = $this->db->prepare("UPDATE employee_data SET status = 'Inactive' WHERE employee_id = :employee_id");
            $stmt->execute(['employee_id' => $employee_ID]);

            // OPTIONAL: Send rejection email
            $this->quickRejectionEmail($email, $firstname, $lastname);

            return json_encode([
                'status' => 1,
                'message' => 'Account rejected successfully!'
            ]);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }
    function select_status() {
        try {
            $status = $_POST["status"] ?? null;
            $employee_id = $_POST["employee_id"] ?? null;

            if (!$status || !$employee_id) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Missing status or employee ID.'
                ]);
            }

            $stmt = $this->db->prepare("UPDATE employee_data SET status = :status WHERE employee_id = :employee_id");
            $stmt->execute([
                'status' => $status,
                'employee_id' => $employee_id
            ]);

            return json_encode([
                'status' => 1,
                'message' => 'Status Updated Successfully'
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }
    // QUICK EMAIL HELPER ===================================================================
    private function quickEmailSend($email, $firstname, $lastname){
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'pagotaisidromarcojean123@gmail.com';
            $mail->Password = 'piji jfrn znjb eaey';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Timeout = 10; // 10 second timeout
            $mail->SMTPDebug = 0; // No debug output
            
            $mail->setFrom('pagotaisidromarcojean123@gmail.com', 'HR OFFICE');
            $mail->addAddress($email, $firstname . ' ' . $lastname);
            
            $mail->isHTML(true);
            $mail->Subject = 'Account Approved - Zamboanga Puericulture Center';
            $mail->Body = "
                <h3>Hello " . htmlspecialchars($firstname) . "!</h3>
                <p>Welcome to Zamboanga Puericulture Center Org. No. 144 - Admin Portal.</p>
                <p>Your account request has been successfully approved!</p>
                <p>You can now login to the system using your credentials.</p>
            ";
            
            // Don't wait too long for send
            $mail->send();
            
        } catch (Exception $e) {
            error_log("Email sending failed for $email: " . $e->getMessage());
        }
    }
    
    private function quickRejectionEmail($email, $firstname, $lastname){
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'pagotaisidromarcojean123@gmail.com';
            $mail->Password = 'piji jfrn znjb eaey';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Timeout = 10;

            $mail->setFrom('pagotaisidromarcojean123@gmail.com', 'HR OFFICE');
            $mail->addAddress($email, $firstname . ' ' . $lastname);

            $mail->isHTML(true);
            $mail->Subject = 'Account Rejected - Zamboanga Puericulture Center';
            $mail->Body = "
                <h3>Hello " . htmlspecialchars($firstname) . "!</h3>
                <p>We appreciate your interest in joining the Zamboanga Puericulture Center Admin Portal.</p>
                <p>Unfortunately, your account request has been <strong>rejected</strong> at this time.</p>
                <p>If you believe this is a mistake, please contact the HR Office.</p>
            ";

            $mail->send();

        } catch (Exception $e) {
            error_log("Rejection email failed for $email: " . $e->getMessage());
        }
    }

// PROFILE MANAGEMENT ADMIN =============================================================
    function profile_update(){
        $employee_id = htmlspecialchars($_POST["employee_id"]);
        $firstname = htmlspecialchars($_POST["firstname"]);
        $middlename = htmlspecialchars($_POST["middlename"]);
        $lastname = htmlspecialchars($_POST["lastname"]);
        $suffix = htmlspecialchars($_POST["suffix"]);
        $citizenship = htmlspecialchars($_POST["citizenship"]);
        $gender = htmlspecialchars($_POST["gender"]);
        $civil_status = htmlspecialchars($_POST["civil_status"]);
        $religion = htmlspecialchars($_POST["religion"]);
        $birthday = htmlspecialchars($_POST["birthday"]);
        $birthPlace = htmlspecialchars($_POST["birthPlace"]);
        $contact = htmlspecialchars($_POST["contact"]);
        $email = htmlspecialchars($_POST["email"]);

        $houseBlock = htmlspecialchars($_POST["houseBlock"]);
        $street = htmlspecialchars($_POST["street"]);
        $subdivision = htmlspecialchars($_POST["subdivision"]);
        $barangay = htmlspecialchars($_POST["barangay"]);
        $city_muntinlupa = htmlspecialchars($_POST["city_muntinlupa"]);
        $province = htmlspecialchars($_POST["province"]);
        $zip_code = htmlspecialchars($_POST["zip_code"]);

        try {
            // ✅ Update employee_data
            $stmtEmployee = $this->db->prepare("
                UPDATE employee_data 
                SET firstname = :firstname,
                    middlename = :middlename,
                    lastname = :lastname,
                    suffix = :suffix,
                    citizenship = :citizenship,
                    gender = :gender,
                    civil_status = :civil_status,
                    religion = :religion,
                    birthday = :birthday,
                    birthPlace = :birthPlace,
                    contact = :contact,
                    email = :email
                WHERE employee_id = :employee_id
            ");
            $stmtEmployee->execute([
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'suffix' => $suffix,
                'citizenship' => $citizenship,
                'gender' => $gender,
                'civil_status' => $civil_status,
                'religion' => $religion,
                'birthday' => $birthday,
                'birthPlace' => $birthPlace,
                'contact' => $contact,
                'email' => $email,
                'employee_id' => $employee_id
            ]);

            // ✅ Update hr_data
            $stmtHR = $this->db->prepare("
                UPDATE hr_data 
                SET houseBlock = :houseBlock,
                    street = :street,
                    subdivision = :subdivision,
                    barangay = :barangay,
                    city_muntinlupa = :city_muntinlupa,
                    province = :province,
                    zip_code = :zip_code
                WHERE employee_id = :employee_id
            ");
            $stmtHR->execute([
                'houseBlock' => $houseBlock,
                'street' => $street,
                'subdivision' => $subdivision,
                'barangay' => $barangay,
                'city_muntinlupa' => $city_muntinlupa,
                'province' => $province,
                'zip_code' => $zip_code,
                'employee_id' => $employee_id
            ]);

            return json_encode([
                'status' => 1,
                'message' => 'Profile updated successfully!'
            ]);
        } catch (PDOException $e) {
            error_log("Database error (profile_update): " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred while updating. Please try again later.'
            ]);
        }
    }
    function employment_update(){
        $salary = htmlSpecialChars($_POST["salary"] ?? '');
        $scheduleFrom = htmlSpecialChars($_POST["scheduleFrom"] ?? '');
        $scheduleTo = htmlSpecialChars($_POST["scheduleTo"] ?? '');
        $shift_type = htmlSpecialChars($_POST["shift_type"] ?? '');
        $work_days = htmlSpecialChars($_POST["work_days"] ?? '');
        $admin_update = htmlSpecialChars($_POST["admin_update"]);
        $unit_section_id = htmlSpecialChars($_POST["unit_section_id"]);
        $joined_at = htmlSpecialChars($_POST["joined_at"]);

        try {
            if($unit_section_id == ''){
                return json_encode([
                    'status' => 0,
                    'message' => 'Unit'
                ]);
            }
            if($admin_update == 'true'){
                $admin_employee_id = htmlSpecialChars($_POST["admin_employee_id"]);
                $admin_department_id = htmlSpecialChars($_POST["admin_department_id"]);
                $admin_position_id = htmlSpecialChars($_POST["admin_position_id"]);
                $admin_id = 1;

                $stmt = $this->db->prepare("UPDATE admin SET joined_at = :joined_at WHERE admin_id = :admin_id");
                $stmt->execute([
                    'joined_at' => $joined_at,
                    'admin_id' => $admin_id
                ]);

                $stmt = $this->db->prepare("UPDATE admin_info SET admin_employee_id = :admin_employee_id, admin_position_id = :admin_position_id,
                    admin_department_id = :admin_department_id, salary = :salary, unit_section_id = :unit_section_id WHERE
                    admin_id = :admin_id");
                    $stmt->execute([
                        'admin_id' => $admin_id,
                        'admin_employee_id' => $admin_employee_id,
                        'admin_position_id' => $admin_position_id,
                        'admin_department_id' => $admin_department_id,
                        'salary' => $salary,
                        'unit_section_id' => $unit_section_id
                    ]);

                    $stmtSchdule = $this->db->prepare("UPDATE admin_schedule SET  shift_type = :shift_type, work_days = :work_days, scheduleFrom = :scheduleFrom, scheduleTo = :scheduleTo WHERE admin_id = :admin_id");
                    $stmtSchdule->execute([
                        'shift_type'          => $shift_type,
                        'work_days'     => $work_days,
                        'scheduleFrom' => $scheduleFrom,
                        'scheduleTo' => $scheduleTo,
                        'admin_id'     => $admin_id
                    ]);
            }else if($admin_update == 'false'){
                $employee_id = htmlSpecialChars($_POST["employee_id"]);
                $employeeID = htmlSpecialChars($_POST["employeeID"]);
                $Department_id = htmlSpecialChars($_POST["Department_id"]);

                $stmt = $this->db->prepare("UPDATE hr_data SET employeeID = :employeeID, Department_id = :Department_id, salary = :salary, 
                scheduleFrom = :scheduleFrom, scheduleTo = :scheduleTo, joined_at = :joined_at, unit_section_id = :unit_section_id WHERE employee_id = :employee_id");
                $stmt->execute([
                    'employee_id' => $employee_id,
                    'employeeID' => $employeeID,
                    'Department_id' => $Department_id,
                    'salary' => $salary,
                    'scheduleFrom' => $scheduleFrom,
                    'scheduleTo' => $scheduleTo,
                    'joined_at' => $joined_at,
                    'unit_section_id' => $unit_section_id
                ]);

                $stmtSchdule = $this->db->prepare("UPDATE schedule SET  shift_type = :shift_type, work_days = :work_days WHERE employee_id = :employee_id");
                $stmtSchdule->execute([
                    'shift_type'          => $shift_type,
                    'work_days'     => $work_days,
                    'employee_id'     => $employee_id
                ]);
            }
            return json_encode([
                'status' => 1,
                'message' => 'Profile updated successfu lly!'
            ]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later: ' . $e->getMessage()
            ]);
        }
    }
    function family_update() {
        try {
            // Ensure required data
            $employee_id = $_POST['employee_id'] ?? null;
            if (!$employee_id) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Employee ID is missing.'
                ]);
            }

            // Map of relationships with their correct prefixes
            $relationships = [
                'Father' => 'father_',
                'Mother' => 'mother_', 
                'Guardian' => 'guardian_',
                'Spouse' => 'spouse_'
            ];

            // Loop through each relationship and update
            foreach ($relationships as $relation => $prefix) {
                // Build field names dynamically using the correct prefix
                $firstname   = $_POST[$prefix . 'firstname'] ?? null;
                $middlename  = $_POST[$prefix . 'middlename'] ?? null;
                $lastname    = $_POST[$prefix . 'lastname'] ?? null;
                $occupation  = $_POST[$prefix . 'occupation'] ?? null;
                $contact     = $_POST[$prefix . 'contact'] ?? null;
                $house_block = $_POST[$prefix . 'house_block'] ?? null;
                $street      = $_POST[$prefix . 'street'] ?? null;
                $subdivision = $_POST[$prefix . 'subdivision'] ?? null;
                $barangay    = $_POST[$prefix . 'barangay'] ?? null;
                $city        = $_POST[$prefix . 'city'] ?? null;
                $province    = $_POST[$prefix . 'province'] ?? null;
                $zip_code    = $_POST[$prefix . 'zip_code'] ?? null;

                // Debug: Check what values we're getting
                error_log("Processing $relation: $firstname, $lastname");

                // Skip if all fields are empty
                if (!$firstname && !$lastname && !$occupation && !$contact) {
                    error_log("Skipping $relation - all fields empty");
                    continue;
                }

                // Check if record exists
                $check = $this->db->prepare("SELECT Family_data_id FROM Family_data WHERE employee_id = :employee_id AND Relationship = :relationship");
                $check->execute([':employee_id' => $employee_id, ':relationship' => $relation]);
                $exists = $check->rowCount() > 0;

                if ($exists) {
                    // Update existing record
                    $stmt = $this->db->prepare("
                        UPDATE Family_data SET
                            firstname = :firstname,
                            middlename = :middlename,
                            lastname = :lastname,
                            occupation = :occupation,
                            contact = :contact,
                            house_block = :house_block,
                            street = :street,
                            subdivision = :subdivision,
                            barangay = :barangay,
                            city = :city,
                            province = :province,
                            zip_code = :zip_code
                        WHERE employee_id = :employee_id AND Relationship = :relationship
                    ");
                    error_log("Updating existing $relation record");
                } else {
                    // Insert new if missing
                    $stmt = $this->db->prepare("
                        INSERT INTO Family_data (
                            employee_id, Relationship, firstname, middlename, lastname, occupation, contact,
                            house_block, street, subdivision, barangay, city, province, zip_code
                        ) VALUES (
                            :employee_id, :relationship, :firstname, :middlename, :lastname, :occupation, :contact,
                            :house_block, :street, :subdivision, :barangay, :city, :province, :zip_code
                        )
                    ");
                    error_log("Inserting new $relation record");
                }

                // Bind and execute
                $result = $stmt->execute([
                    ':employee_id' => $employee_id,
                    ':relationship' => $relation,
                    ':firstname' => $firstname,
                    ':middlename' => $middlename,
                    ':lastname' => $lastname,
                    ':occupation' => $occupation,
                    ':contact' => $contact,
                    ':house_block' => $house_block,
                    ':street' => $street,
                    ':subdivision' => $subdivision,
                    ':barangay' => $barangay,
                    ':city' => $city,
                    ':province' => $province,
                    ':zip_code' => $zip_code
                ]);

                if (!$result) {
                    error_log("Failed to save $relation data");
                } else {
                    error_log("Successfully saved $relation data");
                }
            }

            return json_encode([
                'status' => 1,
                'message' => 'Family information updated successfully.'
            ]);

        } catch (PDOException $e) {
            error_log("Family Update Error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }
    function educational_update() {
        try {
            // Ensure required data
            $employee_id = $_POST['employee_id'] ?? null;
            if (!$employee_id) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Employee ID is missing.'
                ]);
            }

            // Map of education levels
            $education_levels = [
                'Elementary' => [
                    'school_name' => $_POST['elementary_school_name'] ?? '',
                    'year_started' => $_POST['elementary_year_started'] ?? '',
                    'year_ended' => $_POST['elementary_year_ended'] ?? '',
                    'course_strand' => '', // Elementary doesn't have course/strand
                    'honors' => $_POST['elementary_honors'] ?? ''
                ],
                'High_school' => [
                    'school_name' => $_POST['high_school_school_name'] ?? '',
                    'year_started' => $_POST['high_school_year_started'] ?? '',
                    'year_ended' => $_POST['high_school_year_ended'] ?? '',
                    'course_strand' => '', // High school doesn't have course/strand
                    'honors' => $_POST['high_school_honors'] ?? ''
                ],
                'Senior_high' => [
                    'school_name' => $_POST['senior_high_school_name'] ?? '',
                    'year_started' => $_POST['senior_high_year_started'] ?? '',
                    'year_ended' => $_POST['senior_high_year_ended'] ?? '',
                    'course_strand' => $_POST['senior_high_course_strand'] ?? '',
                    'honors' => $_POST['senior_high_honors'] ?? ''
                ],
                'College' => [
                    'school_name' => $_POST['college_school_name'] ?? '',
                    'year_started' => $_POST['college_year_started'] ?? '',
                    'year_ended' => $_POST['college_year_ended'] ?? '',
                    'course_strand' => $_POST['college_course_strand'] ?? '',
                    'honors' => $_POST['college_honors'] ?? ''
                ],
                'Graduate' => [
                    'school_name' => $_POST['graduate_school_name'] ?? '',
                    'year_started' => $_POST['graduate_year_started'] ?? '',
                    'year_ended' => $_POST['graduate_year_ended'] ?? '',
                    'course_strand' => $_POST['graduate_course_strand'] ?? '',
                    'honors' => $_POST['graduate_honors'] ?? ''
                ]
            ];

            // Loop through each education level and update
            foreach ($education_levels as $level => $data) {
                // Skip if all fields are empty
                if (empty($data['school_name']) && empty($data['year_started']) && 
                    empty($data['year_ended']) && empty($data['course_strand']) && 
                    empty($data['honors'])) {
                    continue;
                }

                // Check if record exists
                $check = $this->db->prepare("SELECT educational_data_id FROM educational_data WHERE employee_id = :employee_id AND education_level = :education_level");
                $check->execute([':employee_id' => $employee_id, ':education_level' => $level]);

                if ($check->rowCount() > 0) {
                    // Update existing record
                    $stmt = $this->db->prepare("
                        UPDATE educational_data SET
                            school_name = :school_name,
                            year_started = :year_started,
                            year_ended = :year_ended,
                            course_strand = :course_strand,
                            honors = :honors
                        WHERE employee_id = :employee_id AND education_level = :education_level
                    ");
                } else {
                    // Insert new if missing
                    $stmt = $this->db->prepare("
                        INSERT INTO educational_data (
                            employee_id, education_level, school_name, year_started, 
                            year_ended, course_strand, honors
                        ) VALUES (
                            :employee_id, :education_level, :school_name, :year_started,
                            :year_ended, :course_strand, :honors
                        )
                    ");
                }

                // Bind and execute
                $stmt->execute([
                    ':employee_id' => $employee_id,
                    ':education_level' => $level,
                    ':school_name' => $data['school_name'],
                    ':year_started' => $data['year_started'],
                    ':year_ended' => $data['year_ended'],
                    ':course_strand' => $data['course_strand'],
                    ':honors' => $data['honors']
                ]);
            }

            return json_encode([
                'status' => 1,
                'message' => 'Educational information updated successfully.'
            ]);

        } catch (PDOException $e) {
            error_log("Educational Update Error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }
    function admin_profile_update(){
        $admin_firstname = $_POST["admin_firstname"];
        $admin_middlename = $_POST["admin_middlename"];
        $admin_lastname = $_POST["admin_lastname"];
        $admin_suffix = $_POST["admin_suffix"];
        $admin_citizenship = $_POST["admin_citizenship"];
        $admin_gender = $_POST["admin_gender"];
        $admin_civil_status = $_POST["admin_civil_status"];
        $admin_religion = $_POST["admin_religion"];
        $admin_birth = $_POST["admin_birth"];
        $admin_birthPlace = $_POST["admin_birthPlace"];
        $admin_cpno = $_POST["admin_cpno"];
        $admin_email = $_POST["admin_email"];
        $admin_house = $_POST["admin_house"];
        $admin_street = $_POST["admin_street"];
        $admin_subdivision = $_POST["admin_subdivision"];
        $admin_barangay = $_POST["admin_barangay"];
        $admin_city = $_POST["admin_city"];
        $admin_province = $_POST["admin_province"];
        $admin_zip_code = $_POST["admin_zip_code"];
        $admin_id = 1;
        try {
            $admin_picture = null;
            if (isset($_FILES['admin_picture']) && $_FILES['admin_picture']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                
                // Create uploads directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $file = $_FILES['admin_picture'];
                $fileName = $file['name'];
                $fileTmp = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];
                $fileType = $file['type'];
                
                // Get file extension
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                // Allowed extensions
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                // Validate file
                if (in_array($fileExt, $allowedExtensions)) {
                    if ($fileError === 0) {
                        // Check file size (max 5MB)
                        if ($fileSize <= 5 * 1024 * 1024) {
                            // Generate unique filename
                            $newFileName = 'profile_' . $admin_id . '_' . time() . '.' . $fileExt;
                            $fileDestination = $uploadDir . $newFileName;
                            
                            // Move uploaded file
                            if (move_uploaded_file($fileTmp, $fileDestination)) {
                                $admin_picture = $newFileName;
                                // Delete old profile picture if exists
                                $stmtOldPic = $this->db->prepare("SELECT admin_picture FROM admin WHERE admin_id = ?");
                                $stmtOldPic->execute([$admin_id]);
                                $oldPic = $stmtOldPic->fetchColumn();
                                
                                if ($oldPic && file_exists($uploadDir . $oldPic)) {
                                    unlink($uploadDir . $oldPic);
                                }
                            } else {
                                error_log("Failed to move uploaded file: " . $fileTmp . " to " . $fileDestination);
                            }
                        } else {
                            return json_encode([
                                'status' => 0,
                                'message' => 'Profile picture is too large. Maximum size is 5MB.'
                            ]);
                        }
                    } else {
                        return json_encode([
                            'status' => 0,
                            'message' => 'Error uploading profile picture. Error code: ' . $fileError
                        ]);
                    }
                } else {
                    return json_encode([
                        'status' => 0,
                        'message' => 'Invalid file type. Allowed: JPG, JPEG, PNG, GIF, WEBP'
                    ]);
                }
            }
            $stmtAdmin = $this->db->prepare("UPDATE admin SET admin_firstname = :admin_firstname,
                admin_middlename = :admin_middlename, admin_lastname = :admin_lastname, admin_suffix = :admin_suffix,
                admin_citizenship = :admin_citizenship, admin_gender = :admin_gender, admin_civil_status = :admin_civil_status,
                admin_religion = :admin_religion, admin_birth = :admin_birth, admin_birthPlace = :admin_birthPlace,
                admin_cpno = :admin_cpno, admin_email = :admin_email, admin_picture = :admin_picture WHERE admin_id = :admin_id");
         
            $stmtAdmin->execute([
                'admin_picture' => $admin_picture,
                'admin_firstname' => $admin_firstname,
                'admin_middlename' => $admin_middlename,
                'admin_lastname' => $admin_lastname,
                'admin_suffix' => $admin_suffix,
                'admin_citizenship' => $admin_citizenship,
                'admin_gender' => $admin_gender,
                'admin_civil_status' => $admin_civil_status,
                'admin_religion' => $admin_religion,
                'admin_birth' => $admin_birth,
                'admin_birthPlace' => $admin_birthPlace,
                'admin_cpno' => $admin_cpno,
                'admin_email' => $admin_email,
                'admin_id' => $admin_id
            ]);

            $stmtAdminIfo = $this->db->prepare("UPDATE admin_info SET admin_province = :admin_province,
                admin_city = :admin_city, admin_barangay = :admin_barangay, admin_subdivision = :admin_subdivision,
                admin_house = :admin_house, admin_street = :admin_street, admin_zip_code = :admin_zip_code WHERE admin_id = :admin_id");
            $stmtAdminIfo->execute([
                'admin_subdivision' => $admin_subdivision,
                'admin_barangay' => $admin_barangay,
                'admin_city' => $admin_city,
                'admin_province' => $admin_province,
                'admin_zip_code' => $admin_zip_code, 
                'admin_street' => $admin_street, 
                'admin_house' => $admin_house,
                'admin_id' => $admin_id    
            ]);
            return json_encode([
                'status' => 1,
                'message' => 'Personal Information updated successfully!'
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }

// PROFILE MANAGEMENT EMPLOYEES =============================================================
    function profile_update_employee() {
        // Sanitize input safely
        $employee_id     = htmlspecialchars(trim($_POST["employee_id"] ?? ''));
        $firstname       = htmlspecialchars(trim($_POST["firstname"] ?? ''));
        $middlename      = htmlspecialchars(trim($_POST["middlename"] ?? ''));
        $lastname        = htmlspecialchars(trim($_POST["lastname"] ?? ''));
        $suffix          = htmlspecialchars(trim($_POST["suffix"] ?? ''));
        $citizenship     = htmlspecialchars(trim($_POST["citizenship"] ?? ''));
        $gender          = htmlspecialchars(trim($_POST["gender"] ?? ''));
        $civil_status    = htmlspecialchars(trim($_POST["civil_status"] ?? ''));
        $religion        = htmlspecialchars(trim($_POST["religion"] ?? ''));
        $birthday        = htmlspecialchars(trim($_POST["birthday"] ?? ''));
        $birthPlace      = htmlspecialchars(trim($_POST["birthPlace"] ?? ''));
        $contact         = htmlspecialchars(trim($_POST["contact"] ?? ''));
        $email           = htmlspecialchars(trim($_POST["email"] ?? ''));
        $houseBlock      = htmlspecialchars(trim($_POST["houseBlock"] ?? ''));
        $street          = htmlspecialchars(trim($_POST["street"] ?? ''));
        $subdivision     = htmlspecialchars(trim($_POST["subdivision"] ?? ''));
        $barangay        = htmlspecialchars(trim($_POST["barangay"] ?? ''));
        $city_muntinlupa = htmlspecialchars(trim($_POST["city_muntinlupa"] ?? ''));
        $province        = htmlspecialchars(trim($_POST["province"] ?? ''));
        $zip_code        = htmlspecialchars(trim($_POST["zip_code"] ?? ''));
        
        if (empty($employee_id)) {
            return json_encode([
                'status' => 0,
                'message' => 'Employee ID is missing.'
            ]);
        }

        try {
            // ✅ Handle profile picture upload
            $profile_picture = null;
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                
                // Create uploads directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $file = $_FILES['profile_picture'];
                $fileName = $file['name'];
                $fileTmp = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];
                $fileType = $file['type'];
                
                // Get file extension
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                // Allowed extensions
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                // Validate file
                if (in_array($fileExt, $allowedExtensions)) {
                    if ($fileError === 0) {
                        // Check file size (max 5MB)
                        if ($fileSize <= 5 * 1024 * 1024) {
                            // Generate unique filename
                            $newFileName = 'profile_' . $employee_id . '_' . time() . '.' . $fileExt;
                            $fileDestination = $uploadDir . $newFileName;
                            
                            // Move uploaded file
                            if (move_uploaded_file($fileTmp, $fileDestination)) {
                                $profile_picture = $newFileName;
                                
                                // Delete old profile picture if exists
                                $stmtOldPic = $this->db->prepare("SELECT profile_picture FROM employee_data WHERE employee_id = ?");
                                $stmtOldPic->execute([$employee_id]);
                                $oldPic = $stmtOldPic->fetchColumn();
                                
                                if ($oldPic && file_exists($uploadDir . $oldPic)) {
                                    unlink($uploadDir . $oldPic);
                                }
                            } else {
                                error_log("Failed to move uploaded file: " . $fileTmp . " to " . $fileDestination);
                            }
                        } else {
                            return json_encode([
                                'status' => 0,
                                'message' => 'Profile picture is too large. Maximum size is 5MB.'
                            ]);
                        }
                    } else {
                        return json_encode([
                            'status' => 0,
                            'message' => 'Error uploading profile picture. Error code: ' . $fileError
                        ]);
                    }
                } else {
                    return json_encode([
                        'status' => 0,
                        'message' => 'Invalid file type. Allowed: JPG, JPEG, PNG, GIF, WEBP'
                    ]);
                }
            }
            
            // ✅ Update employee_data with profile picture
            if ($profile_picture) {
                $stmtEmployeeData = $this->db->prepare("
                    UPDATE employee_data 
                    SET firstname = :firstname,
                        middlename = :middlename,
                        lastname = :lastname,
                        suffix = :suffix,
                        citizenship = :citizenship,
                        gender = :gender,
                        civil_status = :civil_status,
                        religion = :religion,
                        birthday = :birthday,
                        birthPlace = :birthPlace,
                        contact = :contact,
                        email = :email,
                        profile_picture = :profile_picture
                    WHERE employee_id = :employee_id
                ");
                $stmtEmployeeData->execute([
                    'firstname'       => $firstname,
                    'middlename'      => $middlename,
                    'lastname'        => $lastname,
                    'suffix'          => $suffix,
                    'citizenship'     => $citizenship,
                    'gender'          => $gender,
                    'civil_status'    => $civil_status,
                    'religion'        => $religion,
                    'birthday'        => $birthday,
                    'birthPlace'      => $birthPlace,
                    'contact'         => $contact,
                    'email'           => $email,
                    'profile_picture' => $profile_picture,
                    'employee_id'     => $employee_id
                ]);
            } else {
                $stmtEmployeeData = $this->db->prepare("
                    UPDATE employee_data 
                    SET firstname = :firstname,
                        middlename = :middlename,
                        lastname = :lastname,
                        suffix = :suffix,
                        citizenship = :citizenship,
                        gender = :gender,
                        civil_status = :civil_status,
                        religion = :religion,
                        birthday = :birthday,
                        birthPlace = :birthPlace,
                        contact = :contact,
                        email = :email
                    WHERE employee_id = :employee_id
                ");
                $stmtEmployeeData->execute([
                    'firstname'     => $firstname,
                    'middlename'    => $middlename,
                    'lastname'      => $lastname,
                    'suffix'        => $suffix,
                    'citizenship'   => $citizenship,
                    'gender'        => $gender,
                    'civil_status'  => $civil_status,
                    'religion'      => $religion,
                    'birthday'      => $birthday,
                    'birthPlace'    => $birthPlace,
                    'contact'       => $contact,
                    'email'         => $email,
                    'employee_id'   => $employee_id
                ]);
            }

            // ✅ Update hr_data
            $stmtHrData = $this->db->prepare("
                UPDATE hr_data 
                SET houseBlock = :houseBlock,
                    street = :street,
                    subdivision = :subdivision,
                    barangay = :barangay,
                    city_muntinlupa = :city_muntinlupa,
                    province = :province,
                    zip_code = :zip_code
                WHERE employee_id = :employee_id
            ");
            $stmtHrData->execute([
                'houseBlock'      => $houseBlock,
                'street'          => $street,
                'subdivision'     => $subdivision,
                'barangay'        => $barangay,
                'city_muntinlupa' => $city_muntinlupa,
                'province'        => $province,
                'zip_code'        => $zip_code,
                'employee_id'     => $employee_id
            ]);

            // ✅ Record activity
            $activityMsg = 'Updated personal information';
            if ($profile_picture) {
                $activityMsg .= ' and profile picture';
            }
            
            $stmtActivity = $this->db->prepare("
                INSERT INTO activities (employee_id, activity_type)
                VALUES (:employee_id, :activity_type)
            ");
            $stmtActivity->execute([
                'employee_id' => $employee_id,
                'activity_type' => $activityMsg
            ]);

            return json_encode([
                'status' => 1,
                'message' => 'Profile updated successfully!' . ($profile_picture ? ' Profile picture uploaded.' : ''),
                'profile_picture' => $profile_picture
            ]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred while updating. Please try again later.'
            ]);
        }
    }
    function family_update_employee() {
        try {
            // Ensure required data
            $employee_id = $_POST['employee_id'] ?? null;
            if (!$employee_id) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Employee ID is missing.'
                ]);
            }

            // Map of relationships with their correct prefixes
            $relationships = [
                'Father' => 'father_',
                'Mother' => 'mother_', 
                'Guardian' => 'guardian_',
                'Spouse' => 'spouse_'
            ];

            // Loop through each relationship and update
            foreach ($relationships as $relation => $prefix) {
                // Build field names dynamically using the correct prefix
                $firstname   = $_POST[$prefix . 'firstname'] ?? null;
                $middlename  = $_POST[$prefix . 'middlename'] ?? null;
                $lastname    = $_POST[$prefix . 'lastname'] ?? null;
                $occupation  = $_POST[$prefix . 'occupation'] ?? null;
                $contact     = $_POST[$prefix . 'contact'] ?? null;
                $house_block = $_POST[$prefix . 'house_block'] ?? null;
                $street      = $_POST[$prefix . 'street'] ?? null;
                $subdivision = $_POST[$prefix . 'subdivision'] ?? null;
                $barangay    = $_POST[$prefix . 'barangay'] ?? null;
                $city        = $_POST[$prefix . 'city'] ?? null;
                $province    = $_POST[$prefix . 'province'] ?? null;
                $zip_code    = $_POST[$prefix . 'zip_code'] ?? null;

                // Debug: Check what values we're getting
                error_log("Processing $relation: $firstname, $lastname");

                // Skip if all fields are empty
                if (!$firstname && !$lastname && !$occupation && !$contact) {
                    error_log("Skipping $relation - all fields empty");
                    continue;
                }

                // Check if record exists
                $check = $this->db->prepare("SELECT Family_data_id FROM Family_data WHERE employee_id = :employee_id AND Relationship = :relationship");
                $check->execute([':employee_id' => $employee_id, ':relationship' => $relation]);
                $exists = $check->rowCount() > 0;

                if ($exists) {
                    // Update existing record
                    $stmt = $this->db->prepare("
                        UPDATE Family_data SET
                            firstname = :firstname,
                            middlename = :middlename,
                            lastname = :lastname,
                            occupation = :occupation,
                            contact = :contact,
                            house_block = :house_block,
                            street = :street,
                            subdivision = :subdivision,
                            barangay = :barangay,
                            city = :city,
                            province = :province,
                            zip_code = :zip_code
                        WHERE employee_id = :employee_id AND Relationship = :relationship
                    ");
                    error_log("Updating existing $relation record");
                } else {
                    // Insert new if missing
                    $stmt = $this->db->prepare("
                        INSERT INTO Family_data (
                            employee_id, Relationship, firstname, middlename, lastname, occupation, contact,
                            house_block, street, subdivision, barangay, city, province, zip_code
                        ) VALUES (
                            :employee_id, :relationship, :firstname, :middlename, :lastname, :occupation, :contact,
                            :house_block, :street, :subdivision, :barangay, :city, :province, :zip_code
                        )
                    ");
                    error_log("Inserting new $relation record");
                }

                // Bind and execute
                $result = $stmt->execute([
                    ':employee_id' => $employee_id,
                    ':relationship' => $relation,
                    ':firstname' => $firstname,
                    ':middlename' => $middlename,
                    ':lastname' => $lastname,
                    ':occupation' => $occupation,
                    ':contact' => $contact,
                    ':house_block' => $house_block,
                    ':street' => $street,
                    ':subdivision' => $subdivision,
                    ':barangay' => $barangay,
                    ':city' => $city,
                    ':province' => $province,
                    ':zip_code' => $zip_code
                ]);

                if (!$result) {
                    error_log("Failed to save $relation data");
                } else {
                    error_log("Successfully saved $relation data");
                }
            }

            return json_encode([
                'status' => 1,
                'message' => 'Family information updated successfully.'
            ]);

        } catch (PDOException $e) {
            error_log("Family Update Error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }
    function educational_update_employee() {
        try {
            // Ensure required data
            $employee_id = $_POST['employee_id'] ?? null;
            if (!$employee_id) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Employee ID is missing.'
                ]);
            }

            // Map of education levels
            $education_levels = [
                'Elementary' => [
                    'school_name' => $_POST['elementary_school_name'] ?? '',
                    'year_started' => $_POST['elementary_year_started'] ?? '',
                    'year_ended' => $_POST['elementary_year_ended'] ?? '',
                    'course_strand' => '', // Elementary doesn't have course/strand
                    'honors' => $_POST['elementary_honors'] ?? ''
                ],
                'High_school' => [
                    'school_name' => $_POST['high_school_school_name'] ?? '',
                    'year_started' => $_POST['high_school_year_started'] ?? '',
                    'year_ended' => $_POST['high_school_year_ended'] ?? '',
                    'course_strand' => '', // High school doesn't have course/strand
                    'honors' => $_POST['high_school_honors'] ?? ''
                ],
                'Senior_high' => [
                    'school_name' => $_POST['senior_high_school_name'] ?? '',
                    'year_started' => $_POST['senior_high_year_started'] ?? '',
                    'year_ended' => $_POST['senior_high_year_ended'] ?? '',
                    'course_strand' => $_POST['senior_high_course_strand'] ?? '',
                    'honors' => $_POST['senior_high_honors'] ?? ''
                ],
                'College' => [
                    'school_name' => $_POST['college_school_name'] ?? '',
                    'year_started' => $_POST['college_year_started'] ?? '',
                    'year_ended' => $_POST['college_year_ended'] ?? '',
                    'course_strand' => $_POST['college_course_strand'] ?? '',
                    'honors' => $_POST['college_honors'] ?? ''
                ],
                'Graduate' => [
                    'school_name' => $_POST['graduate_school_name'] ?? '',
                    'year_started' => $_POST['graduate_year_started'] ?? '',
                    'year_ended' => $_POST['graduate_year_ended'] ?? '',
                    'course_strand' => $_POST['graduate_course_strand'] ?? '',
                    'honors' => $_POST['graduate_honors'] ?? ''
                ]
            ];

            // Loop through each education level and update
            foreach ($education_levels as $level => $data) {
                // Skip if all fields are empty
                if (empty($data['school_name']) && empty($data['year_started']) && 
                    empty($data['year_ended']) && empty($data['course_strand']) && 
                    empty($data['honors'])) {
                    continue;
                }

                // Check if record exists
                $check = $this->db->prepare("SELECT educational_data_id FROM educational_data WHERE employee_id = :employee_id AND education_level = :education_level");
                $check->execute([':employee_id' => $employee_id, ':education_level' => $level]);

                if ($check->rowCount() > 0) {
                    // Update existing record
                    $stmt = $this->db->prepare("
                        UPDATE educational_data SET
                            school_name = :school_name,
                            year_started = :year_started,
                            year_ended = :year_ended,
                            course_strand = :course_strand,
                            honors = :honors
                        WHERE employee_id = :employee_id AND education_level = :education_level
                    ");
                } else {
                    // Insert new if missing
                    $stmt = $this->db->prepare("
                        INSERT INTO educational_data (
                            employee_id, education_level, school_name, year_started, 
                            year_ended, course_strand, honors
                        ) VALUES (
                            :employee_id, :education_level, :school_name, :year_started,
                            :year_ended, :course_strand, :honors
                        )
                    ");
                }

                // Bind and execute
                $stmt->execute([
                    ':employee_id' => $employee_id,
                    ':education_level' => $level,
                    ':school_name' => $data['school_name'],
                    ':year_started' => $data['year_started'],
                    ':year_ended' => $data['year_ended'],
                    ':course_strand' => $data['course_strand'],
                    ':honors' => $data['honors']
                ]);
            }
            
            $stmtActivity = $this->db->prepare("INSERT INTO activities (employee_id, activity_type) VALUES ('$employee_id', 'Updated education informations')");
            $stmtActivity->execute();

            return json_encode([
                'status' => 1,
                'message' => 'Educational information updated successfully.'
            ]);

        } catch (PDOException $e) {
            error_log("Educational Update Error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

// SCHEDULE TEMPLATE ====================================================================
    function schedule_template_form(){
        try {
            $scheduleName = $_POST["scheduleName"];
            $schedule_from = $_POST["schedule_from"];
            $schedule_to = $_POST["schedule_to"];
            $shift = $_POST["shift"];
            $day = $_POST["day"];
            $department = $_POST["department"];

            $stmt = $this->db->prepare("INSERT INTO sched_template 
                (scheduleName, schedule_from, schedule_to, shift, day, department) VALUES
                (:scheduleName, :schedule_from, :schedule_to, :shift, :day, :department)");
            $stmt->execute([
                'scheduleName' => $scheduleName,
                'schedule_from' => $schedule_from,
                'schedule_to' => $schedule_to,
                'shift' => $shift,
                'day' => $day,
                'department' => $department
            ]);
            return json_encode([
                'status' => 1,
                'message' => 'Schedule template created successfully!'
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }
    function delete_template_form(){
        try {
            $TemplateId = $_POST["TemplateId"];

            $stmt = $this->db->prepare("DELETE FROM sched_template WHERE template_id = :template_id");
            $stmt->execute([
                'template_id' => $TemplateId
            ]);
            return json_encode([
                'status' => 1,
                'message' => 'Schedule delete successfully'
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }
    function fetch_template(){
        try {
            $template_id = $_POST["template_id"];
            $stmt = $this->db->prepare("SELECT * FROM sched_template WHERE template_id = :template_id");
            $stmt->execute([
                'template_id' => $template_id
            ]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return json_encode($data);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }
    function update_template(){
        try {
            $template_id = $_POST["template_id"];
            $scheduleName = $_POST["scheduleName"];
            $schedule_from = $_POST["schedule_from"];
            $schedule_to = $_POST["schedule_to"];
            $shift = $_POST["shift"];
            $day = $_POST["day"];
            $department = $_POST["department"];

            $stmt = $this->db->prepare("UPDATE sched_template SET 
            scheduleName= :scheduleName, schedule_from = :schedule_from,
            schedule_to = :schedule_to, shift = :shift, day = :day, department = :department 
            WHERE template_id = :template_id");

             $stmt->execute([
                'template_id' => $template_id,
                'scheduleName' => $scheduleName,
                'schedule_from' => $schedule_from,
                'schedule_to' => $schedule_to,
                'shift' => $shift,
                'day' => $day,
                'department' => $department
            ]);
            return json_encode([
                'status' => 1,
                'message' => 'Schedule template updated successfully!'
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }

// CAREER PATHS =========================================================================
    function fetch_careerPaths_data(){
        try {
            $sql = "SELECT 
                    ed.employee_id, 
                    ed.firstname, 
                    ed.middlename, 
                    ed.lastname, 
                    ed.suffix,
                    d.Department_name as department,
                    hd.employeeID,
                    jt.jobTitle,
                    hd.salary
                FROM employee_data ed
                INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
                LEFT JOIN departments d ON hd.Department_id = d.Department_id
                LEFT JOIN jobTitles jt ON hd.jobtitle_id = jt.jobTitles_id
                WHERE ed.status = 'Active' AND ed.user_role = 'EMPLOYEE' OR ed.user_role = 'HRSM'
                ORDER BY ed.lastname, ed.firstname";

            $stmt = $this->db->prepare($sql);

            if (!$stmt->execute()) {
                throw new Exception("Failed to execute query");
            }

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode([
                'status' => 1,
                'message' => 'Career paths data fetched successfully',
                'data' => $result ?: []
            ]);
            
        } catch (Exception $e) {
            error_log("Error in fetch_careerPaths_data: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => []
            ]);
            
        }
    }
    function get_all_career_paths() {
        try {
            $sql = "SELECT 
                        jh.job_historyID,
                        e.employee_id,
                        e.firstname,
                        e.lastname,
                        d.Department_name AS department,
                        jt.jobTitle,
                        jt.salary,
                        jt.jobTitles_id,
                        jh.job_from,
                        jh.job_to,
                        jh.job_status,
                        jh.addAt
                    FROM job_history jh
                    JOIN employee_data e ON jh.employee_id = e.employee_id
                    LEFT JOIN departments d ON jh.department_id = d.Department_id
                    LEFT JOIN JobTitles jt ON jh.jobTitle_id = jt.jobTitles_id
                    ORDER BY jh.addAt ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode([
                'status' => 'success',
                'message' => 'All career paths retrieved successfully',
                'careerPaths' => $result ?: []
            ]);
            
        } catch (Exception $e) {
            error_log("Career paths retrieval error: " . $e->getMessage());
            return json_encode([
                'status' => 'error',
                'message' => 'Career paths retrieval failed: ' . $e->getMessage(),
                'careerPaths' => []
            ]);
            
        }
    }
    function get_career_path_details($id){
        try {
            header('Content-Type: application/json');

            $sql = "SELECT cp.employee_id, e.employeeID, j.jobTitle, j.salary, j.jobTitles_id
                    FROM CareerPaths cp
                    JOIN Employees e ON cp.employee_id = e.employee_id
                    JOIN JobTitles j ON cp.jobTitle_id = j.jobTitles_id
                    WHERE cp.employee_id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                throw new Exception("Failed to execute career path details query");
            }

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                throw new Exception("Career path not found");
            }

            return json_encode([
                'status' => 'success',
                'message' => 'Career path details retrieved',
                'careerPath' => $result
            ]);
            
        } catch (Exception $e) {
            error_log("Career path details error: " . $e->getMessage());
            header('Content-Type: application/json');
            return json_encode([
                'status' => 'error',
                'message' => 'Failed to get career path: ' . $e->getMessage(),
                'careerPath' => null
            ]);
            
        }
    }
    function fetch_careerPath_data($employeeId = null){
        try {
            // Start output buffering
            ob_start();

            // Validate employee ID
            if (!$employeeId || !is_numeric($employeeId)) {
                throw new Exception("Invalid employee ID provided");
            }

            // Convert to integer for safety
            $employeeId = (int)$employeeId;

            // 1. Get employee basic info with better error handling
            $employeeSql = "SELECT 
                    ed.employee_id,
                    ed.firstname,
                    ed.middlename,
                    ed.lastname,
                    ed.suffix,
                    ed.status,
                    hd.employeeID,
                    d.Department_name as department,
                    jt.jobTitle,
                    jt.jobTitles_id,
                    hd.jobtitle_id,
                    hd.salary as current_salary
                FROM employee_data ed
                INNER JOIN hr_data hd ON ed.employee_id = hd.employee_id
                LEFT JOIN departments d ON hd.Department_id = d.Department_id
                LEFT JOIN jobTitles jt ON hd.jobtitle_id = jt.jobTitles_id
                WHERE ed.employee_id = :employee_id";

            $employeeStmt = $this->db->prepare($employeeSql);
            $employeeStmt->bindParam(':employee_id', $employeeId, PDO::PARAM_INT);

            if (!$employeeStmt->execute()) {
                $errorInfo = $employeeStmt->errorInfo();
                throw new Exception("Database error: " . $errorInfo[2]);
            }

            $employeeData = $employeeStmt->fetch(PDO::FETCH_ASSOC);

            if (!$employeeData) {
                throw new Exception("Employee with ID {$employeeId} not found in database");
            }

            // Check if employee is active
            if ($employeeData['status'] !== 'Active') {
                throw new Exception("Employee account is not active. Current status: " . $employeeData['status']);
            }

            // 2. Get career history - Check if job_history table exists first
            $historyData = [];

            // Check if job_history table exists
            $tableCheck = $this->db->prepare("SHOW TABLES LIKE 'job_history'");
            $tableCheck->execute();

            if ($tableCheck->rowCount() > 0) {
                // Table exists, fetch history with job title names instead of IDs
                $historySql = "SELECT 
                        jh.job_historyID,
                        jh.employee_id,
                        jh.job_from,
                        jh.job_to,
                        jh.job_status,
                        jh.current_salary,
                        jh.new_salary,
                        DATE_FORMAT(jh.addAt, '%Y-%m-%d') as change_date,
                        -- Get job title names for job_from and job_to
                        jt_from.jobTitle as job_from_title,
                        jt_to.jobTitle as job_to_title
                    FROM job_history jh
                    -- Join to get job title name for job_from
                    LEFT JOIN jobTitles jt_from ON jh.job_from = jt_from.jobTitles_id
                    -- Join to get job title name for job_to  
                    LEFT JOIN jobTitles jt_to ON jh.job_to = jt_to.jobTitles_id
                    WHERE jh.employee_id = :employee_id
                    ORDER BY jh.addAt DESC";

                $historyStmt = $this->db->prepare($historySql);
                $historyStmt->bindParam(':employee_id', $employeeId, PDO::PARAM_INT);

                if (!$historyStmt->execute()) {
                    $errorInfo = $historyStmt->errorInfo();
                    throw new Exception("Failed to fetch job history: " . $errorInfo[2]);
                }

                $rawHistoryData = $historyStmt->fetchAll(PDO::FETCH_ASSOC);

                // Process the history data to use job title names
                foreach ($rawHistoryData as $history) {
                    $historyData[] = [
                        'job_from' => $history['job_from_title'] ?? $history['job_from'],
                        'job_to' => $history['job_to_title'] ?? $history['job_to'],
                        'job_status' => $history['job_status'],
                        'current_salary' => $history['current_salary'],
                        'new_salary' => $history['new_salary'],
                        'change_date' => $history['change_date']
                    ];
                }
            }

            // If no history found, create a basic history from current position
            if (empty($historyData)) {
                $historyData = [
                    [
                        'job_from' => 'Initial Position',
                        'job_to' => $employeeData['jobTitle'] ?? 'Current Position',
                        'job_status' => 'Current',
                        'current_salary' => $employeeData['current_salary'] ?? 0,
                        'new_salary' => $employeeData['current_salary'] ?? 0,
                        'change_date' => date('Y-m-d')
                    ]
                ];
            }

            ob_end_clean();

            return json_encode([
                'status' => 1,
                'message' => 'Success',
                'data' => [
                    'employee' => $employeeData,
                    'history' => $historyData
                ]
            ]);
        } catch (Exception $e) {
            if (ob_get_length()) ob_end_clean();
            error_log("Career Path Error for employee ID {$employeeId}: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

// LEAVES ====================================================================================
    function leave_form(){
        $employee_id = htmlspecialchars($_POST["employee_id"]);
        $leaveStatus = htmlspecialchars($_POST["leaveStatus"]);
        $leaveType = htmlspecialchars($_POST["leaveType"]); 
        $Others = htmlspecialchars($_POST["Others"] ?? '');
        $leaveDate = htmlspecialchars($_POST["leaveDate"]);
        $Purpose = htmlspecialchars($_POST["Purpose"]);
        $InclusiveFrom = htmlspecialchars($_POST["InclusiveFrom"]);
        $InclusiveTo = htmlspecialchars($_POST["InclusiveTo"]);
        $numberOfDays = floatval($_POST["numberOfDays"]);
        $contact = htmlspecialchars($_POST["contact"]);
        $sectionHead = htmlspecialchars($_POST["sectionHead"]);
        $departmentHead = htmlspecialchars($_POST["departmentHead"]);

        if($leaveType == 'Vacation Leave'){
                $leaveType = 'Vacation_leave';
            }else if($leaveType == 'Sick Leave'){
                $leaveType = 'Sick_leave';
            }else if($leaveType == 'Special Leave'){
                $leaveType = 'Special_leave';
            }else{
                $Others = $leaveType;
                $leaveType = 'Others';
            }

        try {

            // Valid leave types based on your TABLE DESIGN
            $validLeaveTypes = [
                "Vacation_leave" => "VacationBalance",
                "Sick_leave"     => "SickBalance",
                "Special_leave"  => "SpecialBalance",
                "Others"         => "OthersBalance"
            ];

            // Validate leave type
            if (!array_key_exists($leaveType, $validLeaveTypes)) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Invalid leave type!'
                ]);
            }

            // Map the type to DB column
            $balanceColumn = $validLeaveTypes[$leaveType];

            // Fetch leave balance safely
            $stmt = $this->db->prepare("
                SELECT $balanceColumn AS credits 
                FROM leaveCounts 
                WHERE employee_id = :employee_id
            ");
            $stmt->execute(['employee_id' => $employee_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $currentCredits = floatval($row["credits"] ?? 0);

            // Validate available credits
            if ($currentCredits < $numberOfDays) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Not enough leave credits, credits left: ' . $currentCredits
                ]);
            }

            // Insert into leaveReq table
            $stmt = $this->db->prepare("
                INSERT INTO leaveReq 
                (employee_id, leaveStatus, leaveType, Others, leaveDate, Purpose, InclusiveFrom, InclusiveTo, numberOfDays, contact, sectionHead, departmentHead)
                VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $employee_id, 
                $leaveStatus, 
                $leaveType,
                $Others,
                $leaveDate,
                $Purpose,
                $InclusiveFrom,
                $InclusiveTo,
                $numberOfDays,
                $contact,
                $sectionHead,
                $departmentHead
            ]);

            // Activity log
            $activity_type = "Requested a " . str_replace("_", " ", strtolower($leaveType));

            $stmtActivity = $this->db->prepare("
                INSERT INTO activities (employee_id, activity_type) 
                VALUES (?, ?)
            ");
            $stmtActivity->execute([$employee_id, ucfirst($activity_type)]);

            $stmtNotify = $this->db->prepare("INSERT INTO notifications (type, status) VALUES ('HR', 'Active')");
            $stmtNotify->execute();

            // SUCCESS RESPONSE
            return json_encode([
                'status' => 1,
                'message' => 'Leave request submitted successfully!'
            ]);

        } catch (PDOException $e) {

            error_log("Database error: " . $e->getMessage());

            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }
    function leave_update(){
        try {
            $employee_id = htmlSpecialChars($_POST["employee_id"]);
            $VacationBalance = htmlSpecialChars($_POST["VacationBalance"]);
            $SickBalance = htmlSpecialChars($_POST["SickBalance"]);
            $SpecialBalance = htmlSpecialChars($_POST["SpecialBalance"]);
            $OthersBalance = htmlSpecialChars($_POST["OthersBalance"]);

            $stmtLeaveCounts = $this->db->prepare("UPDATE leaveCounts SET VacationBalance = :VacationBalance, 
            SickBalance = :SickBalance, SpecialBalance = :SpecialBalance, OthersBalance = :OthersBalance WHERE employee_id = :employee_id");
            $stmtLeaveCounts->execute([
                'VacationBalance' => $VacationBalance,
                'SickBalance' => $SickBalance,
                'SpecialBalance' => $SpecialBalance,
                'OthersBalance' => $OthersBalance,
                'employee_id' => $employee_id
            ]);
            return json_encode([
                'status' => 1,
                'message' => 'Profile updated successfully!'
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }
    function approve_leave_request(){
        try {
            $leave_id = $_POST['leave_id'] ?? null;

            if (!$leave_id) {
                throw new Exception("Leave ID is required");
            }

            $sql = "UPDATE leaveReq SET leaveStatus = 'Approved' WHERE leave_id = ?";
            $stmt = $this->db->prepare($sql);

            if (!$stmt->execute([$leave_id])) {
                throw new Exception("Failed to approve leave request");
            }

            return json_encode([
                'status' => 1,
                'message' => 'Leave request approved successfully'
            ]);
            
        } catch (Exception $e) {
            error_log("Error in approve_leave_request: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ]);
            
        }
    }
    function leaveProcess_form(){
        try {
            $leave_id = $_POST["leave_id"] ?? '';
            $employee_id = $_POST["employee_id"] ?? '';
            $leaveType = $_POST["leaveType"] ?? '';
            $leaveStatus = $_POST["leaveStatus"] ?? '';
            $disapprovalDetails = $_POST["disapprovalDetails"] ?? '';

            // Get balance data
            $vacationBalanceToDate = $_POST["vacationBalanceToDate"] ?? 0;
            $sickBalanceToDate = $_POST["sickBalanceToDate"] ?? 0;
            $specialBalanceToDate = $_POST["specialBalanceToDate"] ?? 0;

            if($leaveStatus === 'Recommended'){
                // Update leave request status
                $stmt = $this->db->prepare("UPDATE leaveReq SET leaveStatus = '$leaveStatus' WHERE leave_id = ?");
                $stmt->execute([$leave_id]);

                // Get leave type specific data
                $baseType = strtolower(explode('_', $leaveType)[0]);
                $balance = $_POST[$baseType."Balance"] ?? 0;
                $earned = $_POST[$baseType."Earned"] ?? 0;
                $credits = $_POST[$baseType."Credits"] ?? 0;
                $lessLeave = $_POST[$baseType."LessLeave"] ?? 0;
                
                // Determine which balance to use
                switch($baseType) {
                    case 'vacation':
                        $balanceToDate = $vacationBalanceToDate;
                        break;
                    case 'sick':
                        $balanceToDate = $sickBalanceToDate;
                        break;
                    case 'special':
                        $balanceToDate = $specialBalanceToDate;
                        break;
                    default:
                        $balanceToDate = 0;
                }

                // Insert leave details
                $stmt = $this->db->prepare("INSERT INTO leave_details 
                    (leave_id, balance, earned, credits, lessLeave, balanceToDate, approved_at) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$leave_id, $balance, $earned, $credits, $lessLeave, $balanceToDate]);

                $stmtNotify = $this->db->prepare("INSERT INTO notifications (type, status) VALUES ('ADMIN', 'Active')");
                $stmtNotify->execute();

                return json_encode(['status'=>1,'message'=>'Leave Recommended Successfully!']);

            } else if($leaveStatus === 'Disapproved'){
                $stmt = $this->db->prepare("UPDATE leaveReq SET leaveStatus = '$leaveStatus' WHERE leave_id = ?");
                $stmt->execute([$leave_id]);
                
                $stmtLeave_details = $this->db->prepare("INSERT INTO leave_details (leave_id, disapprovalDetails, disapproved_at)
                VALUES ('$leave_id', '$disapprovalDetails', NOW())");
                $stmtLeave_details->execute();
                return json_encode(['status'=>1,'message'=>'Leave Disapproved Successfully!']);
            }else if($leaveStatus === 'Approved'){
                $stmt = $this->db->prepare("UPDATE leaveReq SET leaveStatus = ? WHERE leave_id = ?");
                $stmt->execute([$leaveStatus, $leave_id]);

                $baseType = strtolower(explode('_', $leaveType)[0]);
                $balance = $_POST[$baseType."Balance"] ?? 0;
                $earned = $_POST[$baseType."Earned"] ?? 0;
                $credits = $_POST[$baseType."Credits"] ?? 0;
                $lessLeave = $_POST[$baseType."LessLeave"] ?? 0;
                
                // Determine which balance to use
                switch($baseType) {
                    case 'vacation':
                        $balanceToDate = $vacationBalanceToDate;
                        break;
                    case 'sick':
                        $balanceToDate = $sickBalanceToDate;
                        break;
                    case 'special':
                        $balanceToDate = $specialBalanceToDate;
                        break;
                    default:
                        $balanceToDate = 0;
                }
                
                $stmtLeave_details = $this->db->prepare("UPDATE leave_details SET disapprovalDetails = :disapprovalDetails, disapproved_at = NOW()
                    WHERE leave_id = :leave_id");
                $stmtLeave_details->execute([
                    'leave_id' => $leave_id,
                    'disapprovalDetails' => $disapprovalDetails
                ]);

                // Update leave counts
                $stmt = $this->db->prepare("UPDATE leaveCounts SET 
                    VacationBalance = ?, SickBalance = ?, SpecialBalance = ? 
                    WHERE employee_id = ?");
                $stmt->execute([$vacationBalanceToDate, $sickBalanceToDate, $specialBalanceToDate, $employee_id]);

                return json_encode(['status'=>1,'message'=>'Leave Approved Successfully!']);
            }

            return json_encode(['status'=>0,'message'=>'Please select approval status']);

        } catch(PDOException $e){
            error_log("Leave Process Error: ".$e->getMessage());
            return json_encode(['status'=>0,'message'=>'An error occurred: '.$e->getMessage()]);
        }
    }
    function cancel_leave_form(){
        try {
            $employee_id = $_POST["employee_id"] ?? null;
            $leave_id = $_POST["leave_id"] ?? null;

            if($leave_id == null || $employee_id == null){
                return json_encode([
                    'status' => 0,
                    'message' => 'No leave ID or No employee ID!'
                ]);
            }

            $stmt = $this->db->prepare("DELETE FROM leaveReq WHERE leave_id = :leave_id");
            $stmt->execute([
                'leave_id' => $leave_id
            ]);

            // Activity log
            // $activity_type = "Cancelled a leave:  " . str_replace("_", " ", strtolower($leaveType));

            // $stmtActivity = $this->db->prepare("
            //     INSERT INTO activities (employee_id, activity_type) 
            //     VALUES (?, ?)
            // ");
            // $stmtActivity->execute([$employee_id, ucfirst($activity_type)]);

            // SUCCESS RESPONSE
            return json_encode([
                'status' => 1,
                'message' => 'Leave Cencelled successfully!'
            ]);

        } catch (PDOException $e) {

            error_log("Database error: " . $e->getMessage());

            return json_encode([
                'status' => 0,
                'message' => 'An error occurred. Please try again later.'
            ]);
        }
    }
    function leave_types_form(){
        try {
            $leave_type = $_POST["leave_type"];
            $leave_description = $_POST["leave_description"];

            $stmt = $this->db->prepare("INSERT INTO leaves (leave_type, leave_description) VALUES
                (:leave_type, :leave_description)");
            $stmt->execute([
                'leave_type' => $leave_type,
                'leave_description' => $leave_description
            ]);

            return json_encode([
                'status' => 1,
                'message' => 'Leave Type added successfully!'
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }
    function delete_leave_type_form(){
        try {
            $leaves_id = $_POST["leaves_id"];

            $stmt = $this->db->prepare("DELETE FROM leaves WHERE leaves_id = :leaves_id");
            $stmt->execute([
                'leaves_id' => $leaves_id
            ]);

            return json_encode([
                'status' => 1,
                'message' => 'Leave Type deleted successfully!'
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }
    function edit_leave_type(){
        try{
            $leaves_id = $_POST["leaves_id"];
            $leave_type = $_POST["leave_type"];
            $leave_description = $_POST["leave_description"];

            $stmt = $this->db->prepare("UPDATE leaves SET leave_type = :leave_type,
                leave_description = :leave_description WHERE leaves_id = :leaves_id");
            $stmt->execute([
                'leaves_id' => $leaves_id,
                'leave_type' => $leave_type,
                'leave_description' => $leave_description
            ]);

            return json_encode([
                'status' => 1,
                'message' => 'Leave type edited successfully!'
            ]);
        }catch(PDOException $e){
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }
// 201 FILES ===============================================================================
    function file_form() {
        try {
            // Check required fields
            if (!isset($_POST["file_title"], $_POST["employee_id"], $_FILES["201file"])) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Missing required fields.'
                ]);
            }

            $file_title  = htmlspecialchars($_POST["file_title"]);
            $type  = htmlspecialchars($_POST["type"]);
            $employee_id = htmlspecialchars($_POST["employee_id"]);
            $file        = $_FILES["201file"];

            // Validate upload
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return json_encode([
                    'status' => 0,
                    'message' => 'File upload error.'
                ]);
            }

            // Create uploads folder if not exists
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Safe file name
            $fileName = time() . "_" . basename($file["name"]);
            $targetPath = $uploadDir . $fileName;

            // Move uploaded file
            if (!move_uploaded_file($file["tmp_name"], $targetPath)) {
                return json_encode([
                    'status' => 0,
                    'message' => 'Failed to save uploaded file.'
                ]);
            }

            $stmt = $this->db->prepare("
                INSERT INTO files (employee_id, file_title, 201file, type)
                VALUES (:employee_id, :file_title, :file_path, :type)
            ");

            $stmt->execute([
                ':employee_id' => $employee_id,
                ':file_title'  => $file_title,
                ':file_path'   => $fileName,
                ':type'   => $type
            ]);

            return json_encode([
                'status' => 1,
                'message' => 'File uploaded and saved successfully.'
            ]);

        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
    function file_delete_form(){
        try {
            $files_id = $_POST["files_id"];

            $stmt = $this->db->prepare("DELETE FROM files WHERE files_id = :files_id");
            $stmt->execute([
                'files_id' => $files_id
            ]);

            return json_encode([
                'status' => 1,
                'message' => 'File deleted successfully!'
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'message' => 'An error occured: ' . $e->getMessage()
            ]);
        }
    }

// PERSONAL DATA SHEETS =====================================================================
    function pds_update() {
        try {
            $employee_id = $_POST["employee_id"];
            
            // Get pds_id using employee_id (not users_id)
            $stmt = $this->db->prepare("SELECT pds_id FROM personal_data_sheet WHERE employee_id = ?");
            $stmt->execute([$employee_id]);
            $pds_id = $stmt->fetchColumn();

            if (!$pds_id) {
                throw new RuntimeException("No personal_data_sheet found for employee ID: {$employee_id}");
            }

            // Update employee_data (not userInformations)
            $this->db->prepare(
                "UPDATE employee_data SET
                    lastname = :ln,
                    firstname = :fn,
                    middlename = :mn,
                    nickname = :nn,
                    suffix = :sx,
                    citizenship = :ctz,
                    gender = :gen,
                    civil_status = :civ,
                    religion = :rel,
                    age = :age,
                    birthday = :bd,
                    birthPlace = :bp,
                    contact = :cnt,
                    email = :em
                WHERE employee_id = :eid"
            )->execute([
                ':eid' => $employee_id,
                ':ln' => $_POST['lname'] ?? null,
                ':fn' => $_POST['fname'] ?? null,
                ':mn' => $_POST['mname'] ?? null,
                ':nn' => $_POST['nickname'] ?? null,
                ':sx' => $_POST['suffix'] ?? null,
                ':ctz' => $_POST['citizenship'] ?? null,
                ':gen' => $_POST['gender'] ?? null,
                ':civ' => $_POST['civil_status'] ?? null,
                ':rel' => $_POST['religion'] ?? null,
                ':age' => $_POST['age'] ?? null,
                ':bd' => $_POST['birthday'] ?? null,
                ':bp' => $_POST['birthPlace'] ?? null,
                ':cnt' => $_POST['contact'] ?? null,
                ':em' => $_POST['email'] ?? null
            ]);

            // Update government IDs
            $this->db->prepare(
                "UPDATE userGovIDs SET
                    sss_no = ?,
                    tin_no = ?,
                    pagibig_no = ?,
                    philhealth_no = ?
                WHERE pds_id = ?"
            )->execute([
                $_POST['sss_no'] ?? null,
                $_POST['tin_no'] ?? null,
                $_POST['pagibig_no'] ?? null,
                $_POST['philhealth_no'] ?? null,
                $pds_id
            ]);

            // Update spouse information
            $this->db->prepare(
                "UPDATE spouseInfo SET
                    spouse_surname = :sur,
                    spouse_first = :fir,
                    spouse_middle = :mid,
                    spouse_occupation = :occ,
                    spouse_employer = :emp,
                    spouse_business_address = :addr,
                    spouse_tel = :tel
                WHERE pds_id = :pid"
            )->execute([
                ':pid' => $pds_id,
                ':sur' => $_POST['spouse_surname'] ?? null,
                ':fir' => $_POST['spouse_first'] ?? null,
                ':mid' => $_POST['spouse_middle'] ?? null,
                ':occ' => $_POST['spouse_occupation'] ?? null,
                ':emp' => $_POST['spouse_employer'] ?? null,
                ':addr' => $_POST['spouse_business_address'] ?? null,
                ':tel' => $_POST['spouse_tel'] ?? null
            ]);

            // Update parents information - FIXED field names
            $parentStmt = $this->db->prepare(
                "UPDATE parents SET
                    surname = :sur,
                    first_name = :fir,
                    middle_name = :mid,
                    occupation = :occ,
                    address = :addr
                WHERE pds_id = :pid AND relation = :rel"
            );
            
            // Update father
            $parentStmt->execute([
                ':pid' => $pds_id,
                ':rel' => 'Father',
                ':sur' => $_POST['father_surname'] ?? null,
                ':fir' => $_POST['father_first_name'] ?? null,
                ':mid' => $_POST['father_middle_name'] ?? null,
                ':occ' => $_POST['father_occupation'] ?? null,
                ':addr' => $_POST['father_address'] ?? null
            ]);
            
            // Update mother
            $parentStmt->execute([
                ':pid' => $pds_id,
                ':rel' => 'Mother',
                ':sur' => $_POST['mother_surname'] ?? null,
                ':fir' => $_POST['mother_first_name'] ?? null,
                ':mid' => $_POST['mother_middle_name'] ?? null,
                ':occ' => $_POST['mother_occupation'] ?? null,
                ':addr' => $_POST['mother_address'] ?? null
            ]);

            // Update children information - FIXED field names
            $childUpd = $this->db->prepare("UPDATE children SET full_name = ?, dob = ? WHERE id = ? AND pds_id = ?");
            $childIns = $this->db->prepare("INSERT INTO children (pds_id, full_name, dob) VALUES (?, ?, ?)");

            for ($i = 1; $i <= 7; $i++) {
                $cid = intval($_POST["child_id_$i"] ?? 0);
                $name = trim($_POST["child_full_name_$i"] ?? ''); // Fixed field name
                $dob = $_POST["child_dob_$i"] ?? null;

                if ($cid > 0) {
                    $childUpd->execute([$name !== '' ? $name : null, $dob, $cid, $pds_id]);
                } elseif ($name !== '') {
                    $childIns->execute([$pds_id, $name, $dob]);
                }
            }

            // Update siblings information - FIXED field names
            $sibUpd = $this->db->prepare("
                UPDATE siblings SET
                    full_name = ?, age = ?, occupation = ?, address = ?
                WHERE id = ? AND pds_id = ?
            ");
            $sibIns = $this->db->prepare("
                INSERT INTO siblings (pds_id, full_name, age, occupation, address, birth_order)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            for ($i = 1; $i <= 8; $i++) {
                $sid = intval($_POST["sibling_id_$i"] ?? 0);
                $name = trim($_POST["sibling_full_name_$i"] ?? ''); // Fixed field name
                $age = $_POST["sibling_age_$i"] ?? null; // Fixed field name
                $occ = $_POST["sibling_occupation_$i"] ?? null; // Fixed field name
                $addr = $_POST["sibling_address_$i"] ?? null; // Fixed field name

                if ($sid > 0) {
                    $sibUpd->execute([$name !== '' ? $name : null, $age, $occ, $addr, $sid, $pds_id]);
                } elseif ($name !== '') {
                    $sibIns->execute([$pds_id, $name, $age, $occ, $addr, $i]);
                }
            }

            // Update education information - FIXED field names
            $updEdu = $this->db->prepare("
                UPDATE educationInfo
                SET school_name = :school,
                    degree_course = :course,
                    school_address = :addr,
                    year_grad = :yr
                WHERE id = :id AND pds_id = :pds
            ");
            $insEdu = $this->db->prepare("
                INSERT INTO educationInfo (pds_id, level, school_name, degree_course, school_address, year_grad)
                VALUES (:pds, :lvl, :school, :course, :addr, :yr)
            ");

            $levels = [
                'elem' => 'Elementary',
                'sec' => 'Secondary',
                'voc' => 'Vocational',
                'college' => 'College',
                'grad' => 'Graduate',
            ];

            foreach ($levels as $prefix => $level) {
                $id = intval($_POST["edu_{$prefix}_id"] ?? 0);
                $school = trim($_POST["{$prefix}_school_name"] ?? ''); // Fixed field name
                $course = trim($_POST["{$prefix}_degree_course"] ?? ''); // Fixed field name
                $addr = trim($_POST["{$prefix}_school_address"] ?? ''); // Fixed field name
                $yr = trim($_POST["{$prefix}_year_grad"] ?? ''); // Fixed field name

                if ($id === 0 && $school === '' && $course === '' && $addr === '' && $yr === '') {
                    continue;
                }

                if ($id > 0) {
                    $updEdu->execute([
                        ':school' => $school,
                        ':course' => $course,
                        ':addr' => $addr,
                        ':yr' => $yr !== '' ? $yr : null,
                        ':id' => $id,
                        ':pds' => $pds_id,
                    ]);
                } else {
                    $insEdu->execute([
                        ':pds' => $pds_id,
                        ':lvl' => $level,
                        ':school' => $school,
                        ':course' => $course,
                        ':addr' => $addr,
                        ':yr' => $yr !== '' ? $yr : null,
                    ]);
                }
            }

            // Update work experience - FIXED field names
            $insWork = $this->db->prepare("
                INSERT INTO workExperience (pds_id, date_from, date_to, position_title, department, monthly_salary)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $updWork = $this->db->prepare("
                UPDATE workExperience
                SET date_from = ?,
                    date_to = ?,
                    position_title = ?,
                    department = ?,
                    monthly_salary = ?
                WHERE id = ? AND pds_id = ?
            ");

            for ($i = 1; $i <= 5; $i++) {
                $id = (int) ($_POST["exp_{$i}_id"] ?? 0);
                $from = $_POST["exp_{$i}_date_from"] ?? ''; // Fixed field name
                $to = $_POST["exp_{$i}_date_to"] ?? ''; // Fixed field name
                $title = trim($_POST["exp_{$i}_position_title"] ?? ''); // Fixed field name
                $dept = trim($_POST["exp_{$i}_department"] ?? '');
                $salary = $_POST["exp_{$i}_monthly_salary"] ?? ''; // Fixed field name

                if ($id === 0 && $from === '' && $to === '' && $title === '' && $dept === '' && $salary === '') {
                    continue;
                }

                if ($id > 0) {
                    $updWork->execute([$from, $to, $title, $dept, $salary, $id, $pds_id]);
                } else {
                    $insWork->execute([$pds_id, $from, $to, $title, $dept, $salary]);
                }
            }

            // Update seminars and trainings - FIXED field names
            $insSem = $this->db->prepare("
                INSERT INTO seminarsTrainings (pds_id, inclusive_dates, title, place)
                VALUES (?, ?, ?, ?)
            ");
            $updSem = $this->db->prepare("
                UPDATE seminarsTrainings
                SET inclusive_dates = ?,
                    title = ?,
                    place = ?
                WHERE id = ? AND pds_id = ?
            ");

            for ($i = 1; $i <= 5; $i++) {
                $id = intval($_POST["seminar_{$i}_id"] ?? 0);
                $dates = trim($_POST["seminar_{$i}_inclusive_dates"] ?? ''); // Fixed field name
                $title = trim($_POST["seminar_{$i}_title"] ?? '');
                $place = trim($_POST["seminar_{$i}_place"] ?? '');

                if ($id === 0 && $dates === '' && $title === '' && $place === '') {
                    continue;
                }
                
                if ($id > 0) {
                    $updSem->execute([$dates ?: null, $title ?: null, $place ?: null, $id, $pds_id]);
                } else {
                    $insSem->execute([$pds_id, $dates ?: null, $title, $place ?: null]);
                }
            }

            // Update other information
            $status = $_POST['house_status'] ?? null;
            $type = $_POST['house_type'] ?? null;
            $rent = $_POST['rental_amount'] ?? null;

            $allowedTypes = ['light', 'semi_concrete', 'concrete'];
            if (!in_array($type, $allowedTypes, true)) {
                $type = null;
            }

            $rent = ($rent !== '' && $rent !== null) ? number_format((float) $rent, 2, '.', '') : null;

            $this->db->prepare(
                "UPDATE otherInfo SET
                    special_skills = :skills,
                    house_status = :status,
                    rental_amount = :rent,
                    house_type = :type,
                    household_members = :members,
                    height = :h,
                    weight = :w,
                    blood_type = :b,
                    emergency_contact = :emg,
                    tel_no = :tel
                WHERE pds_id = :pid"
            )->execute([
                ':pid' => $pds_id,
                ':skills' => $_POST['special_skills'] ?? null,
                ':status' => $status,
                ':rent' => $rent,
                ':type' => $type,
                ':members' => $_POST['household_members'] ?? null,
                ':h' => $_POST['height'] ?? null,
                ':w' => $_POST['weight'] ?? null,
                ':b' => $_POST['blood_type'] ?? null,
                ':emg' => $_POST['emergency_contact'] ?? null,
                ':tel' => $_POST['tel_no'] ?? null
            ]);
            
            return json_encode([
                'status' => 1,
                'message' => 'Personal Data Sheet updated successfully.'
            ]);

        } catch (PDOException $e) {
            error_log("PDS Update Error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        } catch (Exception $e) {
            error_log("PDS Update Error: " . $e->getMessage());
            return json_encode([
                'status' => 0,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }
    
}