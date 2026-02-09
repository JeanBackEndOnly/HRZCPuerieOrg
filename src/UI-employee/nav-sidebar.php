
<nav id="sidebar" class="navbarHide">
    <div style="width: 240px !important;">
        <div class="sidebar-list">
            <div class="profile-nav bg-gradeint-fade w-100 d-flex align-items-start justify-content-center flex-column p-2">
                <div class="w-100 d-flex align-items-center justify-content-center">
                    <?php if($profile_picture == null){ ?>
                        <strong class="py-1 px-5 text-dark mb-2" style="
                                    border-radius: 50%;
                                    font-size: 4rem;
                                    background-color: #FEFEFE;
                                "><?= htmlspecialchars(substr($lastname, 0,1)) ?>
                        </strong>
                    <?php } else { ?>
                        <img src="../../authentication/uploads/<?= $getProfile["profile_picture"] ?>" class="image-profile">
                    <?php } ?>
                </div>
                <strong class="text-center text-dark fw-bolder w-100 m-0">
                    <?= htmlspecialchars($firstname) . ' ' . htmlspecialchars(substr($middelname,0,1)) . ' ' . htmlspecialchars($lastname) ?>
                </strong>
                <strong class="w-100 text-center text-dark fw-bolder">
                    <span class="w-100 text-dark fw-bolder"><?= ' ' . htmlspecialchars($employeeID) ?></span>
                </strong>
                <strong class="w-100 text-center text-dark fw-bolder">
                    <span class="w-100 text-dark fw-bolder"><?= ' ' . htmlspecialchars($position) ?></span>
                </strong>
                <strong class="w-100 text-center text-dark fw-bolder">
                    <span class="w-100 text-dark fw-bolder"><?= ' ' . htmlspecialchars($department) ?></span>
                </strong>
            </div>
            <a href="index.php?page=home" class="nav-item nav-home ">
                <span class=""><i class=""></i></span> Dashboard
            </a>
            <a href="index.php?page=contents/leave" class="nav-item nav-leave my-0">
                <span class=""><i class=""></i></span> Leave Request
            </a>
            <a href="index.php?page=contents/payroll" class="nav-item nav-payroll my-0">
                <span class=""><i class=""></i></span> Payslip
            </a>
            <a href="index.php?page=contents/employment" class="nav-item nav-employment my-0">
                <span class=""><i class=""></i></span> Employment History 
            </a>
            <a href="index.php?page=contents/201" class="nav-item nav-201 my-0">
                <span class=""><i class=""></i></span> 201 Files
            </a>
            <a href="index.php?page=contents/setting" class="nav-item nav-setting my-0">
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