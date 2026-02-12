<?php
    include "../../view/admin/view.php"; 
    
    $unit_sections = getUnitSection();
    $getUnit = $unit_sections["Unit_Sections"];
    
    $employees = getEmployees();
    $getEmployee = $employees["employee_data"];
?>