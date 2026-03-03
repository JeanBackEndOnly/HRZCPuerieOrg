<main>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0"><i class="fa fa-comments text-dakr me-2"></i>System Announcement</h4>
            <small class="text-muted">Share your thoughts, suggestions, and company matters</small>
        </div>
        <button class="btn btn-danger btn-sm" id="newFeedbackBtn"
        data-bs-target="#create_announcemenet"
        data-bs-toggle="modal">
            <i class="fa fa-plus"></i> Create Announcement
        </button>
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
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered file-table">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">Title</th>
                                    <th width="50%">Description</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                        <?php if($getPrivateMessages) { 
                            $countsPrivate = 1;
                            foreach($getPrivateMessages as $private) :
                            ?>
                            <tr>
                                    <td class="text-center"><?= $countsPrivate++ ?></td>
                                    <td>
                                        <?= htmlspecialchars($private["announcement_name"]) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($private["description"]) ?>
                                    </td>
                                    <td class="file-actions">
                                        <?php if($private["file"]){ ?>
                                            <a href="../../authentication/uploads/<?= urlencode($private["file"]) ?>"
                                                target="_blank" class="btn-info btn">
                                                <i class="fa-solid fa-eye"></i> Preview PDF
                                            </a>
                                        <?php } ?>
                                        <?php if($private["file"]){ ?>
                                            <button class="btn btn-dark btn-sm downloadBtn"
                                                data-file="<?= '../../authentication/uploads/' . $private["file"] ?>"
                                                title="Download File">
                                                <i class="fa-solid fa-download me-1"></i>Download
                                            </button>
                                        <?php } ?>
                                        <button class="btn btn-danger btn-sm" id="delete-file"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteFile"
                                            data-id="<?= htmlspecialchars($private["announcement_id"]) ?>" title="Delete File"
                                        >
                                            <i class="fa-solid fa-trash me-1"></i>Delete
                                        </button>
                                    </td>
                                </tr>
                        <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                           <?php }else{ ?>
                            <strong class="w-100 text-center m-1">No Messages Recieve</strong>
                        <?php } ?>
                </div>

                <!-- Public announcement -->
                <div class="tab-pane fade" id="publicMessage" role="tabpanel" aria-labelledby="pending-tab"
                    tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered file-table">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">Title</th>
                                    <th width="50%">Description</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                        <?php if($getPublicMessages) { 
                            $countspublic = 1;
                            foreach($getPublicMessages as $public) :
                            ?>
                            <tr>
                                    <td class="text-center"><?= $countspublic++ ?></td>
                                    <td>
                                        <?= htmlspecialchars($public["announcement_name"]) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($public["description"]) ?>
                                    </td>
                                    <td class="file-actions">
                                        <?php if($public["file"]){ ?>
                                            <a href="../../authentication/uploads/<?= urlencode($public["file"]) ?>"
                                                target="_blank" class="btn-info btn">
                                                <i class="fa-solid fa-eye"></i> Preview PDF
                                            </a>
                                        <?php } ?>
                                        <?php if($public["file"]){ ?>
                                            <button class="btn btn-dark btn-sm downloadBtn"
                                                data-file="<?= '../../authentication/uploads/' . $public["file"] ?>"
                                                title="Download File">
                                                <i class="fa-solid fa-download me-1"></i>Download
                                            </button>
                                        <?php } ?>
                                        <button class="btn btn-danger btn-sm" id="delete-file"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteFile"
                                            data-id="<?= htmlspecialchars($public["announcement_id"]) ?>" title="Delete File"
                                        >
                                            <i class="fa-solid fa-trash me-1"></i>Delete
                                        </button>
                                    </td>
                                </tr>
                        <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                     }else{ ?>
                        <strong class="w-100 text-center m-1">No Public Messages</strong>
                    <?php } ?>
                </div>

                <!-- messege sent -->
                <div class="tab-pane fade" id="sentMessage" role="tabpanel" aria-labelledby="rejected-tab"
                    tabindex="0">
                     <div class="table-responsive">
                        <table class="table table-hover table-bordered file-table">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">Title</th>
                                    <th width="50%">Description</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                        <?php if($getSentMessages) { 
                            $countssent = 1;
                            foreach($getSentMessages as $sent) :
                            ?>
                            <tr>
                                    <td class="text-center"><?= $countssent++ ?></td>
                                    <td>
                                        <?= htmlspecialchars($sent["announcement_name"]) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($sent["description"]) ?>
                                    </td>
                                    <td class="file-actions">
                                        <?php if($sent["file"]){ ?>
                                            <a href="../../authentication/uploads/<?= urlencode($sent["file"]) ?>"
                                                target="_blank" class="btn-info btn">
                                                <i class="fa-solid fa-eye"></i> Preview PDF
                                            </a>
                                        <?php } ?>
                                        <?php if($sent["file"]){ ?>
                                            <button class="btn btn-dark btn-sm downloadBtn"
                                                data-file="<?= '../../authentication/uploads/' . $sent["file"] ?>"
                                                title="Download File">
                                                <i class="fa-solid fa-download me-1"></i>Download
                                            </button>
                                        <?php } ?>
                                        <button class="btn btn-danger btn-sm" id="delete-file"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteFile"
                                            data-id="<?= htmlspecialchars($sent["announcement_id"]) ?>" title="Delete File"
                                        >
                                            <i class="fa-solid fa-trash me-1"></i>Delete
                                        </button>
                                    </td>
                                </tr>
                        <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    }else{ ?>
                        <strong class="w-100 text-center m-1">No Message Sent</strong>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal section ================================================= -->
 <div class="modal fade" id="create_announcemenet" tabindex="-1" aria-labelledby="create_announcemenetLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="create_announcemenetLabel">Create an announcement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    onclick="location.reload()"></button>
            </div>
            <div class="modal-body">
                <form id="announcement-form" enctype="multipart/form-data">
                    <input type="hidden" name="announced_by" value="<?= $admin_id ?>">
                    <div class="mx-2">
                        <label class="form-label">Sent to</label>
                        <select name="user_id" id="" class="form-select">
                            <option value="" disabled>Announce it to.....</option>
                            <option value="2105">Public Announcement</option>
                            <?php foreach($getUsersForAnnouncement as $heads) : ?>
                                <option value="<?= htmlspecialchars($heads["user_id"]) ?>"><?= htmlspecialchars($heads["lastname"] . ' ' . substr($heads["middlename"], 0, 1) . '. ' . $heads["lastname"]) ?></option>
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
<script src="../../assets/js/hr_js/admin/announcement.js"></script>