// ================================= Admin Settings tabs
   document.addEventListener('DOMContentLoaded', function() {
        AdminSettingsIni();
    
    });

    function AdminSettingsIni() {
        const tabButtons = document.querySelectorAll('#AdminSettingsTabs .nav-link');
        const tabContents = document.querySelectorAll('.tab-pane');
        
        // Initialize tabs - hide all except active
        tabContents.forEach(content => {
            if (!content.classList.contains('active')) {
                content.style.display = 'none';
            }
        });
        
        tabButtons.forEach((button) => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Update active button
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.style.display = 'none';
                    content.classList.remove('show', 'active');
                });
                
                // Show the selected tab
                const targetId = this.getAttribute('data-bs-target');
                const targetContent = document.querySelector(targetId);
                if (targetContent) {
                    targetContent.style.display = 'block';
                    targetContent.classList.add('show', 'active');
                    
                    // Load data for the active tab
                    if (targetId === '#hrEmployees') {
                        // loadEmployeeData_hr_pending();
                    } else if (targetId === '#Personal') {
                        // loadEmployeeData_hr();
                    } else if (targetId === '#Employement') {
                        // loadEmployeeData_hr_rejected();
                    }  else if (targetId === '#history') {
                        // loadEmployeeData_hr_rejected();
                    } 
                }
            });
        });
    }
// ================================= DEPARTMENTS AND JOB  (TABS)  
    document.addEventListener('DOMContentLoaded', function() {
        initDepartmentsJobTitlesTabs();
    });

    function initDepartmentsJobTitlesTabs() {
        const tabButtons = document.querySelectorAll('#DepartmentsJobsInfoTab .nav-link');
        const tabContents = document.querySelectorAll('.tab-pane');
        
        // Initialize tabs - hide all except active
        tabContents.forEach(content => {
            if (!content.classList.contains('active')) {
                content.style.display = 'none';
            }
        });
        
        tabButtons.forEach((button) => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Update active button
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.style.display = 'none';
                    content.classList.remove('show', 'active');
                });
                
                // Show the selected tab
                const targetId = this.getAttribute('data-bs-target');
                const targetContent = document.querySelector(targetId);
                if (targetContent) {
                    targetContent.style.display = 'block';
                    targetContent.classList.add('show', 'active');
                    
                    // Load data for the active tab
                    if (targetId === '#JobTitlesInfno') {
                        
                    } else if (targetId === '#departmentsInfo') {
                        
                    }  else if (targetId === '#unitSections') {
                        
                    } else if (targetId === '#CareerPathsInfo') {
                        loadCareerPathData();
                    } 
                }
            });
        });
    }

    // DEPARTMENTS ============================================
    function edit_department(id, name, code) {
        // Set the values directly (bypassing the fetch for now)
        document.getElementById('editDepartmentId').value = id;
        document.getElementById('editDepartmentName').value = name;
        document.getElementById('editDepartmentCode').value = code;

        console.log('Modal values set:',
            document.getElementById('editDepartmentId').value,
            document.getElementById('editDepartmentName').value,
            document.getElementById('editDepartmentCode').value
        );
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editdepartmentsModal'));
        editModal.show();
    }
    // Uniit section edit
    function edit_UnitSection(id, name, department_id) {
        // Set the values directly (bypassing the fetch for now)
        document.getElementById('editUnitSectionsId').value = id;
        document.getElementById('editUnitSectionName').value = name;
        document.getElementById('editUnderDepartmentId').value = department_id;

        console.log('Modal values set:',
            document.getElementById('editUnitSectionsId').value,
            document.getElementById('editUnitSectionName').value,
            document.getElementById('editUnderDepartmentId').value
        );
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editunitsectionModal'));
        editModal.show();
    }
    // onclicked function Delete
    function setDeleteDepartmentId(id) {
        
        document.getElementById('deleteDepartmentId').value = id
    }
    // JOB TITLES ============================================

    function edit_jobTitle(id, title, code, salary) {
        // Set the values in the modal
        document.getElementById('editUserIdEdit').value = id;
        document.getElementById('jobTitle').value = title;
        document.getElementById('jobTitle_code').value = code;
        document.getElementById('salary').value = salary;
        
        var editModal = new bootstrap.Modal(document.getElementById('editJobTitlesModal'));
        editModal.show();
    }
    function setDeletejobtTitleId(id) {
        document.getElementById('deleteJobTitleId').value = id;
    }
