<nav id="sidebar" class="navbarHide">
    <div style="width: 240px; border-radius: 5px;">
        <div class="sidebar-list">
            <div
                class="profile-nav mb-1 p-3 bg-gradeint-fade w-100 d-flex align-items-start justify-content-center p-2">
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <?php if($profile_picture == null){ ?>
                    <div class="nav-circle-profile d-flex align-items-center justify-content-center font-19">
                        <strong class="p-0 text-white">
                            <?= htmlspecialchars(substr($firstname, 0,1) . substr($lastname, 0,1)) ?>
                        </strong>
                    </div>
                    <?php } else {?>
                    <img src="../../authentication/uploads<?= $profile_picture ?>" class="image-profile"
                        alt="This is the admin profile picture">
                    <?php } ?>
                </div>
                <div class="col-md-8 d-flex flex-column ps-2">
                    <strong class="text-start text-dark fw-bolder col-md-12 m-0">
                        <span
                            class="w-100 text-start text-dark fw-bolder"><?= htmlspecialchars($firstname) . ' '
                            . htmlspecialchars(substr($middelname,0,1)) . '. ' . htmlspecialchars($lastname) ?>
                        </span>
                    </strong>
                    <strong class="w-100 text-start text-dark d-flex align-items-center">
                        <i class="fa-solid fa-circle text-success font-8 me-1"></i><span
                            class="w-100 text-start text-dark fw-bolder"><?= 'EMP-' . htmlspecialchars($employeeID) ?></span>
                    </strong>
                </div>

            </div>
            <span class="w-100 text-gray text-start ms-1 mt-5">Menu</span>
            <a href="index.php?page=home" class="nav-item nav-home m-0">
                <span class="me-1"><i class="fa-solid fa-gauge"></i></span> Dashboard
            </a>
            <a href="index.php?page=contents/recruitment" class="nav-item nav-recruitment nav-profile nav-pds">
                <span class="me-1"><i class="fa-solid fa-users"></i></span> Employees
            </a>
            <a href="index.php?page=contents/leave" class="nav-item nav-leave nav-viewLeave nav-reviewLeave">
                <span class="me-1"><i class="fa-solid fa-calendar"></i></span> Leave
            </a>
            <a href="index.php?page=contents/201" class="nav-item nav-201 nav-files">
                <span class="me-1"><i class="fa-solid fa-file-pdf"></i></span> 201 Files
            </a>
            <a href="index.php?page=contents/hr_settings" class="nav-item nav-hr_settings nav-employee_sched">
                <span class="me-1"><i class="fa-solid fa-gears"></i></span> Schedule Management
            </a>
            <a href="index.php?page=contents/setting" class="nav-item nav-setting ">
                <span class="me-1"><i class="fa-solid fa-user-gear"></i></span> Account Setting
            </a>
            <div class="text-dark position-logout d-flex border" style="width: 240px;">
                <div class="w-70 text-center p-2">
                    <strong class="fs-5">HR PANEL</strong>
                </div>
                <div class="w-30 p-2 d-flex align-items-center justify-content-center" style="border-left: solid 1px #00000038;">
                    <button type="button" id="logoutBtn">
                        <i class="fas fa-sign-out-alt text-dark ms-1 me-3 fs-6"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>
    <div class="logoutDomain col-md-3 col-8 h-auto shadow rounded-1 flex-column border" id="logoutDomain"
        style="display:none; background-color: #fff !important;">
        <div class="header-logout bg-danger p-3 d-flex align-items-start justify-content-start w-100 rounded-top">
            <strong class="text-white">Logout Confirmation</strong>
        </div>
        <div class="body-logout py-4 px-4">
            <span class="fw-bold text-muted"> Are you sure you want to logout?</span>
        </div>
        <div class="footer-logout w-100 d-flex align-items-end justify-content-end gap-3 pb-3 pe-3 pt-2"
            style="border-top: solid .5px #0e0e0e4f !important;">
            <button class="m-0 btn btn-danger" id="logout" class="logout" style="cursor: pointer;">
                yes
            </button>
            <button class="m-0 btn btn-dark" type="button">Cancel</button>
        </div>
    </div>
</nav>
<script src="../../assets/js/hr_js/admin/nav.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-btn');

    toggleButtons.forEach(button => {
        const targetId = button.getAttribute('data-target');
        const targetSection = document.getElementById(targetId);

        button.classList.add('collapsed');

        button.addEventListener('click', function() {
            targetSection.classList.toggle('show');

            this.classList.toggle('collapsed');
        });
    });

    const page = '<?php echo isset($_GET["page"]) ? $_GET["page"] : "home"; ?>';
    const slug = page.split('/').pop();
    const navItem = document.querySelector('.nav-' + slug);
    if (navItem) {
        navItem.classList.add('active');

        const parentSection = navItem.closest('.toggle-section');
        if (parentSection) {
            parentSection.classList.add('show');
            const toggleBtn = document.querySelector(`[data-target="${parentSection.id}"]`);
            if (toggleBtn) {
                toggleBtn.classList.remove('collapsed');
            }
        }
    }
});
</script>