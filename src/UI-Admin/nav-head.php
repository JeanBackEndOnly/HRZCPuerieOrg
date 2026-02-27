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


$admin_id = $_SESSION['adminData']['user_id'];
$employeeID = $_SESSION['adminData']['employeeID'];
$admin_position = $_SESSION['adminData']['employee_position'];
$admin_department = $_SESSION['adminData']['employee_department'] ?? '';
$admin_firstname = $_SESSION['adminData']['firstname'];
$admin_middelname = $_SESSION['adminData']['middlename'];
$admin_lastname = $_SESSION['adminData']['lastname'];
$profile_picture = $_SESSION['adminData']['profile_picture'];

$stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE type = 'ADMIN' AND status = 'Active'");
$stmt->execute();
$leaveCounts = $stmt->fetchColumn();
?>

<div class="bg-gradient-primary col-md-12 col-12 justify-content-between d-flex">
    <div class="col-md-2 col-1 align-items-center justify-content-center burger-ka-saken" style="display: none;">
        <i class="fa-solid fw-solid fa-bars"></i>
    </div>
    <div class=" d-flex col-md-4 col-6 align-items-center justify-content-center ">
        <img src="../../assets/image/system_logo/pueri-logo.png" class="image-header me-2">
        <h4 class="text-white m-0 header-text">Zamboanga Puericulture Center</h4>
    </div>
    <div class="justify-content-end dap-3 p-4 col-md-7 col-6 mx-2 d-flex media-adjustaments">
        <div class="notification me-2 d-flex align-items-center justify-content-center">
            <form action="../../authentication/hrAuth.php" method="POST">
              <?php $csrf = $_SESSION["csrf_token"] ?? ''?>
              <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
              <input type="hidden" name="update_notification" value="true">
              <input type="hidden" value="<?= $admin_id ?>" name="admin_id">
                <button type="submit" style="border: none; background: none;">
                    <span class="text-white text-bold" style="position: absolute;
                  transform: translate(.8rem, -.7rem);
                  border-radius: 50%;
                  font-size: 12px !important;"><?= $leaveCounts ?></span>
                    <i class="fa-solid fa-bell fs-5 text-white"></i>
                </button>
            </form>
        </div>

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