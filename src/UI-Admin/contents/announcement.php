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
    <div class="col-md-12">

    </div>
</main>
<!-- Modal section ================================================= -->
 <div class="modal fade" id="create_announcemenet" tabindex="-1" aria-labelledby="create_announcemenetLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="create_announcemenetLabel">Create New Employee Account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    onclick="location.reload()"></button>
            </div>
            <div class="modal-body">
                <form id="announcemnet-form">
                    <div class="mx-2">
                        <label class="form-label">Sent to</label>
                        <select name="user_id" id="" class="form-select">
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
                        <input type="file" name="file" class="form-control">
                    </div>

                    <div class="modal-footer m-0 p-0 ">
                        <button class="btn btn-danger m-0" type="submit">confirm</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>