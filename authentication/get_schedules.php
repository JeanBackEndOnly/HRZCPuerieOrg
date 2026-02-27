<?php
// get_schedules.php
require_once 'config.php'; 

header('Content-Type: application/json');

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);

$department = isset($input['department']) && $input['department'] !== '' ? $input['department'] : null;
$from_date = $input['from_date'] ?? '';
$to_date = $input['to_date'] ?? '';

// Validate dates
if (!$from_date || !$to_date) {
    echo json_encode(['error' => 'Missing date parameters']);
    exit;
}

try {
    // Build the employee query
    $query = "SELECT DISTINCT 
                u.user_id, 
                u.firstname, 
                u.middlename, 
                u.lastname,
                d.Department_id,
                d.Department_name,
                d.Department_code
              FROM users u
              INNER JOIN employee_data ed ON u.user_id = ed.user_id
              LEFT JOIN departments d ON ed.Department_id = d.Department_id";
    
    $params = [];
    
    if ($department) {
        $query .= " WHERE ed.Department_id = :department";
        $params[':department'] = $department;
    }
    
    $query .= " ORDER BY u.lastname ASC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get schedules for each employee within the date range
    foreach ($employees as &$employee) {
        $schedQuery = "SELECT 
                        es.employee_schedule_id,
                        es.schedule_at,
                        st.template_id,
                        st.scheduleName,
                        st.schedule_from,
                        st.schedule_to,
                        st.shift
                      FROM employee_schedule es
                      INNER JOIN sched_template st ON es.schedule_id = st.template_id
                      WHERE es.user_id = :user_id 
                      AND es.schedule_at BETWEEN :from_date AND :to_date
                      ORDER BY es.schedule_at ASC";
        
        $schedStmt = $pdo->prepare($schedQuery);
        $schedStmt->execute([
            ':user_id' => $employee['user_id'],
            ':from_date' => $from_date,
            ':to_date' => $to_date
        ]);
        
        $employee['schedules'] = $schedStmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    echo json_encode($employees);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>