<main>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0"><i class="fa fa-comments text-dakr me-2"></i>System Announcement</h4>
            <small class="text-muted">Share your thoughts, suggestions, and company matters</small>
        </div>
        <?php if($getEmployeeData["employee_type"] == 'head') : ?>
            <button class="btn btn-danger btn-sm" id="newFeedbackBtn" data-bs-target="#create_announcemenet"
                data-bs-toggle="modal">
                <i class="fa fa-plus"></i> Create Announcement
            </button>
        <?php endif; ?>
    </div>
    <div class="card">
        <!-- NAVIAGATIONS OF TABS -->
        <div class="card-body col-md-12 col-12 d-flex justify-content-between flex-wrap">
            <ul class="nav nav-tabs col-md-8 col-12" id="messagesTabs" role="tablist">
                <li class="nav-item col-md-4" role="presentation">
                    <button class="nav-link w-100 h-100 active" id="approved-tab" data-bs-toggle="tab"
                        data-bs-target="#privateMessage" type="button" role="tab" aria-controls="privateMessage"
                        aria-selected="true">
                        <i class="fa-solid fa-user-tie me-2"></i>Private Message
                    </button>
                </li>
                <li class="nav-item col-md-4" role="presentation">
                    <button class="nav-link w-100 h-100" id="pending-tab" data-bs-toggle="tab"
                        data-bs-target="#publicMessage" type="button" role="tab" aria-controls="publicMessage"
                        aria-selected="false">
                        <i class="fa-solid fa-user-plus me-2"></i>Public Message
                    </button>
                </li>
                <li class="nav-item col-md-4" role="presentation">
                    <button class="nav-link w-100 h-100" id="rejected-tab" data-bs-toggle="tab"
                        data-bs-target="#sentMessage" type="button" role="tab" aria-controls="sentMessage"
                        aria-selected="false">
                        <i class="fa-solid fa-user-minus me-2"></i>Message sent
                    </button>
                </li>
            </ul>
        </div>

        <!-- CONTENTS -->
        <div class="card-body pt-0">
            <div class="tab-content" id="employeesTabContent">
                <!-- Private Message -->
                <div class="tab-pane fade show active row" id="privateMessage" role="tabpanel"
                    aria-labelledby="approved-tab" tabindex="0">
                    <div class="col-md-12 d-flex flex-column">
                        <?php 
                            if($getPrivateMessages) :
                                foreach($getPrivateMessages as $private) : ?>
                        <div class="card col-md-12 p-2 m-1">
                            <div class="col-md-12 px-2">
                                <label class="form-label w-100 text-end">Announced At: <strong
                                        class="fs-6"><?= htmlspecialchars(date('M d Y', strtotime($private["announce_at"]))) ?></strong></label>
                            </div>
                            <div class="col-md-12 px-2 mb-2">
                                <label class="form-label">ABOUT </label>
                                <strong class="form-control" readonly><?= $private["announcement_name"] ?></strong>
                            </div>
                            <div class="col-md-12 px-2 mb-2">
                                <label class="form-label">DESCRIPTION</label>
                                <textarea class="form-control" readonly><?= $private["description"] ?></textarea>
                            </div>
                            <?php if($private["file"]) : ?>
                            <div class="px-2">
                                <label class="form-label">NOTE: you can preview and download this file with the button
                                    below</label>
                                <p class="form-control" readonly><?= $private["file"] ?></p>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-12 pe-2 d-flex gap-2 justify-content-end">
                                <?php if($private["file"]) : ?>
                                <a href="../../authentication/uploads/<?= urlencode($private["file"]) ?>"
                                    target="_blank" class="btn btn-sm btn-info m-0">
                                    <i class="fa-solid fa-eye"></i>
                                    preview
                                </a>
                                <button class="btn btn-sm btn-dark m-0 downloadBtn"><i class="fa-solid fa-download"
                                        data-file="<?= '../../authentication/uploads/' . $private["file"] ?>"
                                        title="Download File"></i>
                                    download</button>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-danger m-0" id="delete-announcement" data-bs-toggle="modal"
                                    data-bs-target="#deleteFile" data-id="<?= htmlspecialchars($private["announcement_id"]) ?>"
                                    title="Delete File">
                                    <i class="fa-solid fa-trash-can"></i>
                                    delete
                                </button>

                            </div>
                        </div>
                        <?php   
                                endforeach;
                            else : ?>
                        <strong class="w-100 text-center txt-dark">No Private Messages Recieve</strong>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Public announcement -->
                <div class="tab-pane fade" id="publicMessage" role="tabpanel" aria-labelledby="pending-tab"
                    tabindex="0">
                    <div class="col-md-12 d-flex flex-column">
                        <?php 
                            if($getPublicMessages) :
                                foreach($getPublicMessages as $public) : ?>
                        <div class="card col-md-12 p-2 m-1">
                            <div class="col-md-12 px-2">
                                <label class="form-label w-100 text-end">Announced At: <strong
                                        class="fs-6"><?= htmlspecialchars(date('M d Y', strtotime($public["announce_at"]))) ?></strong></label>
                            </div>
                            <div class="col-md-12 px-2 mb-2">
                                <label class="form-label">ABOUT </label>
                                <strong class="form-control" readonly><?= $public["announcement_name"] ?></strong>
                            </div>
                            <div class="col-md-12 px-2 mb-2">
                                <label class="form-label">DESCRIPTION</label>
                                <textarea class="form-control" readonly><?= $public["description"] ?></textarea>
                            </div>
                            <?php if($public["file"]) : ?>
                            <div class="px-2">
                                <label class="form-label">NOTE: you can preview and download this file with the button
                                    below</label>
                                <p class="form-control" readonly><?= $public["file"] ?></p>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-12 pe-2 d-flex gap-2 justify-content-end">
                                <?php if($public["file"]) : ?>
                                <a href="../../authentication/uploads/<?= urlencode($public["file"]) ?>" target="_blank"
                                    class="btn btn-sm btn-info m-0">
                                    <i class="fa-solid fa-eye"></i>
                                    preview
                                </a>
                                <button class="btn btn-sm btn-dark m-0 downloadBtn"><i class="fa-solid fa-download"
                                        data-file="<?= '../../authentication/uploads/' . $public["file"] ?>"
                                        title="Download File"></i>
                                    download</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php   
                                endforeach;
                            else : ?>
                        <strong class="w-100 text-center txt-dark">No Private Messages Recieve</strong>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- messege sent -->
                <div class="tab-pane fade" id="sentMessage" role="tabpanel" aria-labelledby="rejected-tab" tabindex="0">
                    <div class="col-md-12 d-flex flex-column">
                        <?php 
                            if($getSentMessages) :
                                foreach($getSentMessages as $sent) : ?>
                        <div class="card col-md-12 p-2 m-1">
                            <div class="col-md-12 px-2">
                                <label class="form-label w-100 text-end">Announced At: <strong
                                        class="fs-6"><?= htmlspecialchars(date('M d Y', strtotime($sent["announce_at"]))) ?></strong></label>
                            </div>
                            <div class="col-md-12 px-2 mb-2">
                                <label class="form-label">ABOUT </label>
                                <strong class="form-control" readonly><?= $sent["announcement_name"] ?></strong>
                            </div>
                            <div class="col-md-12 px-2 mb-2">
                                <label class="form-label">DESCRIPTION</label>
                                <textarea class="form-control" readonly><?= $sent["description"] ?></textarea>
                            </div>
                            <?php if($sent["file"]) : ?>
                            <div class="px-2">
                                <label class="form-label">NOTE: you can preview and download this file with the button
                                    below</label>
                                <p class="form-control" readonly><?= $sent["file"] ?></p>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-12 pe-2 d-flex gap-2 justify-content-end">
                                <?php if($sent["file"]) : ?>
                                <a href="../../authentication/uploads/<?= urlencode($sent["file"]) ?>" target="_blank"
                                    class="btn btn-sm btn-info m-0">
                                    <i class="fa-solid fa-eye"></i>
                                    preview
                                </a>
                                <button class="btn btn-sm btn-dark m-0 downloadBtn"><i class="fa-solid fa-download"
                                        data-file="<?= '../../authentication/uploads/' . $sent["file"] ?>"
                                        title="Download File"></i>
                                    download</button>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-danger m-0"
                                    id="delete-announcement" data-bs-toggle="modal" data-bs-target="#deleteFile"
                                    data-id="<?= htmlspecialchars($sent["announcement_id"]) ?>"
                                    title="Delete File"><i class=" fa-solid fa-trash-can"></i>
                                    delete</button>
                            </div>
                        </div>
                        <?php   
                                endforeach;
                            else : ?>
                        <strong class="w-100 text-center txt-dark">No Private Messages Recieve</strong>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal section ================================================= -->
<div class="modal fade" id="create_announcemenet" tabindex="-1" aria-labelledby="create_announcemenetLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="create_announcemenetLabel">Create an announcement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    onclick="location.reload()"></button>
            </div>
            <div class="modal-body">
                <form id="announcement-form" enctype="multipart/form-data">
                    <input type="hidden" name="announced_by" value="<?= $hr_id ?>">
                    <div class="mx-2">
                        <label class="form-label">Sent to</label>
                        <select name="user_id" id="" class="form-select">
                            <option value="" disabled>Announce it to.....</option>
                            <option value="2105">Public Announcement</option>
                            <?php foreach($getUsersForAnnouncement as $heads) : ?>
                            <option value="<?= htmlspecialchars($heads["user_id"]) ?>">
                                <?= htmlspecialchars($heads["lastname"] . ' ' . substr($heads["middlename"], 0, 1) . '. ' . $heads["lastname"]) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mx-2">
                        <label class="form-label">Title</label>
                        <input type="text" name="announcement_name" class="form-control">
                    </div>
                    <div class="mx-2">
                        <label class="form-label">File <span>(optional)</span></label>
                        <input type="file" name="file_name" class="form-control">
                    </div>
                    <div class="mx-2">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="" placeholder="" class="form-control"></textarea>
                    </div>
                    <div class="mx-2 mt-1">
                        <p class="text-dark">Note: The file name cannot have spaces, Rename it if possible</p>
                    </div>
                    <div class="modal-footer m-0 p-0 mt-2">
                        <button class="btn btn-danger m-0 mt-2" type="submit">confirm</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteFile" tabindex="-1" aria-labelledby="deleteFileLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form id="announcement-delete-form" class="modal-content">
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
                <input type="hidden" name="announcement_id" id="announcement_id">
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
<script src="../../assets/js/hr_js/admin/announcement.js"></script>