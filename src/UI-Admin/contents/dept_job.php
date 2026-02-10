<?php
    $stmtDepartments = $pdo->prepare("SELECT Department_id, Department_name, Department_code, addAt
                FROM departments
                ORDER BY addAt ASC");
    $stmtDepartments->execute();
    $Departments = $stmtDepartments->fetchAll(PDO::FETCH_ASSOC);

    $stmtUnitSections = $pdo->prepare("SELECT us.unit_section_id, us.unit_section_name, us.addAt, d.Department_name, d.Department_code, d.Department_id
                FROM unit_section us
                INNER JOIN departments d ON us.department_id = d.Department_id 
                ORDER BY addAt ASC");
    $stmtUnitSections->execute();
    $unitSections = $stmtUnitSections->fetchAll(PDO::FETCH_ASSOC);

    $stmtJobtitles = $pdo->prepare("SELECT j.jobTitles_id, j.jobTitle, j.salary, j.addAt, d.Department_name
                    FROM jobTitles j
                    INNER JOIN departments d ON j.department_id = d.Department_id
                    ORDER BY d.Department_name ASC");
    $stmtJobtitles->execute();
    $jobtitlesData = $stmtJobtitles->fetchAll(PDO::FETCH_ASSOC);

    $counts = 1;
    $countsjob = 1;
?>
<section>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="mx-2">
            <h4 class=""><i class="fa-solid fa-building-user me-2"></i>Departments & Job Titles Management</h4>
            <small class="text-muted ">Manage Puericultures departments and Job Titles</small>
        </div>
    </div>

    <div class="row mb-2">
        <!-- <div class="col-md-3">
                <div class="card-header shadow  bg-white text-center p-4 ">
                    <h5 id="totalChildren"><?php echo get_total() ?></h5>
                    <small>Application request</small>
                </div>
            </div> -->
        <?php
            $departments = $pdo->query("SELECT COUNT(*) FROM departments")->fetchColumn();
            $jobtitles = $pdo->query("SELECT COUNT(*) FROM jobTitles")->fetchColumn();
        ?>
        <div class="col-md-6">
            <div class="card-header shadow bg-white text-center p-4 ">

                <h5 id="pendingEnrollments"><?= $departments ?></h5>
                <small>Departments</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-header shadow bg-white text-center p-4 ">
                <h5 id="approvedEnrollments"><?= $jobtitles ?></h5>
                <small>Job Titles</small>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body col-md-12 col-12 d-flex justify-content-between">
            <ul class="nav nav-tabs col-md-12 col-12" id="DepartmentsJobsInfoTab">
                <li class="nav-item cursor-pointer col-md-2">
                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#departmentsInfo"><i
                            class="fa-solid me-2 fa-building"></i>Departments</a>
                </li>
                <li class="nav-item cursor-pointer col-md-2">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#unitSections">
                        <i class="fa-solid fa-building-un me-2"></i>Unit/Section</a>
                </li>
                <li class="nav-item cursor-pointer col-md-2">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#JobTitlesInfno"><i
                            class="fa-solid me-2 fa-user-doctor"></i>Job Titles</a>
                </li>
                <li class="nav-item cursor-pointer col-md-2">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#CareerPathsInfo"><i
                            class="fa-solid me-2 fa-up-down"></i></i>Career Paths</a>
                </li>
            </ul>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">
                <!-- departments -->
                <div class="tab-pane fade show active" id="departmentsInfo" role="tabpanel">
                    <!-- DEPARTMENTS ADD AND SEARCH -->
                    <div class="col-md-12 col-12 d-flex justify-content-between">
                        <div class="col-md-4 col-5">
                            <input type="text" placeholder="search by... Department name and department code"
                                id="searchDepartments" class="form-control">
                        </div>
                        <div class="col-md-3 col-6 d-flex justify-content-end">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#addDepartments" id="add_new">
                                <i class="fa fa-plus"></i> Add new Departments
                            </button>
                        </div>
                    </div>
                    <!-- ADD departments -->
                    <div class="modal fade" id="addDepartments" tabindex="-1" aria-labelledby="addDepartmentsLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title text-white" id="createAccountsLabel">Add New Departments
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close" onclick="location.reload()"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row g-3" id="department-form">
                                        <div class="m-2">
                                            <label class="form-label">Department name</label>
                                            <input required type="text" class="form-control" name="department_name">
                                        </div>
                                        <div class="m-2">
                                            <label class="form-label">Department code</label>
                                            <input required type="text" class="form-control" name="department_code">
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <button type="submit" class="btn btn-danger px-5">
                                                <i class="bi bi-person-plus-fill me-1"></i> Add Department
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- edit departments -->
                    <div class="modal fade" id="editdepartmentsModal" tabindex="-1"
                        aria-labelledby="editdepartmentsModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="edit-department">
                                <div class="modal-content">
                                    <div class="modal-header bg-gradient-primary text-white">
                                        <h5 class="modal-title text-white" id="editdepartmentsModalLabel">Edit
                                            Department
                                            Information</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <input type="hidden" name="department_id" id="editDepartmentId">

                                        <div class="mb-3">
                                            <label for="editDepartmentName" class="form-label">Department Name</label>
                                            <input type="text" class="form-control" id="editDepartmentName" value=""
                                                name="department_name">
                                        </div>

                                        <div class="mb-3">
                                            <label for="editDepartmentCode" class="form-label">Department Code</label>
                                            <input type="text" class="form-control" id="editDepartmentCode" value=""
                                                name="department_code">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Update Department</button>
                                        <button type="button" class="btn btn-dark"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- delete Departments -->
                    <div class="modal fade" id="deleteDepartmentModal" tabindex="-1"
                        aria-labelledby="deleteJobModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="department-delete-form" class="modal-content">
                                <div class="modal-header bg-gradient-primary text-white">
                                    <h5 class="modal-title text-white" id="deleteJobModalLabel">Confirmation Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this Department?
                                    <input type="hidden" name="department_id" id="deleteDepartmentId">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- DEPARTMENTS TABLE -->
                    <div class="table-responsive table-body">
                        <table class="table table-bordered table-hover table-sm text-center"
                            style="font-size: 0.875rem;">
                            <thead class="table-light">
                                <tr style="color: #555;">
                                    <th>#</th>
                                    <th>Department Name</th>
                                    <th>Department Code</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" id="departments" style="color: #666;">
                                <?php foreach($Departments as $dept) : ?>
                                <tr>
                                    <th><?= $counts++ ?></th>
                                    <th><?= htmlspecialchars($dept["Department_name"]) ?></th>
                                    <th><?= htmlspecialchars($dept["Department_code"]) ?></th>
                                    <th><?= htmlspecialchars($dept["addAt"]) ?></th>
                                    <th>
                                        <button type="button" class="btn m-0 btn-sm btn-danger" onclick="edit_department(
                                                <?= $dept['Department_id'] ?>,
                                                '<?= addslashes($dept['Department_name']) ?>',
                                                '<?= addslashes($dept['Department_code']) ?>'
                                            )">
                                            <i class="fas fa-eye"></i> Edit
                                        </button>

                                        <button type="button" class="btn m-0 btn-sm btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#deleteDepartmentModal"
                                            onclick="setDeleteDepartmentId(<?= $dept['Department_id'] ?>)">
                                            <i class="fas fa-eye"></i> Delete
                                        </button>
                                    </th>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- unit sections -->
                <div class="tab-pane fade" id="unitSections" role="tabpanel">
                    <!-- unit sections ADD AND SEARCH -->
                    <div class="col-md-12 col-12 d-flex justify-content-between">
                        <div class="col-md-4 col-5">
                            <input type="text" placeholder="search by... unit section name" id="searchDepartments"
                                class="form-control">
                        </div>
                        <div class="col-md-3 col-6 d-flex justify-content-end">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#addUnitSections" id="add_new">
                                <i class="fa fa-plus"></i> Add new Unit/Sections
                            </button>
                        </div>
                    </div>
                    <!-- ADD unit sections -->
                    <div class="modal fade" id="addUnitSections" tabindex="-1" aria-labelledby="addUnitSectionsLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title text-white" id="createAccountsLabel">Add New Unit/Section
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close" onclick="location.reload()"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row g-3" id="unitsection-form">
                                        <div class="m-2">
                                            <label class="form-label">Unit section name</label>
                                            <input required type="text" class="form-control" name="unit_section_name">
                                        </div>
                                        <div class="m-2">
                                            <label class="form-label">Under Department</label>
                                            <select name="department_id" id="" class="form-select">
                                                <option value="">Select Department</option>
                                                <?php
                                                    foreach($Departments as $dept) :
                                                ?>
                                                <option value="<?= $dept["Department_id"] ?>">
                                                    <?= htmlspecialchars($dept["Department_name"] . ' (' . $dept["Department_code"] . ')') ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <button type="submit" class="btn btn-danger px-5">
                                                <i class="bi bi-person-plus-fill me-1"></i> Add Department
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- edit unit section -->
                    <div class="modal fade" id="editunitsectionModal" tabindex="-1"
                        aria-labelledby="editunitsectionModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="edit-unitsection">
                                <div class="modal-content">
                                    <div class="modal-header bg-gradient-primary text-white">
                                        <h5 class="modal-title text-white" id="editunitsectionModalLabel">Edit Unit/Section information</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <input type="hidden" name="unit_section_id" id="editUnitSectionsId">

                                        <div class="mb-3">
                                            <label for="editUnitSectionName" class="form-label">Unit/Section name</label>
                                            <input type="text" class="form-control" id="editUnitSectionName" value=""
                                                name="unit_section_name">
                                        </div>

                                        <div class="mb-3">
                                            <label for="editUnderDepartmentId" class="form-label">Under Department</label>
                                            <select name="department_id" id="editUnderDepartmentId" class="form-select">
                                                <?php foreach($Departments as $dept) : ?>
                                                    <option value="<?= $dept["Department_id"] ?>"><?= htmlspecialchars($dept["Department_name"] . ' (' . $dept["Department_code"] . ')') ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Update Unit/Section</button>
                                        <button type="button" class="btn btn-dark"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- delete Unit section -->
                    <div class="modal fade" id="deleteUnitSectionModal" tabindex="-1"
                        aria-labelledby="deleteUnitSectionModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="unitsection-delete-form" class="modal-content">
                                <div class="modal-header bg-gradient-primary text-white">
                                    <h5 class="modal-title text-white" id="deleteUnitSectionModalLabel">Confirmation Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this Unit/Section?
                                    <input type="hidden" name="unit_section_id" id="deleteUnitSectionsId">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- UNIT/SECCTION TABLE -->
                    <div class="table-responsive table-body">
                        <table class="table table-bordered table-hover table-sm text-center"
                            style="font-size: 0.875rem;">
                            <thead class="table-light">
                                <tr style="color: #555;">
                                    <th>#</th>
                                    <th>Unit/Section</th>
                                    <th>Department</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            
                            <tbody class="text-center" id="departments" style="color: #666;">
                                <?php
                                    $countsUnitSection = 1;
                                    if($unitSections){ ?>
                                    <?php foreach($unitSections as $uniSec) : ?>
                                    <tr>
                                        <th><?= $countsUnitSection++ ?></th>
                                        <th><?= htmlspecialchars($uniSec["unit_section_name"]) ?></th>
                                        <th><?= htmlspecialchars($uniSec["Department_name"] . ' (' . $uniSec["Department_code"] . ')') ?></th>
                                        <th><?= htmlspecialchars($uniSec["addAt"]) ?></th>
                                        <th>
                                            <button type="button" class="btn m-0 btn-sm btn-danger" onclick="edit_UnitSection(
                                                    <?= $uniSec['unit_section_id'] ?>,
                                                    '<?= addslashes($uniSec['unit_section_name']) ?>',
                                                    '<?= addslashes($uniSec['Department_id']) ?>'
                                                )">
                                                <i class="fas fa-eye"></i> Edit
                                            </button>

                                            <button type="button" class="btn m-0 btn-sm btn-dark"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteUnitSectionModal"
                                                data-id="<?= $uniSec['unit_section_id'] ?>"
                                                id="GetDeleteIdFromUniitSection"
                                                <i class="fas fa-eye"></i> Delete
                                            </button>
                                        </th>
                                    </tr>
                                    <?php endforeach;
                                         }else{ ?>
                                        <tr><td class="w-100 text-center py-2"colspan="4"><strong>No Section/Unit Found</strong></td></tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- Job Titles -->
                <div class="tab-pane fade" id="JobTitlesInfno" role="tabpanel">
                    <!-- JOB TITLES ADD AND SEARCH -->
                    <div class="col-md-12 col-12 d-flex justify-content-between">
                        <div class="col-md-4 col-5">
                            <input type="text" placeholder="search by... job title" id="searchJobtitles"
                                class="form-control">
                        </div>
                        <div class="col-md-3 d-flex col-6 justify-content-end">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#addJobTitles" id="add_new">
                                <i class="fa fa-plus"></i> Add new Job Titles
                            </button>
                        </div>
                    </div>
                    <!-- ADD Job Titles  -->
                    <div class="modal fade" id="addJobTitles" tabindex="-1" aria-labelledby="addJobTitlesLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title text-white" id="createAccountsLabel">Add New Job Titles
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close" onclick="location.reload()"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row g-3" id="jobtitle-form">
                                        <div class="m-2">
                                            <label class="form-label">Job Title</label>
                                            <input required type="text" class="form-control" name="jobTitle">
                                        </div>
                                        <div class="m-2">
                                            <label class="form-label">Official Salary</label>
                                            <input required type="number" class="form-control" name="salary">
                                        </div>
                                        <div class="m-2">
                                            <label class="form-label">Department</label>
                                            <select name="department_id" class="form-select">
                                                <option disabled>Select Department</option>
                                                <?php
                                                    $stmt = $pdo->prepare("SELECT * FROM departments");
                                                    $stmt->execute();
                                                    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach($departments as $dept) :
                                                ?>
                                                <option value="<?= htmlspecialchars($dept['Department_id']) ?>">
                                                    <?= htmlspecialchars($dept['Department_name'] . " (" . $dept["Department_code"] . " )") ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <button type="submit" class="btn btn-danger px-5">
                                                <i class="bi bi-person-plus-fill me-1"></i> Add Job Title
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- edit job Titles and salary -->
                    <div class="modal fade" id="editJobTitlesModal" tabindex="-1"
                        aria-labelledby="editJobTitlesModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="update-jobInfo">
                                <div class="modal-content">
                                    <div class="modal-header bg-gradient-primary text-white">
                                        <h5 class="modal-title text-white" id="editJobTitlesModalLabel">Edit Job
                                            Information</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <input type="hidden" name="jobTitles_id" id="editUserIdEdit">

                                        <div class="mb-3">
                                            <label for="jobTitle" class="form-label">Job Title</label>
                                            <input type="text" class="form-control" id="jobTitle" value=""
                                                name="jobTitle">
                                        </div>

                                        <div class="mb-3">
                                            <label for="salary" class="form-label">Official Salary</label>
                                            <input type="text" class="form-control" id="salary" value="" name="salary">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Update Job Title</button>
                                        <button type="button" class="btn btn-dark"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- delete JOtTitles -->
                    <div class="modal fade" id="deleteJobModal" tabindex="-1" aria-labelledby="deleteJobModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="jobtitle-delete-form" class="modal-content">
                                <!-- <?php $csrf = $_SESSION["csrf_token"] ?? ''?>
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                <input type="hidden" name="jobTitle_auth" value="true">
                                <input type="hidden" name="job_auth_type" value="delete"> -->
                                <div class="modal-header bg-gradient-primary text-white">
                                    <h5 class="modal-title text-white" id="deleteJobModalLabel">Confirmation Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this job title?
                                    <input type="hidden" name="jobTitles_id" id="deleteJobTitleId">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- JOB TITLES TABLE -->
                    <div class="table-responsive table-body">
                        <table class="table table-bordered table-hover table-sm text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Job Title</th>
                                    <th>Salary</th>
                                    <th>Department</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" id="jobtitles" style="color: #666;">
                                <?php foreach($jobtitlesData as $job) : ?>
                                <tr>
                                    <th><?= $countsjob++ ?></th>
                                    <th><?= htmlspecialchars($job["jobTitle"]) ?></th>
                                    <th><?= htmlspecialchars($job["salary"]) ?></th>
                                    <th><?= htmlspecialchars($job["Department_name"]) ?></th>
                                    <th><?= htmlspecialchars($job["addAt"]) ?></th>
                                    <th>
                                        <button type="button" class="btn m-0 btn-sm btn-danger" onclick="edit_jobTitle(
                                                    <?= $job['jobTitles_id'] ?>,
                                                    '<?= addslashes($job['jobTitle']) ?>',
                                                    '<?= $job['salary'] ?>'
                                                )">
                                            <i class="fas fa-eye"></i> Edit
                                        </button>

                                        <button type="button" class="btn m-0 btn-sm btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#deleteJobModal"
                                            onclick="setDeletejobtTitleId(<?= $job['jobTitles_id'] ?>)">
                                            <i class="fas fa-eye"></i> Delete
                                        </button>
                                    </th>
                                </tr>
                                <?php endforeach ?>
                            </tbody>

                        </table>
                    </div>
                </div>

                <!-- Career Paths -->
                <div class="tab-pane fade" id="CareerPathsInfo" role="tabpanel">
                    <div class="col-md-12 col-12 d-flex justify-content-between mb-3">
                        <div class="col-md-4 col-12">
                            <input type="text" placeholder="search by... Employee name, ID and Job Title"
                                id="searchCareerPaths" class="form-control">
                        </div>
                    </div>
                    <!-- CAREER PATH HISTORY -->
                    <div class="modal fade" id="viewCareerPath" tabindex="-1" aria-labelledby="viewCareerPathLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title text-white" id="viewCareerPathLabel">Career Path History</h5>
                                    <button type="button" class="btn btn-info btn-sm m-0"
                                        id="print_history">print</button>
                                </div>
                                <div class="modal-body">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Manage Career Path -->
                    <div class="modal fade" id="manageCareerPath" tabindex="-1" aria-labelledby="manageCareerPathLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-gradient-primary text-white">
                                    <h5 class="modal-title text-white" id="manageCareerPathLabel">Manage Employee Career
                                        Path</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        onclick="location.reload()"></button>
                                </div>
                                <form method="post" action="../../authentication/hrAuth.php" class="d-inline">
                                    <div class="modal-body">
                                        <?php $csrf = $_SESSION["csrf_token"] ?? ''?>
                                        <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                        <input type="hidden" name="careerPath_auth" value="true">
                                        <input type="hidden" name="admin_id" value="<?= htmlspecialchars($admin_id) ?>">
                                        <input type="hidden" name="employee_id" id="editEmployeeId">
                                        <input type="hidden" value="" name="careerPath_auth_type"
                                            id="careerPath_auth_type_as_id">
                                        <input type="hidden" name="current_jobTitle_id" id="currentJobTitleId">

                                        <div class="mb-3">
                                            <label class="form-label">Current Job Title</label>
                                            <input type="text" class="form-control" name="currentJobTitle"
                                                id="currentJobTitle" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Current Salary</label>
                                            <input type="text" class="form-control" name="currentSalary"
                                                id="currentSalary" readonly>
                                        </div>
                                        <?php
                                            $stmt = $pdo->prepare("SELECT * FROM jobTitles");
                                            $stmt->execute();
                                            $jobtitles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        ?>
                                        <div class="mb-3">
                                            <label for="jobTitleSelect" class="form-label">New Job Title</label>
                                            <select class="form-select" id="jobTitleSelect" name="jobTitle" required>
                                                <option value="">Select Job Title</option>
                                                <?php foreach($jobtitles as $jb) : ?>
                                                <option value="<?= htmlspecialchars($jb["jobTitles_id"]) ?>">
                                                    <?= htmlspecialchars($jb["jobTitle"]) . " (P" . htmlspecialchars($jb["salary"]) . ")" ?>
                                                </option>
                                                <?php  endforeach ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">New Salary</label>
                                            <input type="text" class="form-control" id="newSalary" name="new_salary"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger" id="update">
                                            Update
                                        </button>

                                        <button type="submit" class="btn btn-danger" id="Promote">
                                            Promote
                                        </button>

                                        <button type="submit" class="btn btn-dark" id="Demote">
                                            Demote
                                        </button>
                                </form>

                                <button type="button" class="btn btn-dark" onclick="location.reload()"
                                    data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CAREER PATH TABLE -->
                <div class="table-responsive table-body">
                    <table class="table table-bordered table-hover table-sm text-center">
                        <thead class="table-light">
                            <tr style="color: #555;">
                                <th>#</th>
                                <th>Employee ID</th>
                                <th>Complete Name</th>
                                <th>Department</th>
                                <th>Job Title</th>
                                <th>Current Salary</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="careerPathEmployees" class="text-center" style="color: #666;"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?php if ( 
        isset($_GET['demote_employee']) || 
        isset($_GET['update_employee']) || 
        isset($_GET['delete_dept']) || 
        isset($_GET['add_dept']) || 
        isset($_GET['delete_job']) || 
        isset($_GET['promote_employee']) 
    ): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const messages = {
        demote_employee: {
            icon: 'success',
            title: 'Employee Career path demoted successfully!'
        },
        update_employee: {
            icon: 'success',
            title: 'Employee Career path Updated successfully!'
        },
        delete_dept: {
            icon: 'success',
            title: 'Department Deleted successfully!'
        },
        add_dept: {
            icon: 'success',
            title: 'Department Created successfully!'
        },
        delete_job: {
            icon: 'success',
            title: 'Jobtitle Deleted successfully!'
        },
        promote_employee: {
            icon: 'success',
            title: 'Employee Career path promoted successfully!!'
        }
    };

    for (const key in messages) {
        const value = new URLSearchParams(window.location.search).get(key);
        if (value) {
            Swal.fire({
                toast: true,
                icon: messages[key].icon,
                title: messages[key].title,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didClose: () => removeUrlParams([key])
            });
            break;
        }
    }

    function removeUrlParams(params) {
        const url = new URL(window.location);
        params.forEach(param => url.searchParams.delete(param));
        window.history.replaceState({}, document.title, url.toString());
    }
});
</script>
<?php endif; ?>
<script>
$(document).ready(function() {
    $('#update').ready(function(e) {
        const careerPath_auth_type_as_id = document.getElementById("careerPath_auth_type_as_id").value =
            'Update';
    });
    $('#Promote').on("click", function(e) {
        const careerPath_auth_type_as_id = document.getElementById("careerPath_auth_type_as_id").value =
            'Promote';
    });
    $('#Demote').on("click", function(e) {
        const careerPath_auth_type_as_id = document.getElementById("careerPath_auth_type_as_id").value =
            'Demote';
    });

});
</script>
<script>
// Replace your simpleSearch function with this version:
function simpleSearch(inputId, tbodyId, noResultText, colspanCount) {
    const input = document.getElementById(inputId);
    const tbody = document.getElementById(tbodyId); // Changed from getElementById to querySelector

    if (!input || !tbody) {
        console.error(`Element not found: inputId=${inputId}, tbodyId=${tbodyId}`);
        return;
    }

    input.addEventListener("input", function() {
        const term = this.value.toLowerCase().trim();
        const rows = tbody.getElementsByTagName("tr");
        let foundAny = false;

        // Remove old "no results"
        const oldMsg = document.getElementById("no-results-" + tbodyId);
        if (oldMsg) oldMsg.remove();

        for (let row of rows) {
            const cells = row.getElementsByTagName("th"); // Your tables use <th> in tbody
            if (cells.length === 0) continue;

            // Reset highlighting
            for (let cell of cells) {
                cell.innerHTML = cell.textContent; // Reset HTML
            }

            if (term === "") {
                row.style.display = "";
                continue;
            }

            let rowMatch = false;

            for (let cell of cells) {
                const text = cell.textContent.toLowerCase();

                if (text.includes(term)) {
                    rowMatch = true;
                    cell.innerHTML = cell.textContent.replace(
                        new RegExp(term, "gi"),
                        m => `<span class="search-highlight">${m}</span>`
                    );
                }
            }

            row.style.display = rowMatch ? "" : "none";
            if (rowMatch) foundAny = true;
        }

        // Add "no results" row
        if (!foundAny && term !== "") {
            const noRow = document.createElement("tr");
            noRow.id = "no-results-" + tbodyId;
            noRow.innerHTML =
                `<td colspan="${colspanCount}" class="text-center text-muted py-3">${noResultText}</td>`;
            tbody.appendChild(noRow);
        }
    });
}

// Then call them as before:
simpleSearch("searchDepartments", "departments",
    "No departments found matching your search", 5);

simpleSearch("searchJobtitles", "jobtitles",
    "No job titles found matching your search", 5);
</script>

<script>
// Search functionality for Career Paths
document.addEventListener('DOMContentLoaded', function() {
    const searchCareerPaths = document.getElementById('searchCareerPaths');

    searchCareerPaths.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase().trim();

        // Reset if search is empty
        if (searchTerm === '') {
            resetCareerPathsSearch();
            return;
        }

        // Search and highlight in career paths table
        searchAndHighlightTable('careerPathEmployees', searchTerm);
    });

    function searchAndHighlightTable(tableId, searchTerm) {
        const table = document.getElementById(tableId);
        if (!table) return;

        const rows = table.getElementsByTagName('tr');
        let hasVisibleRows = false;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;

            if (cells.length === 0) continue;

            // Reset cell contents first
            resetRowHighlights(row);

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];

                // Skip action cells
                if (cell.querySelector('button') || cell.querySelector('a')) {
                    continue;
                }

                const originalText = cell.textContent;
                const lowerText = originalText.toLowerCase();

                if (lowerText.includes(searchTerm)) {
                    found = true;
                    hasVisibleRows = true;

                    // Highlight the matched text
                    const highlightedText = originalText.replace(
                        new RegExp(searchTerm, 'gi'),
                        match => `<span class="search-highlight">${match}</span>`
                    );
                    cell.innerHTML = highlightedText;
                }
            }

            row.style.display = found ? '' : 'none';
        }

        // Show "no results" message if needed
        showNoResultsMessage(tableId, hasVisibleRows);
    }

    function resetRowHighlights(row) {
        const cells = row.getElementsByTagName('td');
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            if (cell.querySelector('.search-highlight')) {
                cell.innerHTML = cell.textContent; // Remove HTML tags, keep text
            }
        }
    }

    function resetCareerPathsSearch() {
        const table = document.getElementById('careerPathEmployees');
        if (!table) return;

        const rows = table.getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            resetRowHighlights(row);
            row.style.display = '';
        }
        hideNoResultsMessage('careerPathEmployees');
    }

    function showNoResultsMessage(tableId, hasVisibleRows) {
        let noResultsRow = document.getElementById(`no-results-${tableId}`);

        if (!hasVisibleRows && !noResultsRow) {
            const table = document.getElementById(tableId);
            noResultsRow = document.createElement('tr');
            noResultsRow.id = `no-results-${tableId}`;
            noResultsRow.innerHTML =
                `<td colspan="7" class="text-center text-muted py-3">No employees found matching your search</td>`;
            table.appendChild(noResultsRow);
        } else if (hasVisibleRows && noResultsRow) {
            noResultsRow.remove();
        }
    }

    function hideNoResultsMessage(tableId) {
        const noResultsRow = document.getElementById(`no-results-${tableId}`);
        if (noResultsRow) {
            noResultsRow.remove();
        }
    }
});

// Add CSS for highlighting (only once)
if (!document.querySelector('#search-highlight-style')) {
    const style = document.createElement('style');
    style.id = 'search-highlight-style';
    style.textContent = `
        .search-highlight {
            background-color: #ffeb3b;
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: bold;
            color: #333;
        }
    `;
    document.head.appendChild(style);
}
</script>
<script>
// Print functionality for career path history
document.getElementById('print_history').addEventListener('click', function() {
    // Get modal content
    const modal = document.getElementById('viewCareerPath');
    const modalContent = modal.querySelector('.modal-content');
    const modalBody = modal.querySelector('.modal-body');

    // Check if there's content to print
    if (!modalBody || modalBody.innerHTML.includes('spinner-border')) {
        alert('Please wait for the data to load before printing.');
        return;
    }

    // Create a new window for printing
    const printWindow = window.open('', '_blank', 'width=800,height=600');

    // Get employee info if available
    let employeeInfo = '';
    const employeeDetails = modalBody.querySelector('.card-body');
    if (employeeDetails) {
        employeeInfo = employeeDetails.innerHTML;
    }

    // Get history table if available
    let historyTable = '';
    const table = modalBody.querySelector('table');
    if (table) {
        const tableClone = table.cloneNode(true);

        // Add print-specific classes
        tableClone.classList.add('table-print');
        tableClone.style.width = '100%';
        tableClone.style.borderCollapse = 'collapse';

        // Style table headers
        const thElements = tableClone.querySelectorAll('th');
        thElements.forEach(th => {
            th.style.backgroundColor = '#f8f9fa';
            th.style.border = '1px solid #dee2e6';
            th.style.padding = '8px';
            th.style.textAlign = 'left';
        });

        // Style table cells
        const tdElements = tableClone.querySelectorAll('td');
        tdElements.forEach(td => {
            td.style.border = '1px solid #dee2e6';
            td.style.padding = '8px';
        });

        // Style table rows
        const trElements = tableClone.querySelectorAll('tr');
        trElements.forEach((tr, index) => {
            if (index > 0) { // Skip header row
                tr.style.borderTop = '1px solid #dee2e6';
            }
        });

        historyTable = tableClone.outerHTML;
    }

    // Get current date for print header
    const now = new Date();
    const printDate = now.toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });

    // Write print content
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Career Path History - ${printDate}</title>
            <style>
                @media print {
                    body { 
                        font-family: Arial, sans-serif; 
                        margin: 20px; 
                        color: #333;
                    }
                    .print-header {
                        text-align: center;
                        border-bottom: 2px solid #dc3545;
                        padding-bottom: 15px;
                        margin-bottom: 20px;
                    }
                    .print-header h1 {
                        color: #dc3545;
                        margin-bottom: 5px;
                    }
                    .print-header .print-date {
                        color: #666;
                        font-size: 14px;
                    }
                    .employee-info {
                        background-color: #f8f9fa;
                        border: 1px solid #dee2e6;
                        border-radius: 4px;
                        padding: 15px;
                        margin-bottom: 20px;
                    }
                    .table-print {
                        width: 100%;
                        margin-bottom: 20px;
                    }
                    .table-print th {
                        background-color: #f8f9fa;
                        font-weight: bold;
                    }
                    .table-print td, .table-print th {
                        border: 1px solid #dee2e6;
                        padding: 8px;
                    }
                    .no-data {
                        text-align: center;
                        color: #666;
                        font-style: italic;
                        padding: 20px;
                    }
                    .print-footer {
                        margin-top: 30px;
                        padding-top: 10px;
                        border-top: 1px solid #dee2e6;
                        font-size: 12px;
                        color: #666;
                        text-align: center;
                    }
                    @page {
                        size: A4 landscape;
                        margin: 15mm;
                    }
                }
                @media screen {
                    body { 
                        font-family: Arial, sans-serif; 
                        margin: 20px; 
                        color: #333;
                    }
                    .print-header {
                        text-align: center;
                        border-bottom: 2px solid #dc3545;
                        padding-bottom: 15px;
                        margin-bottom: 20px;
                    }
                    .print-header h1 {
                        color: #dc3545;
                        margin-bottom: 5px;
                    }
                    .print-header .print-date {
                        color: #666;
                        font-size: 14px;
                    }
                    .employee-info {
                        background-color: #f8f9fa;
                        border: 1px solid #dee2e6;
                        border-radius: 4px;
                        padding: 15px;
                        margin-bottom: 20px;
                    }
                    .table-print {
                        width: 100%;
                        margin-bottom: 20px;
                        border-collapse: collapse;
                    }
                    .table-print th {
                        background-color: #f8f9fa;
                        font-weight: bold;
                    }
                    .table-print td, .table-print th {
                        border: 1px solid #dee2e6;
                        padding: 8px;
                    }
                    .no-data {
                        text-align: center;
                        color: #666;
                        font-style: italic;
                        padding: 20px;
                    }
                    .print-footer {
                        margin-top: 30px;
                        padding-top: 10px;
                        border-top: 1px solid #dee2e6;
                        font-size: 12px;
                        color: #666;
                        text-align: center;
                    }
                }
            </style>
        </head>
        <body>
            <div class="print-header">
                <h1>Career Path History</h1>
                <div class="print-date">Printed: ${printDate}</div>
            </div>
            
            ${employeeInfo ? `<div class="employee-info">${employeeInfo}</div>` : ''}
            
            ${historyTable ? historyTable : '<div class="no-data">No career history data available for printing</div>'}
            
            <div class="print-footer">
                <p>Confidential - For internal use only</p>
                <p>Generated by Career Path Management System</p>
            </div>
            
            <script>
                // Auto print when page loads
                window.onload = function() {
                    setTimeout(function() {
                        window.print();
                        // Close window after printing or if user cancels
                        setTimeout(function() {
                            window.close();
                        }, 1000);
                    }, 500);
                };
                
                // Also allow manual print
                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                        e.preventDefault();
                        window.print();
                    }
                });
            <\/script>
        </body>
        </html>
    `);

    printWindow.document.close();
});

// Alternative: Simple print function for the modal content only
function printCareerPathHistory() {
    const modalContent = document.querySelector('#viewCareerPath .modal-content');
    if (!modalContent) return;

    // Store original display settings
    const originalDisplay = modalContent.style.display;

    // Show modal content for printing
    modalContent.style.display = 'block';

    // Print the modal content
    window.print();

    // Restore original display
    modalContent.style.display = originalDisplay;
}
</script>