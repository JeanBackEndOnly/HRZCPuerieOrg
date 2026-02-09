<section>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="mx-2">
            <h4><i class="fas fa-calendar-check"></i> Attendance Management</h4>
            <small class="text-muted">Track employee attendance, biometric data, and verification</small>
        </div>
        <div id="markbtn">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#markAttendanceModal">
                <i class="fas fa-plus me-1"></i> Mark Attendance
            </button>
        </div>
    </div>
    <div id="attendanceSection"><!-- Mark Attendance Modal -->
        <div class="modal fade" id="markAttendanceModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title text-white">Mark Attendance</h5>
                        <button type="button" class="btn-close text-white " data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="attendanceForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Employee</label>
                                    <select class="form-select text-uppercase" id="employeeSelect" name="employee_id"
                                        required>
                                        <option value="">Select Employee</option>
                                        <!-- Options loaded via AJAX -->
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" id="attendanceDate" name="attendance_date"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Time In</label>
                                    <input type="time" class="form-control" id="timeIn" name="time_in">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Time Out</label>
                                    <input type="time" class="form-control" id="timeOut" name="time_out">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" id="attendanceStatus" name="attendance_status" required>
                                        <option value="present">Present</option>
                                        <option value="absent">Absent</option>
                                        <option value="late">Late</option>
                                        <option value="halfday">Half Day</option>
                                        <option value="leave">On Leave</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" id="attendanceRemarks" name="attendance_remarks"
                                        rows="2"></textarea>
                                </div>
                            </div>

                            <div class="mt-4 text-end">
                                <button type="button" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Attendance</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

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
            <h5 class="m-0"><i class="fas fa-file-invoice"></i> Employee Attendance</h5>

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


                    <!-- ATTENDANCE LOG -->
                    <div class="card mb-3 shadow-sm">
                        <div class="p-1 bg-dark text-white">
                            <strong>Attendance Log</strong>
                        </div>
                        <div class="card-body table-responsive overflow-auto" style="max-height: 250px;">
                            <table class="table text-center table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" id="attendance_table">
                                    <!-- JS will fill -->
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                    $("#employeeId").val(employee_id);
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
        $('#attendanceSection tbody').on('click', '.viewbtn', function () {
            let id = $(this).data('id');
            
            // Show payslip panel
            $("#user_id").val(id);
            $("#attendanceEmployee").removeClass("d-none");
            // Hide summary + table
            $("#attendanceSection").addClass("d-none");
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
            $("#attendanceSection").removeClass("d-none");
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









    });
</script>