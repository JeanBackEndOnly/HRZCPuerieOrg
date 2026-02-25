<nav id="sidebar" class="navbarHide">
    <div style="width: 240px; border-radius: 5px;">
        <div class="sidebar-list">
            <div class="profile-nav mb-1 p-3 bg-gradeint-fade w-100 d-flex align-items-start justify-content-center p-2">
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <?php if($profile_picture == null){ ?>
                    <div class="nav-circle-profile d-flex align-items-center justify-content-center font-19">
                        <strong class="p-0 text-white">
                            <?= htmlspecialchars(substr($admin_firstname, 0,1) . substr($admin_lastname, 0,1)) ?>
                        </strong>
                    </div>
                    <?php } else {?>
                    <img src="../../authentication/uploads<?= $profile_picture ?>" class="image-profile"
                        alt="This is the admin profile picture">
                    <?php } ?>
                </div>
                <div class="col-md-8 d-flex flex-column ps-2">
                    <strong class="text-start text-dark fw-bolder col-md-12 m-0">
                        <span class="w-100 text-start text-dark fw-bolder"><?= htmlspecialchars($admin_firstname) . ' '
                            . htmlspecialchars(substr($admin_middelname,0,1)) . '. ' . htmlspecialchars($admin_lastname) ?>
                        </span>
                    </strong>
                    <strong class="w-100 text-start text-dark d-flex align-items-center">
                        <i class="fa-solid fa-circle text-danger font-8 me-1"></i><span class="w-100 text-start text-dark fw-bolder"><?= htmlspecialchars($admin_position) ?></span>
                    </strong>
                </div>
                
            </div>
            <span class="w-100 text-gray text-start ms-1 mt-5">Menu</span>
            <a href="index.php?page=home" class="nav-item nav-home m-0">
                <span class="me-1"><i class="fa-solid fa-gauge"></i></span> Dashboard
            </a>
            <a href="index.php?page=contents/recruitment"
                class="nav-item nav-recruitment nav-profile nav-pds">
                <span class="me-1"><i class="fa-solid fa-users"></i></span> Employees
            </a>
            <a href="index.php?page=contents/leave"
                class="nav-item nav-leave nav-viewLeave nav-reviewLeave">
                <span class="me-1"><i class="fa-solid fa-calendar"></i></span> Leave
            </a>
            <a href="index.php?page=contents/201" class="nav-item nav-201 nav-files">
                <span class="me-1"><i class="fa-solid fa-file-pdf"></i></span> 201 Files
            </a>
            <a href="index.php?page=contents/hr_settings"
                class="nav-item nav-hr_settings nav-employee_sched">
                <span class="me-1"><i class="fa-solid fa-gears"></i></span> Schedule setting
            </a>
            <a href="index.php?page=contents/system_setting" class="nav-item nav-system_setting">
                <span class="me-1"><i class="fa-solid fa-building-user"></i></span> System Setting
            </a>
            <!-- <a href="index.php?page=contents/form" class="nav-item nav-form m-0">
                <span class="me-1"><i class="me-1"></i></span> Forms
            </a> -->
            <a href="index.php?page=contents/setting" class="nav-item nav-setting ">
                <span class="me-1"><i class="fa-solid fa-user-gear"></i></span> Account Setting
            </a>
        </div>
    </div>
</nav>

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