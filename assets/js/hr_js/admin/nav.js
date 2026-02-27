
document.addEventListener('DOMContentLoaded', function() {
        const logoutBtn = document.getElementById('logoutBtn');
        const logoutDomain = document.getElementById('logoutDomain');
        const cancelBtn = logoutDomain.querySelector('.btn-dark');
        const confirmLogoutBtn = document.getElementById('logout');
        
        // Show/hide logout confirmation popup
        logoutBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            positionLogoutPopup();
            
            if (logoutDomain.style.display === 'none' || !logoutDomain.style.display) {
                logoutDomain.style.opacity = '0';
                logoutDomain.style.display = 'flex';
                logoutDomain.style.transform = 'translateY(0)';

                setTimeout(() => {
                    logoutDomain.style.opacity = '1';
                    logoutDomain.style.transform = 'translateY(0)';
                }, 10);
            } else {
                logoutDomain.style.opacity = '0';
                logoutDomain.style.transform = 'translateY(-10px)';

                setTimeout(() => {
                    logoutDomain.style.display = 'none';
                }, 5000);
            }
        });
        
        // Position the popup relative to the logout button
        function positionLogoutPopup() {
            const btnRect = logoutBtn.getBoundingClientRect();
            const domainWidth = logoutDomain.offsetWidth;
            
            logoutDomain.style.position = 'fixed';
            
            if (btnRect.left + domainWidth > window.innerWidth) {
                logoutDomain.style.left = `${btnRect.left - domainWidth + btnRect.width}px`;
            } else {
                logoutDomain.style.left = `${btnRect.left}px`;
            }
            
            logoutDomain.style.top = `${btnRect.bottom + 5}px`;
        }
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (logoutDomain.style.display !== 'none') {
                positionLogoutPopup();
            }
        });
        
        // Cancel button closes the popup
        cancelBtn.addEventListener('click', closeLogoutPopup);
        
        // Logout button handler - using AJAX
        confirmLogoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const $this = $(this);
            
            $this.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging out...');
            $this.prop('disabled', true);
            
            $.ajax({
                url: base_url + "authentication/action.php?action=logout",
                method: "POST",
                dataType: "json",
                success: function(response) {
                    if (response.status == 1) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            toast: true,
                            position: "top-end",
                            timer: 3000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.href = base_url + (response.redirect_url || "index.php");
                        });
                    } else {
                        showError(response.message);
                        $this.text("Yes");
                        $this.prop('disabled', false);
                    }
                },
                error: function() {
                    console.error("AJAX error");
                    $this.text("Yes");
                    $this.prop('disabled', false);
                }
            });
        });
        
        // Close popup function
        function closeLogoutPopup() {
            logoutDomain.style.opacity = '0';
            logoutDomain.style.transform = 'translateY(-10px)';
            
            setTimeout(() => {
                logoutDomain.style.display = 'none';
            }, 200);
        }
        
        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!logoutDomain.contains(e.target) && e.target !== logoutBtn) {
                closeLogoutPopup();
            }
        });
        
        // Close when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && logoutDomain.style.display !== 'none') {
                closeLogoutPopup();
            }
        });
    });