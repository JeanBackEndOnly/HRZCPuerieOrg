<section>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="mx-2">
            <h4 class="mb-1">
                <i class="fas fa-calendar-check"></i> Biometric Management
            </h4>
            <p class="text-muted mb-0">
                Track employee attendance, biometric data, and verification
            </p>
        </div>

        <div id="markbtn">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#biometricNew">
                <i class="fas fa-plus me-1"></i> New Access
            </button>
        </div>
    </div>
    <div id="biometricModal"><!-- Mark Attendance Modal -->
        <div class="modal fade" id="biometricNew" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title text-white">Device Biometric Access</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <!-- Biometric Device Form -->
                        <form id="deviceBiometricForm">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Device Name</label>
                                    <input type="text" class="form-control" name="device_name" id="deviceName"
                                        placeholder="Enter device name" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Device ID</label>
                                    <input type="text" class="form-control" name="device_id" id="deviceId"
                                        placeholder="Enter device ID" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" id="deviceUsername"
                                        placeholder="Enter username" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="devicePassword"
                                        placeholder="Enter password" required>
                                </div>

                            </div>

                            <div class="mt-4 text-end">
                                <button type="button" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Save Biometric Account</button>
                            </div>
                        </form>

                        <!-- Device Biometric Accounts Table -->
                        <div class="mt-4">
                            <h6>Registered Device Biometric Accounts</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="deviceBiometricTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Device ID</th>
                                            <th>Device Name</th>
                                            <th>Biometric ID</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="deviceBiometricList">
                                        <!-- Populated via JS/AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                const base_url = ''; // Set your base URL

                // Fetch and populate registered device biometrics
                function loadDeviceBiometrics() {
                    $.ajax({
                        url: `${base_url}/authentication/transact_action.php?action=biometric_access`,
                        type: 'POST',
                        data: { action: 'getDeviceBiometrics' },
                        success: function (response) {
                            try {
                                const data = typeof response === 'string' ? JSON.parse(response) : response;
                                const tbody = $('#deviceBiometricList');
                                tbody.empty();

                                if (data.status === 1 && data.devices.length) {
                                    data.devices.forEach(device => {
                                        tbody.append(`
                                <tr>
                                    <td>${device.device_id}</td>
                                    <td>${device.device_name}</td>
                                    <td>${device.bio_id || ''}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger deleteDevice" data-id="${device.id}">Delete</button>
                                    </td>
                                </tr>
                            `);
                                    });
                                } else {
                                    tbody.append(`<tr><td colspan="4" class="text-center">No devices registered</td></tr>`);
                                }
                            } catch (e) {
                                console.error('Invalid response:', response);
                            }
                        },
                        error: function () {
                            alert('Failed to fetch device biometrics.');
                        }
                    });
                }

                // loadDeviceBiometrics();

                // Submit form
                $('#deviceBiometricForm').submit(function (e) {
                    e.preventDefault();
                    const formData = $(this).serialize() + '&action=saveDeviceBiometric';

                    $.ajax({
                        url: `${base_url}/authentication/transact_action.php?action=biometric_access`,
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            try {
                                const data = typeof response === 'string' ? JSON.parse(response) : response;
                                if (data.status === 1) {
                                    alert('Device biometric saved successfully!');
                                    $('#deviceBiometricForm')[0].reset();
                                    loadDeviceBiometrics();
                                } else {
                                    alert('Error: ' + data.message);
                                }
                            } catch (e) {
                                console.error('Invalid response:', response);
                            }
                        },
                        error: function () {
                            alert('Error saving device biometric.');
                        }
                    });
                });

                // Delete device
                $(document).on('click', '.deleteDevice', function () {
                    if (!confirm('Are you sure you want to delete this device?')) return;

                    const id = $(this).data('id');
                    $.ajax({
                        url: `${base_url}/authentication/transact_action.php?action=biometric_access`,
                        type: 'POST',
                        data: { action: 'deleteDeviceBiometric', id: id },
                        success: function (response) {
                            try {
                                const data = typeof response === 'string' ? JSON.parse(response) : response;
                                if (data.status === 1) {
                                    loadDeviceBiometrics();
                                } else {
                                    alert('Error: ' + data.message);
                                }
                            } catch (e) {
                                console.error('Invalid response:', response);
                            }
                        },
                        error: function () {
                            alert('Failed to delete device.');
                        }
                    });
                });
            });

        </script>

        <!-- Summary Cards -->
        <div class="row mb-2">
            <div class="col-md-4">
                <div class="card shadow bg-white text-center p-4">
                    <h5 id="totalPresent">0</h5>
                    <small>Present Today</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow bg-white text-center p-4">
                    <h5 id="totalAbsent">0</h5>
                    <small>Absent Today</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow bg-white text-center p-4">
                    <h5 id="totalLate">0</h5>
                    <small>Late Arrivals</small>
                </div>
            </div>
        </div>

        <div id="attendance-table-container" class="card shadow bg-white p-2">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="loginatables">
                    <thead class="table-light">
                        <tr>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="dailyAttendanceTable">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="attendanceEmployee" class="card shadow  bg-white p-4 d-none">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="m-0"><i class="fas fa-file-invoice"></i> Employee Biometric</h5>

            <div>
                <button id="backToPayrollBtn" class="btn btn-secondary btn-sm me-2">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>

        </div>

        <div id="attendanceContent">
            <div id="payslipContent">
                <div class="payslip-wrapper">
                    <!-- EMPLOYEE PROFILE -->
                    <div class="card mb-3 shadow-sm p-3">
                        <div class="bg-primary text-white p-3 rounded-top">
                            <strong>Employee Profile</strong>
                        </div>

                        <div class="card-body">
                            <div class="row text-center text-md-start align-items-center">

                                <!-- PHOTO COLUMN -->
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <img id="profile_photo" src="<?php echo base_url() ?>assets/image/users.png"
                                        alt="Profile Photo" class="rounded-box border border-3" width="150"
                                        height="150">

                                </div>

                                <!-- PRIMARY DETAILS COLUMN -->
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <h4 id="profile_name" class="mb-0 text-uppercase">Employee Name</h4>
                                    <p class="mb-1 text-dark"><strong>ID:</strong> <span id="profile_id"></span></p>
                                    <p class="mb-1 text-dark"><strong>Position:</strong> <span
                                            id="profile_position"></span></p>
                                    <p class="mb-1 text-dark"><strong>Department:</strong> <span
                                            id="profile_department"></span>
                                    </p>
                                </div>

                                <!-- EXTRA INFO COLUMN -->
                                <div class="col-md-4">
                                    <p class="mb-1 text-dark"><strong>Email:</strong> <span
                                            id="profile_email">email@example.com</span></p>
                                    <p class="mb-1 text-dark"><strong>Hire Date:</strong> <span
                                            id="profile_hiredate">2025-01-01</span></p>
                                    <p class="mb-1 text-dark"><strong>Phone:</strong> <span id="profile_phone">+63 912
                                            345
                                            6789</span></p>
                                    <p class="mb-0 text-dark"><strong>Status:</strong> <span
                                            id="profile_status">Active</span></p>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <!-- ENROLLMENT -->
                        <div class="col-md-6 d-flex">
                            <div class="card mb-3 shadow-sm w-100 d-flex flex-column">

                                <div class="p-2 bg-dark text-white">
                                    <strong>Biometric Enrollment</strong>
                                </div>

                                <form id="biometricForm" class="card-body" enctype="multipart/form-data">
                                    <input type="file" name="bio_image" id="bioImageInput" style="display:none;" />
                                    <input type="hidden" id="user_id_bio">
                                    <div class="text-center mb-3">
                                        <img id="finger_preview"
                                            src="https://cdn-icons-png.flaticon.com/512/9796/9796616.png"
                                            style="width: 140px; height: 140px; border-radius:50%;"
                                            alt="Fingerprint Scan Preview">

                                        <small id="scanStatus" class="d-block text-muted mt-1">
                                            Waiting for scan...
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold small text-muted">Employee ID</label>
                                        <input type="text" readonly name="employee_id" id="employee_id_bio"
                                            class="form-control form-control-sm" placeholder="e.g. EMP001" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold small text-muted">Captured Biometrics</label>
                                        <textarea name="biometric_data" id="biometricData"
                                            class="form-control form-control-sm" rows="2"
                                            placeholder="Fingerprint encoded data..." readonly></textarea>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" id="startScan" class="btn btn-primary btn-sm">Start
                                            Scan</button>
                                        <button type="button" id="stopScan" class="btn btn-warning btn-sm">Stop
                                            Scan</button>
                                        <button type="submit" id="submitBtn" class="btn btn-success btn-sm"
                                            style="display:none;">Submit</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <!-- REAL-TIME PREVIEW -->
                        <div class="col-md-6 d-flex">
                            <div class="card mb-3 shadow-sm w-100 d-flex flex-column">

                                <div class="p-2 bg-danger text-white">
                                    <strong>Biometric Data Preview</strong>
                                </div>

                                <div class="card-body">

                                    <div class="text-center mb-3">
                                        <img id="previewThumb"
                                            src="https://cdn-icons-png.flaticon.com/512/9796/9796616.png"
                                            style="width: 120px; height: 120px; border-radius:50%;" alt="Scanned Thumb">
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold small text-muted">Generated Date</label>
                                        <input id="generatedDate" type="text" class="form-control form-control-sm"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold small text-muted">Biometric ID</label>
                                        <input id="bioId" type="text" class="form-control form-control-sm" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold small text-muted">Stored Biometric Data</label>
                                        <textarea id="storedBio" class="form-control form-control-sm" rows="2"
                                            readonly></textarea>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- <script src="https://unpkg.com/@digitalpersona/websdk@v1"></script>
                    <script src="https://unpkg.com/@digitalpersona/fingerprint@v1"></script>

                    <script>
                        $(document).ready(function () {

                            let capturing = false;

                            const api = new Fingerprint.WebApi({ debug: true });

                            // DOM elements
                            const $fingerPreview = $('#finger_preview');
                            const $scanStatus = $('#scanStatus');
                            const $submitBtn = $('#submitBtn');
                            const $biometricData = $('#biometricData');

                            // On sample acquired
                            api.onSamplesAcquired = async (event) => {
                                try {
                                    const samples = JSON.parse(event.samples);
                                    const imageData = Fingerprint.b64UrlToUtf8(samples[0]);
                                    const imgSrc = `data:image/png;base64,${btoa(imageData)}`;

                                    $fingerPreview.attr('src', imgSrc);
                                    $scanStatus.text('Scan complete!');
                                    $biometricData.val(samples[0]);
                                    $submitBtn.show();
                                    stopCapture();

                                } catch (e) {
                                    console.error(e);
                                    $scanStatus.text('Scan failed!');
                                }
                            };

                            api.onErrorOccurred = (event) => {
                                console.error(event.error);
                                $scanStatus.text('Scan failed!');
                            };

                            // Start scan
                            $('#startScan').click(async function(){
                                if (capturing) return;
                                $scanStatus.text('Scanning fingerprint...');
                                $fingerPreview.css({ 'border': '3px solid #007bff', 'box-shadow': '0 0 20px 5px rgba(0,123,255,0.5)' });

                                try {
                                    await api.startAcquisition(Fingerprint.SampleFormat.PngImage);
                                    capturing = true;
                                } catch (e) {
                                    console.error(e);
                                    $scanStatus.text('Error starting scan.');
                                }
                            });

                            // Stop scan
                            $('#stopScan').click(() => stopCapture());
                            function stopCapture() {
                                if (!capturing) return;
                                api.stopAcquisition().then(() => {
                                    capturing = false;
                                    $fingerPreview.css({ 'border': '', 'box-shadow': '' });
                                    $scanStatus.text('Scan stopped.');
                                }).catch(e => console.error(e));
                            }

                            // Submit form
                            $('#biometricForm').submit(async function (e) {
                                e.preventDefault();

                                const employeeId = $('#employee_id_bio').val();
                                const userId = $('#user_id_bio').val(); // hidden field for PHP
                                const bioData = $('#biometricData').val();

                                if (!employeeId || !bioData) {
                                    alert('Employee ID or biometric data missing!');
                                    return;
                                }

                                const formData = new FormData();
                                formData.append('action', 'enrollBio');
                                formData.append('employee_id', employeeId);
                                formData.append('user_id', userId);
                                formData.append('biometric_data', bioData);

                                const base64Data = base64UrlToBase64(bioData);
                                const byteString = atob(base64Data);
                                const ab = new ArrayBuffer(byteString.length);
                                const ia = new Uint8Array(ab);
                                for (let i = 0; i < byteString.length; i++) ia[i] = byteString.charCodeAt(i);
                                const blob = new Blob([ab], { type: 'image/png' });
                                formData.append('bio_image', blob, `fingerprint_${employeeId}.png`);

                                    function base64UrlToBase64(base64Url) {
                                        let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
                                        while (base64.length % 4) { base64 += '='; }
                                        return base64;
                                    }
                                $.ajax({
                                    url: `${base_url}/authentication/transact_action.php?action=biometric_check`,
                                    type: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) {
                                        const data = typeof response === 'string' ? JSON.parse(response) : response;

                                        if (data.status == 1) {
                                            alert('Biometric saved!');
                                            $('#biometricForm')[0].reset();
                                            // Correct: use data.employee_id from the response
                                            $('#user_id_bio').val(data.employee_id);
                                            $('#employee_id_bio').val(data.bioId);
                                            $submitBtn.hide();
                                            $scanStatus.text('Waiting for scan...');
                                            $fingerPreview.attr('src', 'https://cdn-icons-png.flaticon.com/512/9796/9796616.png');
                                            $('#previewThumb').attr('src', 'https://cdn-icons-png.flaticon.com/512/9796/9796616.png');
                                        } else {
                                            alert('Error: ' + data.message);
                                        }
                                    },

                                    error: function () {
                                        alert('Error submitting biometric data.');
                                    }
                                });
                            });

                        });

                    </script> -->

                </div>
            </div>
</section>

<script>
    $(document).ready(function () {
        $.ajax({
            type: "GET",
            url: `${base_url}/authentication/transact_action.php?action=get_payroll_data`,
            dataType: "json",   // must be json
            success: function (response) {
                if (response.status == 1) {
                    let tbody = '';
                    let options = '<option value="">Select Employee</option>';

                    // Build select dropdown + table rows
                    response.data.forEach(emp => {
                        $("#employeeId").val(emp.employee_id);
                        options += `
                                <option class="text-uppercase" value="${emp.employee_id}">
                                    ${emp.employee_id} - ${emp.firstname} ${emp.lastname}
                                </option>
                            `;


                        tbody += `
                            <tr>
                                <td class="text-center">${emp.employeeID}</td>
                                <td class="text-uppercase">${emp.firstname} ${emp.middlename}, ${emp.lastname}</td>
                                <td>${emp.position}</td>
                                <td>${emp.department || 'No Update'}</td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm p-2 viewbtn" data-id="${emp.employee_id}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    $("#employeeSelect").html(options);
                    $('#dailyAttendanceTable').html(tbody);

                    $("#loginatables").DataTable({
                        paging: true,
                        searching: true,
                        ordering: true,
                        responsive: true,
                        scrollY: "60vh",
                        scrollCollapse: true,
                        lengthMenu: [3, 5, 10, 25, 50, 100],

                        lengthChange: true,
                        pageLength: 3,
                        language: {
                            lengthMenu: "_MENU_  Attendance Sheet", // custom text
                            search: "Search:",                     // optional custom search text
                            info: "Showing _START_ to _END_ of _TOTAL_ entries",
                            infoFiltered: "(filtered from _MAX_ total records)"
                        }
                    });

                } else {
                    $('#dailyAttendanceTable').html('<tr><td colspan="8" class="text-center">No data found</td></tr>');
                }
            },
            error: function (err) {
                console.error(err);
                $('#dailyAttendanceTable').html('<tr><td colspan="8" class="text-center">Error fetching data</td></tr>');
            }
        });

        const employeeData = {};
        $('#biometricModal tbody').on('click', '.viewbtn', function () {

            let id = $(this).data('id');
            biofetching(id);

            // Show payslip panel
            $("#user_id").val(id);

            $("#attendanceEmployee").removeClass("d-none");
            // Hide summary + table
            $("#biometricModal").addClass("d-none");
            $("#markbtn").addClass('d-none');
            $("#payroll-table-container").addClass("d-none");
            attendanceList(id);

            $.ajax({
                type: "GET",
                url: `${base_url}/authentication/transact_action.php?action=get_employee_details&id=${id}`,
                dataType: "json",
                success: function (response) {
                    if (response.status == 1) {
                        // employeeData = response.data;
                        employeeData.profile = {
                            name: `${response.data.firstname} ${response.data.middlename} ${response.data.lastname}`,
                            id: response.data.employeeID,
                            user_id: response.data.employee_id,
                            position: response.data.jobTitle,
                            department: response.data.Department_name,
                            email: response.data.email,
                            hiredate: response.data.created_date,
                            phone: response.data.contact,
                            status: response.data.status,
                            photo: response.data.photo_url || "<?php echo base_url() ?>assets/image/users.png"
                        }

                        employeeData.pay = {
                            pay_date: response.data.updated_at || '',
                            basic: response.data.salary || 0,
                            gross: response.data.gross_pay || 0,
                            deductions: response.data.totalDeductionPay || 0,
                            net: response.data.net_pay || 0,

                        };

                        employeeData.deductions = [];
                        employeeData.totalDeductionPay = response.data.totalDeductionPay || 0;
                        if (Array.isArray(response.data.deductions)) {
                            response.data.deductions.forEach(d => {
                                employeeData.deductions.push({
                                    label: d.deduction_name || "No Label",
                                    amount: parseFloat(d.deduction_current) || 0,
                                    id: d.deduction_id
                                });
                            });
                        } else {
                            employeeData.deductions.push({
                                label: "No Deductions Found",
                                amount: 0
                            });
                        }

                        employeeData.earnings = [];
                        employeeData.totalEarningPay = response.data.totalEarningPay || 0;
                        if (Array.isArray(response.data.earnings)) {
                            response.data.earnings.forEach(d => {
                                employeeData.earnings.push({
                                    label: d.earning_name || "No Label",
                                    amount: parseFloat(d.current_pay) || 0,
                                    id: d.earning_id
                                });
                            });
                        } else {
                            employeeData.earnings.push({
                                label: "No Earnings Found",
                                amount: 0
                            });
                        }


                        // ===== INSERT PROFILE =====
                        $("#profile_name").text(employeeData.profile.name);
                        $("#profile_id").text(employeeData.profile.id);
                        $("#profile_position").text(employeeData.profile.position);
                        $("#profile_department").text(employeeData.profile.department);
                        $("#profile_photo").attr("src", employeeData.profile.photo);
                        $("#profile_email").text(employeeData.profile.email);
                        $("#profile_hiredate").text(employeeData.profile.hiredate);
                        $("#profile_phone").text(employeeData.profile.phone);
                        $("#profile_status").text(employeeData.profile.status);
                        $("#employee_id_bio").val(employeeData.profile.id);
                        $("#user_id_bio").val(employeeData.profile.user_id);

                        // ===== INSERT PAY =====
                        $("#pay_date").text(employeeData.pay.pay_date) || '';
                        $("#basic_pay").text(employeeData.pay.basic.toLocaleString());
                        $("#gross_pay").text(employeeData.pay.gross.toLocaleString());
                        $("#total_deductions").text(employeeData.pay.deductions.toLocaleString());
                        $("#net_pay").text(employeeData.pay.net.toLocaleString());


                        // ===== INSERT DEDUCTIONS =====
                        $("#deduction_list").empty();

                        if (employeeData.deductions && employeeData.deductions.length > 0) {
                            employeeData.deductions.forEach(item => {
                                $("#deduction_list").append(`
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>${item.label}</span>
                                        <div>
                                            <strong>₱${item.amount.toLocaleString()}</strong>
                                            <i class="fa fa-trash text-danger ms-3 remove-deduction" data-id="${item.id}" style="cursor:pointer;"></i>
                                        </div>
                                    </li>
                                `);
                            });
                            $("#total_deduction").text(employeeData.totalDeductionPay.toLocaleString());
                        } else {
                            $("#deduction_list").append(`
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>No Benefits Deductions</span>
                                    <strong>₱ 0.00</strong>
                                </li>
                            `);
                            $("#total_deduction").text("0.00");
                        }

                        // ===== INSERT EARNINGS =====
                        $("#basic_salary").empty();

                        if (employeeData.earnings && employeeData.earnings.length > 0) {
                            employeeData.earnings.forEach(item => {
                                $("#basic_salary").append(`
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>${item.label}</span>
                                        <div>
                                            <strong>₱${item.amount.toLocaleString()}</strong>
                                            <i class="fa fa-trash text-danger ms-3 remove-earning" data-id="${item.id}" style="cursor:pointer;"></i>
                                        </div>
                                    </li>
                                `);
                            });
                            $("#total_bonus").text(employeeData.totalEarningPay.toLocaleString());
                        } else {
                            $("#basic_salary").append(`
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>No Basic Salary</span>
                                    <strong>₱ 0.00</strong>
                                </li>
                            `);
                            $("#total_bonus").text("0.00");
                        }

                    } else {
                        console.error("No data found for this employee");
                        $("#payslipContent").html("<p class='text-danger'>No data found</p>");
                    }
                },
                error: function (err) {
                    console.error(err);
                    $("#payslipContent").html("<p class='text-danger'>Error fetching data</p>");
                }
            });
        });

        $('#backToPayrollBtn').on('click', function () {
            $("#attendanceEmployee").addClass("d-none");
            $("#markbtn").removeClass('d-none');
            $("#biometricModal").removeClass("d-none");
            $("#payroll-table-container").removeClass("d-none");
        });

        $(document).on("submit", "#attendanceForm", function (e) {
            e.preventDefault();
            let employeeID = $("#employeeSelect").val();

            if (!employeeID) {
                alert("Please select an employee first.");
                return;
            }
            let formdata = new FormData(this);
            formdata.append('action', 'Manual_Attendance');

            $.ajax({
                url: `${base_url}/authentication/transact_action.php?action=attendanceManualForm`,
                method: "POST",
                data: formdata,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (res) {

                    alert(res.message);
                    // Optional: reset form after submit
                    $("#attendanceForm")[0].reset();
                },
                error: function () {
                    $("#attendance_table").html(`<tr><td colspan="4" class="text-center">Error fetching records</td></tr>`);
                }
            });
        });
        attendanceList();
        function attendanceList(employeeID = null) {
            $.ajax({
                type: "POST",
                url: `${base_url}/authentication/transact_action.php?action=getAttendanceList`,
                data: { employee_id: employeeID },
                dataType: "json",
                success: function (res) {
                    let tbody = '';
                    if (res.status && Array.isArray(res.data) && res.data.length > 0) {
                        res.data.forEach(att => {
                            tbody += `
                        <tr>
                            <td>${att.date || '-'}</td>
                            <td>${att.time_in || '-'}</td>
                            <td>${att.time_out || '-'}</td>
                            <td>${att.attendance_status || '-'}</td>
                        </tr>
                    `;
                        });
                    } else {
                        tbody = `<tr><td colspan="4" class="text-center">No attendance records found</td></tr>`;
                    }

                    $("#attendance_table").html(tbody);
                },
                error: function () {
                    $("#attendance_table").html(`<tr><td colspan="4" class="text-center">Error fetching records</td></tr>`);
                }
            });
        }
        function biofetching(userId) {
            // Reset preview and inputs for a fresh fetch
            $('#previewThumb').attr('src', 'https://cdn-icons-png.flaticon.com/512/9796/9796616.png');
            $('#storedBio').val('');
            $('#bioId').val('');
            $('#generatedDate').val('');
            $('#employee_id_bio').val('');
            $('#user_id_bio').val('');

            if (!userId) return;

            // Set the current userId in hidden field for future submits
            $('#user_id_bio').val(userId);

            $.ajax({
                url: `${base_url}/authentication/transact_action.php?action=biometric_check`,
                type: 'POST',
                data: { user_id: userId, action: 'GetBiometricData' },
                success: function (response) {
                    try {
                        const data = typeof response === 'string' ? JSON.parse(response) : response;
                        if (data.status == 1) {
                            if (data.image) $('#previewThumb').attr('src', `${base_url}/authentication/${data.image}`);
                            $('#storedBio').val(data.biometricData || '');
                            $('#bioId').val(data.bioId || '');
                            $('#generatedDate').val(data.date || new Date().toLocaleString());
                            $('#employee_id_bio').val(data.employee_no || ''); // Update employee input
                        } else {
                            console.warn('No biometric data found');
                        }
                    } catch (e) {
                        console.error('Invalid response from server:', response);
                    }
                },
                error: function () {
                    alert('Error fetching biometric data.');
                }
            });
        }



        let capturing = false;

        const api = new Fingerprint.WebApi({ debug: true });

        // DOM elements
        const $fingerPreview = $('#finger_preview');
        const $scanStatus = $('#scanStatus');
        const $submitBtn = $('#submitBtn');
        const $biometricData = $('#biometricData');

        // On sample acquired
        api.onSamplesAcquired = async (event) => {
            try {
                const samples = JSON.parse(event.samples);
                const imageData = Fingerprint.b64UrlToUtf8(samples[0]);
                const imgSrc = `data:image/png;base64,${btoa(imageData)}`;

                $fingerPreview.attr('src', imgSrc);
                $scanStatus.text('Scan complete!');
                
                $biometricData.val(samples[0]);
                $submitBtn.show();
                stopCapture();

            } catch (e) {
                console.error(e);
                $scanStatus.text('Scan failed!');
            }
        };

        api.onErrorOccurred = (event) => {
            console.error(event.error);
            $scanStatus.text('Scan failed!');
        };

        // Start scan
        $('#startScan').click(async function () {
            if (capturing) return;
            $scanStatus.text('Scanning fingerprint...');
            // $fingerPreview.css({ 'border': '3px solid #007bff', 'box-shadow': '0 0 20px 5px rgba(0,123,255,0.5)' });

            try {
                await api.startAcquisition(Fingerprint.SampleFormat.PngImage);
                capturing = true;
            } catch (e) {
                console.error(e);
                $scanStatus.text('Error starting scan.');
            }
        });

        // Stop scan
        $('#stopScan').click(() => stopCapture());
        function stopCapture() {
            if (!capturing) return;
            api.stopAcquisition().then(() => {
                capturing = false;
                $fingerPreview.css({ 'border': '', 'box-shadow': '' });
                $scanStatus.text('Scan stopped.');
            }).catch(e => console.error(e));
        }

        // Submit form
        $('#biometricForm').submit(async function (e) {
            e.preventDefault();

            const employeeId = $('#employee_id_bio').val();
            const userId = $('#user_id_bio').val(); // hidden field for PHP
            const bioData = $('#biometricData').val();

            if (!employeeId || !bioData) {
                alert('Employee ID or biometric data missing!');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'EnrollmentData');
            formData.append('employee_id', employeeId);
            formData.append('user_id', userId);
            formData.append('biometric_data', bioData);

            const base64Data = base64UrlToBase64(bioData);
            const byteString = atob(base64Data);
            const ab = new ArrayBuffer(byteString.length);
            const ia = new Uint8Array(ab);
            for (let i = 0; i < byteString.length; i++) ia[i] = byteString.charCodeAt(i);
            const blob = new Blob([ab], { type: 'image/png' });
            formData.append('bio_image', blob, `fingerprint_${employeeId}.png`);

            function base64UrlToBase64(base64Url) {
                let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
                while (base64.length % 4) { base64 += '='; }
                return base64;
            }
            $.ajax({
                url: `${base_url}/authentication/transact_action.php?action=biometric_check`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    const data = typeof response === 'string' ? JSON.parse(response) : response;

                    if (data.status == 1) {
                        alert('Biometric saved!');
                        $('#biometricForm')[0].reset();
                        // Correct: use data.employee_id from the response
                        $('#user_id_bio').val(data.employee_id);
                        $('#employee_id_bio').val(data.bioId);
                        $submitBtn.hide();
                        $scanStatus.text('Waiting for scan...');
                        $fingerPreview.attr('src', 'https://cdn-icons-png.flaticon.com/512/9796/9796616.png');
                        $('#previewThumb').attr('src', 'https://cdn-icons-png.flaticon.com/512/9796/9796616.png');
                    } else {
                        alert('Error: ' + data.message);
                    }
                },

                error: function () {
                    alert('Error submitting biometric data.');
                }
            });
        });






    });
</script>