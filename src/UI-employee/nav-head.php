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

<div class="bg-gradient-primary col-md-12 col-12 justify-content-between d-flex p-2">
    <div class="col-md-2 col-1 align-items-center justify-content-center burger-ka-saken" style="display: none;">
        <i class="fa-solid fw-solid fa-bars"></i>
    </div>
    <div class=" d-flex col-md-7 col-9 align-items-center justify-content-start ">
        <img src="../../assets/image/system_logo/pueri-logo.png" class="image-header me-2">
        <h4 class="text-white m-0 header-text">Zamboanga Puericulture Center Org. 144 </h4>
    </div>
    <div class="col-md-1 col-2 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center notification-count"><strong class="font-12"><?= $notificationCounts ?? 0 ?></strong></div>
        <form id="notification-bell-form">
            <input type="hidden" name="user_id" value="<?= $user_id ?>" >
            <button type="submit" class="button-no-border" id="notification-bell" onclick="notify_display()">
            <i class="fa-solid fa-bell shadow border rounded text-light cursor-pointer m-0 p-1 fs-4"></i>
            </button>
        </form>
    </div>
    <div class="col-md-3 display-notification position-fixed card p-1 shadow rounded" id="display-notifications">
        <?php 
            if($getNotifications) : 
                foreach($getNotifications as $notify) : 
        ?>
            <div class="card p-2 mt-1" >
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="col-md-6">
                        <label class="form-label ms-0">
                            <strong class="me-1">
                                 <?= isset($notify["notification_status"]) && $notify["notification_status"] == 'read' ? '<i class="fa-solid text-dark fa-circle"></i>' : '<i class="fa-solid text-success fa-circle"></i>'; ?>
                            </strong>
                            <?= $notify["notification_name"] ?>
                        </label>
                    </div>
                    <div class="col-md-6 pe-1">
                        <label class="form-label w-100 text-end">date: <?= date('M d Y', strtotime($notify["notify_at"])) ?></label>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label m-0">Description:</label>
                    <label class="form-label"><?= $notify["description"] ?></label>
                </div>
            </div>
        <?php   
                endforeach;
            else : 
        ?>
            <strong class="w-100 text-center text-dark">NO NOTIFICATIONS YET</strong>
        <?php endif; ?>
    </div>
</div>


<script>
    function notify_display(){
        let notify = document.getElementById('display-notifications');
        if(notify.style.display == 'flex'){
            notify.style.display = 'none'
        }else{
            notify.style.display = 'flex'
        }
    }
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
<!-- <script>
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
</script> -->