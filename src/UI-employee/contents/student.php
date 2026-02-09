<style>
    .card-admin {
        background: white;
        padding: 20px;
        flex: 2;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        min-width: 150px;
        font-size: 20px;
    }

    .card-admin i {
        font-size: 20px;
        display: block;
        margin-bottom: 10px;
    }

    .card-admin span {
        display: block;
        margin-top: 5px;
        font-size: 14px;
        color: #555;
    }

    .stats-admin {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;

    }
</style>

<section class="stats-admin p-3">
    <div class="card-admin"><i class="fa fa-users"></i> 29 <span>Total Students</span></div>
    <div class="card-admin"><i class="fa fa-check"></i> 20 <span>Present today</span></div>
    <div class="card-admin"><i class="fa fa-x"></i> 9 <span>Absence Today</span></div>
    <div class="card-admin">70% <span>Attendance Rate</span></div>
</section>
<section class="attendance-overview">
    <div class="overview-grid row g-3">

        <!-- Attendance Card with Tabs -->
        <div class="col-md-12 p-3">
            <div class="w-100">
                <!-- Section Tabs -->
                <ul class="nav nav-tabs nav-justified w-100" id="sectionTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-sec1" data-bs-toggle="tab" data-bs-target="#sec1"
                            type="button" role="tab">Section 1</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-sec2" data-bs-toggle="tab" data-bs-target="#sec2" type="button"
                            role="tab">Section 2</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-sec3" data-bs-toggle="tab" data-bs-target="#sec3" type="button"
                            role="tab">Section 3</button>
                    </li>
                </ul>

                <!-- Tab Content Per Section -->
                <div class="tab-content pt-3" id="sectionTabsContent">
                    <!-- Section 1 -->
                    <div class="tab-pane fade show active" id="sec1" role="tabpanel" aria-labelledby="tab-sec1">
                        <div class="card p-3">
                            <section class="p-2">
                                <div class="">
                                    <div class="d-flex justify-content-between align-items-center mb-0">
                                        <div>
                                            <h5 class=""><i class="fa fa-folder-open text-primary me-2"></i>Section
                                                Management</h5>
                                            <span>Manage and process student registration application</span>
                                        </div>
                                        <button class="btn btn-success btn-sm" id="addNewBtn" data-section="1">
                                            <i class="fa fa-plus"></i> Add New Learner
                                        </button>
                                    </div>
                                    <table class="table table-bordered table-hover mb-0" id="student-tbl-1">
                                        <thead class="table-light text-dark">
                                            <tr>
                                                <th class="text-center" style="width:4%">#</th>
                                                <th>Learner Name</th>
                                                <th>Grade Level</th>
                                                <th>Date Submitted</th>
                                                <th>Contact Number</th>
                                                <th>Type</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sample-data-body-1"></tbody>
                                    </table>
                                </div>


                                <!-- Modal -->

                            </section>
                        </div>
                    </div>

                    <!-- Section 2 -->
                    <div class="tab-pane fade" id="sec2" role="tabpanel" aria-labelledby="tab-sec2">
                        <div class="card p-3">
                            <section class="p-2">
                                <div class="">
                                    <div class="d-flex justify-content-between align-items-center mb-0">
                                        <div>
                                            <h4 class=""><i class="fa fa-folder-open text-primary me-2"></i>Section
                                                Management</h4>
                                            <span>Manage and process student registration application</span>
                                        </div>
                                        <button class="btn btn-success btn-sm" id="addNewBtn" data-section="2">
                                            <i class="fa fa-plus"></i> Add New Learner
                                        </button>
                                    </div>
                                    <table class="table table-bordered table-hover mb-0" id="student-tbl-2">
                                        <thead class="table-light text-dark">
                                            <tr>
                                                <th class="text-center" style="width:4%">#</th>
                                                <th>Learner Name</th>
                                                <th>Grade Level</th>
                                                <th>Date Submitted</th>
                                                <th>Contact Number</th>
                                                <th>Type</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sample-data-body-2"></tbody>
                                    </table>
                                </div>


                                <!-- Modal -->

                            </section>
                        </div>
                    </div>

                    <!-- Section 3 -->
                    <div class="tab-pane fade" id="sec3" role="tabpanel" aria-labelledby="tab-sec3">
                        <div class="card p-3 d-flex">
                            <section class="p-2">
                                <div class="">
                                    <div class="d-flex justify-content-between align-items-center mb-0">
                                        <div>
                                            <h4 class=""><i class="fa fa-folder-open text-primary me-2"></i>Section
                                                Management</h4>
                                            <span>Manage and process student registration application</span>
                                        </div>
                                        <button class="btn btn-success btn-sm" id="addNewBtn" data-section="3">
                                            <i class="fa fa-plus"></i> Add New Learner
                                        </button>
                                    </div>
                                    <table class="table table-bordered table-hover mb-0" id="student-tbl-3">
                                        <thead class="table-light text-dark">
                                            <tr>
                                                <th class="text-center" style="width:4%">#</th>
                                                <th>Learner Name</th>
                                                <th>Grade Level</th>
                                                <th>Date Submitted</th>
                                                <th>Contact Number</th>
                                                <th>Type</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sample-data-body-3"></tbody>
                                    </table>
                                </div>


                                <!-- Modal -->

                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Unified Modal (Place only once at the end of section) -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Update Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <div class="mb-2">
                        <label class="form-label">Learner Name</label>
                        <input type="text" class="form-control" id="editName" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Grade Level</label>
                        <input type="text" class="form-control" id="editGrade" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Date Submitted</label>
                        <input type="text" class="form-control" id="editDate" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="editContact" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Type</label>
                        <select class="form-select" id="editType">
                            <option>New</option>
                            <option>Transfer</option>
                            <option>Regular</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="editStatus">
                            <option>Pending</option>
                            <option>Approved</option>
                            <option>Declined</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success text-white" type="submit">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const sectionData = {
        1: [
            { id: 1, name: "Juan Dela Cruz", grade: "Grade 3", date: "June 1, 2025", contact: "09123456789", type: "New", status: "Pending" },
            { id: 2, name: "Maria Santos", grade: "Grade 6", date: "June 2, 2025", contact: "09234567890", type: "Transfer", status: "Approved" }
        ],
        2: [
            { id: 1, name: "Miguel Torres", grade: "Grade 5", date: "June 6, 2025", contact: "09678901234", type: "Regular", status: "Declined" },
            { id: 2, name: "Liza Mendoza", grade: "Grade 4", date: "June 7, 2025", contact: "09789012345", type: "New", status: "Pending" }
        ],
        3: [
            { id: 1, name: "Enzo Cruz", grade: "Grade 1", date: "June 8, 2025", contact: "09890123456", type: "Transfer", status: "Approved" },
            { id: 2, name: "Grace Aquino", grade: "Grade 2", date: "June 9, 2025", contact: "09901234567", type: "New", status: "Pending" }
        ]
    };

    const dataTables = {};

    function renderTable(sectionId) {
        const data = sectionData[sectionId];
        const tableId = `#student-tbl-${sectionId}`;
        const tbodyId = `#sample-data-body-${sectionId}`;
        let tbody = $(tbodyId);
        tbody.html('');
        let i = 1;

        data.forEach(emp => {
            let tr = $('<tr></tr>');
            tr.append(`<td class="text-center">${i++}</td>`);
            tr.append(`<td>${emp.name}</td>`);
            tr.append(`<td>${emp.grade}</td>`);
            tr.append(`<td>${emp.date}</td>`);
            tr.append(`<td>${emp.contact}</td>`);
            tr.append(`<td>${emp.type}</td>`);
            tr.append(`<td class="text-center">${emp.status}</td>`);
            tr.append(`
                <td class="text-center">
                <button class="btn btn-sm btn-success editBtn" data-id="${emp.id}" data-section="${sectionId}"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-danger trashBtn"><i class="fa fa-trash"></i></button>
                <button class="btn btn-sm btn-primary viewBtn"><i class="fa fa-eye"></i></button>
                </td>`);
            tbody.append(tr);
        });

        if (dataTables[sectionId]) dataTables[sectionId].destroy();
        dataTables[sectionId] = $(tableId).DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 25],
            columnDefs: [{ orderable: false, targets: 7 }]
        });

        $(`${tbodyId} .editBtn`).click(function () {
            const id = $(this).data('id');
            const sec = $(this).data('section');
            const record = sectionData[sec].find(e => e.id === id);
            if (record) {
                $('#editId').val(record.id);
                $('#editName').val(record.name);
                $('#editGrade').val(record.grade);
                $('#editDate').val(record.date);
                $('#editContact').val(record.contact);
                $('#editType').val(record.type);
                $('#editStatus').val(record.status);
                $('#editForm').data('section', sec);
                new bootstrap.Modal(document.getElementById('editModal')).show();
            }
        });

        $('#addNewBtn').off('click').on('click', function () {
            const sec = sectionId;
            $('#editForm').data('section', sec);
            $('#editId').val('');
            $('#editName').val('');
            $('#editGrade').val('');
            $('#editDate').val('');
            $('#editContact').val('');
            $('#editType').val('New');
            $('#editStatus').val('Pending');
            new bootstrap.Modal(document.getElementById('editModal')).show();
        });
    }

    $('#editForm').submit(function (e) {
        e.preventDefault();
        const id = $('#editId').val();
        const sectionId = $('#editForm').data('section');
        const data = sectionData[sectionId];

        if (id) {
            const index = data.findIndex(e => e.id == id);
            if (index !== -1) {
                data[index].name = $('#editName').val();
                data[index].grade = $('#editGrade').val();
                data[index].date = $('#editDate').val();
                data[index].contact = $('#editContact').val();
                data[index].type = $('#editType').val();
                data[index].status = $('#editStatus').val();
            }
        } else {
            const newId = data.length ? data[data.length - 1].id + 1 : 1;
            data.push({
                id: newId,
                name: $('#editName').val(),
                grade: $('#editGrade').val(),
                date: $('#editDate').val(),
                contact: $('#editContact').val(),
                type: $('#editType').val(),
                status: $('#editStatus').val()
            });
        }

        renderTable(sectionId);
        bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
    });

    $(document).ready(function () {
        renderTable(1); // Load default (Section 1)
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            const targetId = $(e.target).attr('data-bs-target');
            const sectionId = targetId.replace('#sec', '');
            renderTable(sectionId);
        });
    });
</script>