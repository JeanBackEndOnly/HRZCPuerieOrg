<?php
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
                            class="fa-solid me-2 fa-user-doctor"></i>Designation</a>
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
                                <?php foreach($getDedpartments as $dept) : ?>
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
                                            <i class="fa-solid fa-trash-can"></i> Delete
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
                                                    foreach($getDedpartments as $dept) :
                                                ?>
                                                <option value="<?= $dept["Department_id"] ?>">
                                                    <?= htmlspecialchars($dept["Department_name"] . ' (' . $dept["Department_code"] . ')') ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <button type="submit" class="btn btn-danger px-5">
                                                <i class="bi bi-person-plus-fill me-1"></i> Add Unit/Section
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
                                                <?php foreach($getDedpartments as $dept) : ?>
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
                                    if($getUnit){ ?>
                                    <?php foreach($getUnit as $uniSec) : ?>
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
                                                id="GetDeleteIdFromUniitSection">
                                                <i class="fa-solid fa-trash-can"></i> Delete
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
                                <i class="fa fa-plus"></i> Add new Designation
                            </button>
                        </div>
                    </div>
                    <!-- ADD Job Titles  -->
                    <div class="modal fade" id="addJobTitles" tabindex="-1" aria-labelledby="addJobTitlesLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title text-white" id="createAccountsLabel">Add New Desgination
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close" onclick="location.reload()"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row g-3" id="jobtitle-form">
                                        <div class="m-2">
                                            <label class="form-label">Designation</label>
                                            <input required type="text" class="form-control" name="jobTitle">
                                        </div>
                                        <div class="m-2">
                                            <label class="form-label">Designation Code</label>
                                            <input required type="text" class="form-control" name="jobTitle_code">
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
                                                    $getDedpartments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach($getDedpartments as $dept) :
                                                ?>
                                                <option value="<?= htmlspecialchars($dept['Department_id']) ?>">
                                                    <?= htmlspecialchars($dept['Department_name'] . " (" . $dept["Department_code"] . " )") ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <button type="submit" class="btn btn-danger px-5">
                                                <i class="bi bi-person-plus-fill me-1"></i> Add Designation
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
                                            <label for="jobTitle" class="form-label">Designation</label>
                                            <input type="text" class="form-control" id="jobTitle" value=""
                                                name="jobTitle">
                                        </div>
                                        <div class="mb-3">
                                            <label for="jobTitle_code" class="form-label">Designation Code</label>
                                            <input type="text" class="form-control" id="jobTitle_code" value=""
                                                name="jobTitle_code">
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
                                    <th>Position</th>
                                    <th>Position Code</th>
                                    <th>Salary</th>
                                    <th>Department</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" id="jobtitles" style="color: #666;">
                                <?php foreach($getDesignations as $job) : ?>
                                <tr>
                                    <th><?= $countsjob++ ?></th>
                                    <th><?= htmlspecialchars($job["jobTitle"]) ?></th>
                                    <th><?= htmlspecialchars($job["jobTitle_code"]) ?></th>
                                    <th><?= htmlspecialchars($job["salary"]) ?></th>
                                    <th><?= htmlspecialchars($job["Department_name"]) ?></th>
                                    <th><?= htmlspecialchars($job["addAt"]) ?></th>
                                    <th>
                                        <button type="button" class="btn m-0 btn-sm btn-danger" onclick="edit_jobTitle(
                                                    <?= $job['jobTitles_id'] ?>,
                                                    '<?= addslashes($job['jobTitle']) ?>',
                                                    '<?= addslashes($job['jobTitle_code']) ?>',
                                                    '<?= $job['salary'] ?>'
                                                )">
                                            <i class="fas fa-eye"></i> Edit
                                        </button>

                                        <button type="button" class="btn m-0 btn-sm btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#deleteJobModal"
                                            onclick="setDeletejobtTitleId(<?= $job['jobTitles_id'] ?>)">
                                            <i class="fa-solid fa-trash-can"></i> Delete
                                        </button>
                                    </th>
                                </tr>
                                <?php endforeach ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<script src="../../assets/js/hr_js/admin/dep_job.js"></script>