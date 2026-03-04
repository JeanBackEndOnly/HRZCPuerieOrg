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
        <i class="fa-solid fa-bell shadow border rounded text-light cursor-pointer m-0 p-1 fs-4"
        id="notification-bell"></i>
    </div>
    <div class="col-md-2 display-notification position-fixed card p-2 shadow rounded" id="display-notifications">
        <?php if($getNotifications) : ?>
            
        <?php else : ?>
            <strong class="w-100 text-center text-dark">NO NOTIFICATIONS YET</strong>
        <?php endif; ?>
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