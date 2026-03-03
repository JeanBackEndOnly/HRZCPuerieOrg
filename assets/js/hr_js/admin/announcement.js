document.addEventListener('DOMContentLoaded', function() {
    initTabs();
});

function initTabs() {
    const tabButtons = document.querySelectorAll('#messagesTabs .nav-link');
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
                if (targetId === '#publicMessage') {
                } else if (targetId === '#privateMessage') {
                } else if (targetId === '#sentMessage') {
                }
            }
        });
    });
}