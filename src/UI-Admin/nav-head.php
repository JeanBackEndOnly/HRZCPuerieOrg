<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    include "../../header.php";
    include 'view_header.php';

if (!isset($_SESSION['adminData'])) {
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
            <input type="hidden" name="user_id" value="<?= $admin_id ?>" >
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