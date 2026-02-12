<?php
header('Content-Type: application/json');
/* header('x-powered-by : PHP/8.0.30'); */
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : '';

include 'admin_class.php';

$crud = new Action();

// lOGIN ==============================================================
    if ($action === 'login') {

        $login = $crud->login();

        if ($login) {
            echo $login;
        }
    }
/* if ($action === 'login_verification_form') {

	$login = $crud->login_verification_form();

	if ($login) {
		echo $login;
	}
}  */

if ($action === 'logout') {
	$logout = $crud->logout();

	if ($logout) {
		echo $logout;
	}
}

// FORGOT ACCOUNT =======================================================
if ($action === 'changePassword_verification_form') {
	$validation = $crud->changePassword_verification_form();
	if ($validation) {
		echo $validation;
	}
}
if ($action === 'changePassword_form') {
	$validation = $crud->changePassword_form();
	if ($validation) {
		echo $validation;
	}
}
if ($action === 'forget_account_form') {
	$validation = $crud->forget_account_form();
	if ($validation) {
		echo $validation;
	}
}
if ($action === 'password_form') {
	$validation = $crud->password_form();
	if ($validation) {
		echo $validation;
	}
}


// DEPARTMENTS =======================================================================
if ($action === 'department_form') {
    $employees = $crud->department_form();
    if ($employees) {
        echo $employees;
    }
} 
if ($action === 'edit_department') {
    $employees = $crud->edit_department();
    if ($employees) {
        echo $employees;
    }
} 
if ($action === 'department_delete_form') {
    $employees = $crud->department_delete_form();
    if ($employees) {
        echo $employees;
    }
} 

// Unit/Sections =======================================================================
if ($action === 'unitsection_form') {
    $employees = $crud->unitsection_form();
    if ($employees) {
        echo $employees;
    }
} 
if ($action === 'edit_unitsection') {
    $employees = $crud->edit_unitsection();
    if ($employees) {
        echo $employees;
    }
} 
if ($action === 'unitsection_delete_form') {
    $employees = $crud->unitsection_delete_form();
    if ($employees) {
        echo $employees;
    }
} 

// JOB TITLE ==============================================================================
if ($action === 'update_jobInfo') {
    $employees = $crud->update_jobInfo();
    if ($employees) {
        echo $employees;
    }
}
if ($action === 'jobtitle_delete_form') {
    $employees = $crud->jobtitle_delete_form();
    if ($employees) {
        echo $employees;
    }
}  
if ($action === 'jobtitle_form') {
    $employees = $crud->jobtitle_form();
    if ($employees) {
        echo $employees;
    }
} 

// ACCOUNT MANAGEMENT =====================================================================
if ($action === 'validation-form') {
	$validation = $crud->validation_form();
	if ($validation) {
		echo $validation;
	}
}
if ($action === 'register-form') {
    $registration = $crud->registration_form();
    if ($registration) {
        echo $registration;
    }
}
if ($action === 'verification_form') {
    $registration = $crud->verification_form();
    if ($registration) {
        echo $registration;
    }
}
if ($action === 'delete_employee_form') {
    $employees = $crud->delete_employee_form();
    if ($employees) {
        echo $employees;
    }
} 
if ($action === 'approval-form') {
    $employees = $crud->approval_form();
    if ($employees) {
        echo $employees;
    }
} 
if ($action === 'rejection-form') {
    $employees = $crud->rejection_form();
    if ($employees) {
        echo $employees;
    }
} 
if ($action === 'select_status') {
    $result = $crud->select_status();
    echo $result;
}

// PROFILE MANAGEMENT ADMIN =============================================================
if ($action === 'profile_update') {
    $employees = $crud->profile_update();
    if ($employees) {
        echo $employees;
    }
} 
if ($action === 'employment_update') {
    $employees = $crud->employment_update();
    if ($employees) {
        echo $employees;
    }
} 
if ($action === 'family_update') {
    $result = $crud->family_update();
    echo $result;
}
if ($action === 'educational_update') {
    $result = $crud->educational_update();
    echo $result;
}
if ($action === 'admin_profile_update') {
    $result = $crud->admin_profile_update();
    echo $result;
}

// PROFILE MANAGEMENT EMPLOYEES =============================================================
if ($action === 'profile_update_employee') {
    $employees = $crud->profile_update_employee();
    if ($employees) {
        echo $employees;
    }
} 
if ($action === 'family_update_employee') {
    $result = $crud->family_update_employee();
    echo $result;
}
if ($action === 'educational_update_employee') {
    $result = $crud->educational_update_employee();
    echo $result;
}

// SCHEDULE TEMPLATE ====================================================================
if ($action === 'schedule_template_form') {
	$validation = $crud->schedule_template_form();
	if ($validation) {
		echo $validation;
	}
}
if ($action === 'delete_template_form') {
    $result = $crud->delete_template_form();
    echo $result;
}
if ($action === "fetch_template") {
     $result = $crud->fetch_template();
    echo $result;
}
if ($action === "update_template") {
     $result = $crud->update_template();
    echo $result;
}

// CAREER PATHS =========================================================================
if ($action === 'fetch_careerPaths_data') {
    $employees = $crud->fetch_careerPaths_data();
    if ($employees) {
        echo $employees;
    }
} 
if ($action === 'get_all_career_paths') {
    $response = $crud->get_all_career_paths();
    if ($response) {
        echo $response;
    }
}
if ($action === 'get_career_path_details') {
    if (!isset($_GET['id'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Employee ID is required'
        ]);
        exit;
    }
    $id = (int)$_GET['id'];
    $response = $crud->get_career_path_details($id);
    if ($response) {
        echo $response;
    }
}
if ($action === 'fetch_careerPath_data') {
    $employeeIdCareerPath = $_POST['employee_id'] ?? null;
    $employees = $crud->fetch_careerPath_data($employeeIdCareerPath);
    if ($employees) {
        echo $employees;
    }
} 

// LEAVES ====================================================================================
if ($action === 'leave_form') {
    $employees = $crud->leave_form();
    if ($employees) {
        echo $employees;
    }
} 
if ($action === 'leave_update') {
    $registration = $crud->leave_update();
    if ($registration) {
        echo $registration;
    }
}
if ($action === 'approve_leave_request') {
    $result = $crud->approve_leave_request();
    echo $result;
}
if ($action === 'leaveProcess_form') {
    $result = $crud->leaveProcess_form();
    echo $result;
} 
if ($action === 'cancel_leave_form') {
    $result = $crud->cancel_leave_form();
    echo $result;
} 
if ($action === 'leave_types_form') {
    $result = $crud->leave_types_form();
    echo $result;
}
if ($action === 'delete_leave_type_form') {
    $result = $crud->delete_leave_type_form();
    echo $result;
} 
if ($action === 'edit_leave_type') {
    $result = $crud->edit_leave_type();
    echo $result;
} 

// 201 FILES ===============================================================================
if ($action === 'file_form') {
    $result = $crud->file_form();
    echo $result;
}
if ($action === 'file_delete_form') {
    $result = $crud->file_delete_form();
    echo $result;
}

// PERSONAL DATA SHEETS =====================================================================
if ($action === 'pds_update') {
    $result = $crud->pds_update();
    echo $result;
}




?>