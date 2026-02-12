
<nav id="sidebar" class="navbarHide">
    <div style="width: 240px; border-radius: 5px;">
        <div class="sidebar-list">
            <div class="profile-nav bg-gradeint-fade w-100 d-flex align-items-start justify-content-center flex-column p-2">
                <div class="w-100 d-flex align-items-center justify-content-center">
                    <?php if($profile_picture == null){ ?>
                        <strong class="py-1 px-5 text-dark mb-2" style="
                                    border-radius: 50%;
                                    font-size: 4rem;
                                    background-color: #FEFEFE;
                                "><?= htmlspecialchars(substr($admin_lastname, 0,1)) ?>
                        </strong>
                    <?php } else {?>
                        <img src="../../authentication/uploads<?= $profile_picture ?>" class="image-profile" alt="This is the admin profile picture">
                    <?php } ?>
                </div>
                <strong class="text-center text-dark fw-bolder col-md-12 m-0">
                    <span class="w-100 text-start text-dark fw-bolder"><?= htmlspecialchars($admin_firstname) . ' '
                        . htmlspecialchars(substr($admin_middelname,0,1)) . ' ' . htmlspecialchars($admin_lastname) ?>
                    </span>
                </strong>
                <strong class="w-100 text-center text-dark fw-bolder">
                    <span class="w-100 text-start text-dark fw-bolder"><?= htmlspecialchars($admin_employee_id) ?></span>
                </strong>
                <strong class="w-100 text-center text-dark fw-bolder">
                    <span class="w-100 text-start text-dark fw-bolder"><?= htmlspecialchars($admin_position) ?></span>
                </strong>
                <strong class="w-100 text-center text-dark fw-bolder">
                    <span class="w-100 text-start text-dark fw-bolder"><?= htmlspecialchars($admin_department) ?></span>
                </strong>
            </div>
            <a href="index.php?page=home" class="nav-item nav-home rounded-2 m-0">
                <span class=""><i class=""></i></span> Dashboard
            </a>
            
            <!-- Human Resources Section -->
            <button class="toggle-btn collapsed rounded-2 m-0" data-target="hr-section">
                Human Resources <i class="toggle-icon"><i class="fa-solid fa-caret-down"></i></i>
            </button>
            <div id="hr-section" class="toggle-section">
                <a href="index.php?page=contents/recruitment" class="nav-item nav-recruitment nav-profile nav-pds my-1 rounded-2">
                    <span class=""><i class=""></i></span> Employees
                </a>
                <a href="index.php?page=contents/leave" class="nav-item nav-leave nav-viewLeave nav-reviewLeave my-1 rounded-2">
                    <span class=""><i class=""></i></span> Leave
                </a>
                <a href="index.php?page=contents/dept_job" class="nav-item nav-dept_job my-1 rounded-2">
                    <span class=""><i class=""></i></span> Departments & Jobs
                </a>
                <a href="index.php?page=contents/201" class="nav-item nav-201 my-1 rounded-2">
                    <span class=""><i class=""></i></span> 201 Files
                </a>
                <a href="index.php?page=contents/hr_settings" class="nav-item nav-hr_settings my-1 rounded-2">
                    <span class=""><i class=""></i></span> HR settings
                </a>
            </div>
            <a href="index.php?page=contents/form" class="nav-item nav-form rounded-2 m-0">
                <span class=""><i class=""></i></span> Forms
            </a>
            <a href="index.php?page=contents/setting" class="nav-item nav-setting rounded-2 ">
                <span class=""><i class=""></i></span> Account Settings
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