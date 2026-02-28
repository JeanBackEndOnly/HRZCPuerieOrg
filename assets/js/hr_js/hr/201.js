document.getElementById("searchEmployee").addEventListener("keyup", function() {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll("table tbody tr");

    tableRows.forEach(row => {
        let text = row.textContent.toLowerCase();

        if (text.includes(searchValue)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
    document.addEventListener('DOMContentLoaded', function() {
        twoZeroOneIni();
    
    });

    function twoZeroOneIni() {
        const tabButtons = document.querySelectorAll('#twoZeroOneIni .nav-link');
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
                    targetContent.style.display = 'flex';
                    targetContent.classList.add('show', 'active');
                    
                    // Load data for the active tab
                    if (targetId === '#Applicants') {
                        // loadEmployeeData_hr_pending();
                    } else if (targetId === '#Officials') {
                        // loadEmployeeData_hr();
                    }
                }
            });
        });
    }