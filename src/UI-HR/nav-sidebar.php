<?php 
    $stmt = $pdo->prepare("SELECT profile_picture FROM employee_data WHERE employee_id = ?");
    $stmt->execute([$hr_id]);
    $getProfile = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<nav id="sidebar" class="navbarHide m-0 p-0">
    <div style="width: 240px; border-radius: 5px;">
        <div class="sidebar-list m-0">
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
                <strong class="text-center text-dark fw-bolder col-md-12 m-0">
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
                <a href="index.php?page=contents/leave" class="nav-item nav-leave my-1 rounded-2">
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
            <a href="index.php?page=contents/setting" class="nav-item nav-setting rounded-2 m-0">
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