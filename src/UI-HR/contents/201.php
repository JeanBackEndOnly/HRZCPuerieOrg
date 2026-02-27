<?php
   // Fetch Active Employees
$stmtOfficial = $pdo->prepare("
    SELECT 
        u.user_id, 
        u.firstname, 
        u.middlename, 
        u.lastname, 
        u.suffix,
        d.Department_name AS department,
        u.employeeID,
        jt.jobTitle,
        jt.salary,
        u.status,
        u.profile_picture
    FROM users u
    INNER JOIN employee_data ed ON u.user_id = ed.user_id
    LEFT JOIN jobTitles jt ON ed.jobtitle_id = jt.jobTitles_id
    LEFT JOIN departments d ON ed.Department_id = d.Department_id
    WHERE u.status = 'Active' AND u.user_role = 'EMPLOYEE'
    ORDER BY u.lastname, u.firstname
");
$stmtOfficial->execute();
$officialEmployees = $stmtOfficial->fetchAll(PDO::FETCH_ASSOC);

$countOfficials = 1;
?>
<section>
    <div class="d-flex justify-content-between align-items-center mb-2 col-md-12 col-12 flex-wrap">
        <div class=" col-md-6 col-12">
            <h4 class=""><i class="fa-solid fa-users me-2"></i>201 Management</h4>
            <small class="text-muted ">Create, Update And view employee 201 files</small>
        </div>
        <div class="col-md-4">
            <input type="text" id="searchEmployee" placeholder="Search employees by name or ID....."
                class="form-control">
        </div>

    </div>

    <!-- EMPLOYEE ACCOUNT DISPLAYS =============================================================================================== -->
    <div class="card p-2">
        <div class="row col-md-12">
            <?php 
                if($officialEmployees){
                    foreach ($officialEmployees as $officials) : ?>
            <a href="index.php?page=contents/files&id=<?= htmlspecialchars($officials["user_id"]) ?>"
                class="col-md-4">
                <div class="card col-md-12 d-flex flex-row shadow p-2 rounded-3 border">
                    <div class="col-md-2 d-flex align-items-center">
                        <?php if($officials["profile_picture"] == null){ ?>
                        <strong class="py-2 px-2 text-white"
                            style="
                                                    border-radius: 50%;
                                                    font-weight: 500 !important;
                                                    background-color: rgba(255, 14, 14, 0.70);
                                                    font-size: 15px;
                                                    border: solid 1px #fff;
                                                "><?= htmlspecialchars(strtoupper(substr($officials["firstname"], 0,1) . substr($officials["lastname"], 0,1))) ?></strong>
                        <?php }else{ ?>
                        <img src="../../authentication/uploads/<?= $officials["profile_picture"] ?>"
                            style="width: 200px; height: auto; border-radius: 50%;">
                        <?php } ?>
                    </div>
                    <div class="col-md-10 d-flex flex-column">
                        <strong
                            class="font-13"><?= htmlspecialchars($officials["firstname"] . ' ' . substr($officials["middlename"], 0, 1) . '. ' . $officials["lastname"]) ?></strong>
                        <span
                            class="font-12"><?= htmlspecialchars($officials["jobTitle"] . ' •' . $officials["department"]) . ' •EMP-' . $officials["employeeID"] ?></span>
                    </div>
                </div>
            </a>
            <?php 
                    endforeach; 
                }else {
                    echo '<tr><td colspan="6" class="text-center">No employees found</td></tr>';
                }  
            ?>
        </div>

    </div>
</section>
<script>
document.getElementById("searchEmployee").addEventListener("keyup", function() {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll("table tbody tr");

    tableRows.forEach(row => {
        let text = row.textContent.toLowerCase();

        if (text.includes(searchValue)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
</script>