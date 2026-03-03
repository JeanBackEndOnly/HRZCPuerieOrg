<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'view_header.php';

if (!isset($_SESSION['employeeData'])) {
  include 'eror.php';
  exit;
}

?>
<style>
@media(max-width:768px) {
    .image-header {
        width: 40px !important;
        height: auto !important;
    }
}
</style>

<div class="media-logout-adjust bg-gradient-primary justify-content-between d-flex p-2">
    <div class="col-md-2 col-1 align-items-center justify-content-center burger-ka-saken" style="display: none;">
        <i class="fa-solid fw-solid fa-bars"></i>
    </div>
    <div class="mx-3 d-flex align-items-center justify-content-center col-md-6 col-7 no-media-margin">
        <img src="../../assets/image/system_logo/pueri-logo.png" class="image-header me-2">
        <h4 class="w-100 text-white m-0 system-title">Zamboanga Puericulture Center</h4>
    </div>
</div>


<script>
$(document).ready(function() {
    $('html').css('scroll-behavior', 'smooth');
});

$(document).ready(function() {
    const sidebar = $('.navbarHide');
    const burger = $('.burger-ka-saken i');

    if (!$('.sidebar-overlay').length) {
        $('body').append('<div class="sidebar-overlay"></div>');
    }

    $('.burger-ka-saken').on('click', function() {
        sidebar.toggleClass('navbarShow');
        $('.sidebar-overlay').toggleClass('active');
        burger.toggleClass('fa-times');
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.navbarHide, .burger-ka-saken').length) {
            sidebar.removeClass('navbarShow');
            $('.sidebar-overlay').removeClass('active');
            burger.removeClass('fa-times');
        }
    });

    sidebar.on('click', function(e) {
        e.stopPropagation();
    });
});
</script>
<script>
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

        $this.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging out...'
            );
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
                        window.location.href = base_url + (response.redirect_url ||
                            "index.php");
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
</script>