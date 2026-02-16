document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM loaded - initializing tabs");

    // Set employee ID in modal
    document.getElementById('getID').addEventListener('click', function() {
        const employeeId = this.getAttribute('data-id');
        document.getElementById('employee_id').value = employeeId;
    });

    // Download functionality
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("downloadBtn") || e.target.closest('.downloadBtn')) {
            const button = e.target.classList.contains("downloadBtn") ? e.target : e.target.closest(
                '.downloadBtn');
            const file = button.getAttribute("data-file");
            console.log("Downloading file:", file);

            const a = document.createElement("a");
            a.href = file;
            a.download = "";
            a.style.display = "none";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    });

    // Delete file modal setup
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("delete-file") || e.target.closest('.delete-file')) {
            const button = e.target.classList.contains("delete-file") ? e.target : e.target.closest(
                '.delete-file');
            const fileId = button.getAttribute("data-id");
            document.getElementById("files_id").value = fileId;
            console.log("Setting file ID for deletion:", fileId);
        }
    });

    // Form submission handling
    const fileForm = document.getElementById('file-form');
    if (fileForm) {
        fileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('File form submitted');
            // Add your form submission logic here
        });
    }

    const deleteForm = document.getElementById('file-delete-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Delete form submitted');
            // Add your delete logic here
        });
    }

    // Debug: Check if all tabs are properly set up
    const tabs = document.querySelectorAll('#fileTabs .nav-link');
    const panes = document.querySelectorAll('.tab-pane');

    console.log('Found tabs:', tabs.length);
    console.log('Found panes:', panes.length);

    tabs.forEach(tab => {
        console.log('Tab:', tab.id, 'target:', tab.getAttribute('data-bs-target'));
    });

    panes.forEach(pane => {
        console.log('Pane:', pane.id, 'display:', window.getComputedStyle(pane).display);
    });

    // Manual tab switching as fallback
    document.querySelectorAll('#fileTabs .nav-link').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove active class from all tabs and panes
            document.querySelectorAll('#fileTabs .nav-link').forEach(t => t.classList.remove(
                'active'));
            document.querySelectorAll('.tab-pane').forEach(p => {
                p.classList.remove('show', 'active');
                p.style.display = 'none';
            });

            // Add active class to clicked tab
            this.classList.add('active');

            // Show corresponding pane
            const targetId = this.getAttribute('data-bs-target');
            const targetPane = document.querySelector(targetId);
            if (targetPane) {
                targetPane.classList.add('show', 'active');
                targetPane.style.display = 'block';
                console.log('Showing pane:', targetId);
            }
        });
    });
});