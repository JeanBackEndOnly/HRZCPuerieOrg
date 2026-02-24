document.addEventListener('DOMContentLoaded', function() {
    initTabs();
    // Load pending leave requests by default (first tab)
   
});

function initTabs() {
    const tabButtons = document.querySelectorAll('#hr_settingsTabs .nav-link');
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
                if (targetId === '#employee_schedule') {
                    document.getElementById('displayFilter').style.display = 'none';
                    document.getElementById('displayButton').style.display = 'none';
                    document.getElementById('displaySearch').style.display = 'flex';
                } else if (targetId === '#schedule_template') {
                    document.getElementById('displayFilter').style.display = 'none';
                    document.getElementById('displayButton').style.display = 'flex';
                    document.getElementById('displaySearch').style.display = 'none';
                } 
                else if (targetId === '#print_schedule') {
                    document.getElementById('displayFilter').style.display = 'flex';
                    document.getElementById('displayButton').style.display = 'none';
                    document.getElementById('displaySearch').style.display = 'none';
                } 
            }
        });
    });
}
document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("searchEmployee");
    const table = document.getElementById("employeeTable");
    const rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

    searchInput.addEventListener("keyup", function () {
        const filter = searchInput.value.toLowerCase();

        for (let i = 0; i < rows.length; i++) {

            const name = rows[i].cells[1].textContent.toLowerCase();
            const department = rows[i].cells[2].textContent.toLowerCase();

            if (name.includes(filter) || department.includes(filter)) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    });

});