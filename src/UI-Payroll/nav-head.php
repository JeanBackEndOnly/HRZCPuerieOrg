<?php
// include "../../header.php";
include 'view_header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['payrollData'])) {
  include 'eror.php';
  exit;
}

$employeeID = $_SESSION['payrollData']['employeeID'] ?? '';
$position = $_SESSION['payrollData']['employee_position'] ?? '';
$department = $_SESSION['payrollData']['employee_department'] ?? '';
$firstname = $_SESSION['payrollData']['firstname'] ?? '';
$middelname = $_SESSION['payrollData']['middlename'] ?? '';
$lastname = $_SESSION['payrollData']['lastname'] ?? '';
$profile_picture = $_SESSION['payrollData']['profile_picture'] ?? '';
$payroll_id = $_SESSION['payrollData']['user_id'] ?? '';

// $stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE type = 'HR' AND status = 'Active'");
// $stmt->execute();
// $leaveCounts = $stmt->fetchColumn();
?>

<div class="bg-gradient-primary col-md-12 col-12 justify-content-between d-flex">
    <div class="col-md-2 col-1 align-items-center justify-content-center burger-ka-saken" style="display: none;">
        <i class="fa-solid fw-solid fa-bars"></i>
    </div>
    <div class=" d-flex col-md-4 col-6 align-items-center justify-content-center ">
        <img src="../../assets/image/system_logo/pueri-logo.png" class="image-header me-2">
        <h4 class="text-white m-0 header-text">Zamboanga Puericulture Center</h4>
    </div>
    <!-- <div class="justify-content-end dap-3 p-4 col-md-7 col-6 mx-2 d-flex media-adjustaments">
        <div class="notification me-2 d-flex align-items-center justify-content-center">
            <form action="../../authentication/hrAuth.php" method="POST">
                <?php $csrf = $_SESSION["csrf_token"] ?? ''?>
                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                <input type="hidden" name="update_notification" value="true">
                <input type="hidden" name="admin_id" value="">
                <button type="submit" style="border: none; background: none;">
                    <span class="text-white text-bold" style="position: absolute;
                  transform: translate(.8rem, -.7rem);
                  border-radius: 50%;
                  font-size: 12px !important;"><?= $leaveCounts ?></span>
                    <i class="fa-solid fa-bell fs-5 text-white"></i>
                </button>
            </form>
        </div>
    </div> -->
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
</script>