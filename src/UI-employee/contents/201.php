<link rel="stylesheet" href="../../assets/css/files.css">
<?php
// Get employee data
$stmtEmployee = $pdo->prepare("SELECT firstname, lastname FROM employee_data WHERE employee_id = :employee_id");
$stmtEmployee->execute(['employee_id' => $employee_id]);
$dataEmployee = $stmtEmployee->fetch(PDO::FETCH_ASSOC);

// Define file types
$file_types = ['communication', 'certifications', 'training_certificates', 'license_eligibility',
    'academic_credentials', 'preScreening_requirements', 'medical_certificates'];
$file_data = [];

// Get all files data in one query
$stmt = $pdo->prepare("SELECT * FROM files WHERE employee_id = :employee_id");
$stmt->execute(['employee_id' => $employee_id]);
$all_files = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Organize files by type
foreach ($all_files as $file) {
    $file_data[$file['type']][] = $file;
}

?>

<section>
    <div class="row mb-4">
        <div class="col-md-8">
            <h4 class="text-dark">
                <i class="fa-solid fa-folder-open me-2"></i>
                <?= htmlspecialchars($dataEmployee["firstname"]) . ' ' . htmlspecialchars($dataEmployee["lastname"]) ?>
                - 201 FILES
            </h4>
            <small class="text-muted">Manage employee 201 files - Create, update and view documents</small>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-success" data-bs-toggle="modal" id="getID" data-bs-target="#create201"
                data-id="<?= htmlspecialchars($employee_id) ?>">
                <i class="fa-solid fa-plus me-2"></i>Add New File
            </button>
        </div>
    </div>

    <!-- Add File Modal -->
    <div class="modal fade" id="create201" tabindex="-1" aria-labelledby="create201Label" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="create201Label">Add employee 201 file</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        onclick="location.reload()"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="file-form" method="post" enctype="multipart/form-data">
                        <div class="mx-2">
                            <label class="form-label">Title</label>
                            <input required type="text" class="form-control" name="file_title" placeholder="File title">
                        </div>
                        <div class="mx-2">
                            <label class="form-label">201 type</label>
                            <select required name="type" id="" class="form-select">
                                <option value="">Select Type</option>
                                <option value="communication">Communication</option>
                                <option value="certifications">Certifications</option>
                                <option value="training_certificates">Training Certificates</option>
                                <option value="license_eligibility">License Eligibility</option>
                                <option value="academic_credentials">Academic Credentials</option>
                                <option value="preScreening_requirements">Pre-screening Requirements</option>
                                <option value="medical_certificates">Medical Certificates</option>

                            </select>
                        </div>
                        <div class="mx-2">
                            <label class="form-label">Employee file</label>
                            <input required type="file" name="201file" class="form-control">
                            <input type="hidden" name="employee_id" id="employee_id">
                        </div>

                        <!-- Form Submission -->
                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="bi bi-person-plus-fill me-1"></i> Submit File
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- File Categories Navigation -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fa-solid fa-folders me-2"></i>File Categories</h6>
        </div>
        <div class="card-body p-3">
            <ul class="nav nav-tabs justify-content-start" id="fileTabs" role="tablist">
                <?php foreach ($file_types as $index => $type): 
                    $file_count = isset($file_data[$type]) ? count($file_data[$type]) : 0;
                ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link m-1 <?= $index === 0 ? 'active' : '' ?>" id="tab-<?= $type ?>"
                        data-bs-toggle="tab" data-bs-target="#pane-<?= $type ?>" type="button" role="tab"
                        aria-controls="pane-<?= $type ?>" aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                        <i class="fa-solid fa-folder me-2"></i><?= $type ?>
                        <?php if ($file_count > 0): ?>
                        <span class="badge-file-count"><?= $file_count ?></span>
                        <?php endif; ?>
                    </button>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="card-body pt-0">
            <div class="tab-content mt-4" id="fileTabContent">
                <?php 
                $titles = [
                    'communication' => 'Communication',
                    'certifications' => 'Certifications',
                    'training_certificates' => 'Training Certificates',
                    'license_eligibility' => 'License Eligibility',
                    'academic_credentials' => 'Academic Credentials',
                    'preScreening_requirements' => 'Pre-screening Requirements',
                    'medical_certificates' => 'Medical Certificates'
                ];
                
                foreach ($file_types as $index => $type): 
                    $files_in_category = isset($file_data[$type]) ? $file_data[$type] : [];
                ?>
                <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="pane-<?= $type ?>"
                    role="tabpanel" aria-labelledby="tab-<?= $type ?>" tabindex="0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-dark">
                            <i class="fa-solid fa-folder me-2"></i>
                            <?= $titles[$type] ?>
                        </h5>
                        <span class="badge bg-secondary"><?= count($files_in_category) ?> file(s)</span>
                    </div>

                    <?php if (!empty($files_in_category)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered file-table">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="40%">File Title</th>
                                    <th width="25%">Date Added</th>
                                    <th width="30%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counts = 1; ?>
                                <?php foreach ($files_in_category as $files): ?>
                                <tr>
                                    <td class="text-center"><?= $counts++ ?></td>
                                    <td>
                                        <i class="fa-solid fa-file me-2 text-muted"></i>
                                        <?= htmlspecialchars($files["file_title"]) ?>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-calendar me-2 text-muted"></i>
                                        <?= date("M d, Y h:i A", strtotime($files["added_at"])) ?>
                                    </td>
                                    <td class="file-actions">
                                        <a href="../../authentication/uploads/<?= urlencode($files["201file"]) ?>"
                                            target="_blank" class="btn-outline-info btn">
                                            Preview PDF
                                        </a>
                                        <button class="btn btn-outline-dark btn-sm downloadBtn"
                                            data-file="<?= '../../authentication/uploads/' . $files["201file"] ?>"
                                            title="Download File">
                                            <i class="fa-solid fa-download me-1"></i>Download
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm delete-file" data-bs-toggle="modal"
                                            data-bs-target="#deleteFile"
                                            data-id="<?= htmlspecialchars($files["files_id"]) ?>" title="Delete File">
                                            <i class="fa-solid fa-trash me-1"></i>Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fa-solid fa-folder-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Files Found</h5>
                        <p class="text-muted">No files have been added to this category yet.</p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteFile" tabindex="-1" aria-labelledby="deleteFileLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form id="file-delete-form" class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white">
                    <i class="fa-solid fa-trash me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fa-solid fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                <h6>Are you sure you want to delete this file?</h6>
                <p class="text-muted small">This action cannot be undone.</p>
                <input type="hidden" name="files_id" id="files_id">
            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-danger">
                    <i class="fa-solid fa-trash me-2"></i>Yes, Delete
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa-solid fa-times me-2"></i>Cancel
                </button>
            </div>
        </form>
    </div>
</div>
<script src="../../assets/js/hr_js/files.js" defer></script>