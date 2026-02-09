<section>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="mx-2">
            <h4><i class="fas fa-calendar-check"></i> Payroll Management</h4>
            <small class="text-muted">Track employee payroll, payslip data, and deductions</small>
        </div>

    </div>
    <!-- Summary Section -->
    <div id="payroll-summary">


        <!-- Summary Cards -->
        <div class="row mb-2">
            <div class="col-md-4">
                <div class="card shadow bg-white text-center p-4">
                    <h5 id="totalDeductions">₱0.00</h5>
                    <small>Total Deductions This Month</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow bg-white text-center p-4">
                    <h5 id="totalLoans">₱0.00</h5>
                    <small>Total Loans This Month</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow bg-white text-center p-4">
                    <h5 id="totalLeavePay">₱0.00</h5>
                    <small>Total Leave Pay This Month</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div id="payroll-table-container" class="card shadow bg-white p-2">
        
        <div class="table-responsive">

            <table class="table table-bordered table-striped" id="payrollTable">
                <thead class="table-light">
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Date hired</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="employee_table" class="text-left"></tbody>
            </table>
        </div>
    </div>

    <!-- Payslip Review Section -->
    <div id="payslipReview" class="card shadow  bg-white p-4 d-none">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="m-0"><i class="fas fa-file-invoice"></i> Employee review</h5>

            <div>
                <button id="backToPayrollBtn" class="btn btn-secondary btn-sm me-2">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>

        </div>

        <div id="payslipDetails">
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
                                            id="profile_hiredate">--</span></p>
                                    <p class="mb-1 text-dark"><strong>Phone:</strong> <span id="profile_phone">--</span></p>
                                    <p class="mb-0 text-dark"><strong>Status:</strong> <span
                                            id="profile_status">Active</span></p>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <!-- PAYSLIP SUMMARY -->
                        <div class="col-md-4 d-flex">
                            <div class="card mb-3 shadow-sm w-100 d-flex flex-column">
                                <div class="p-2 bg-dark text-white">
                                    <strong>Payslip Summary</strong>
                                </div>

                                <div class="card-body">

                                    <ul class="list-group list-group-flush">

                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Date:</strong>
                                            <span><span id="pay_date"></span></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Basic Salary:</strong>
                                            <span>₱<span id="basic_pay"></span></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Gross Pay:</strong>
                                            <span>₱<span id="gross_pay"></span></span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Total Deductions:</strong>
                                            <span>₱<span id="total_deductions"></span></span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Net Pay:</strong>
                                            <span>₱<span id="net_pay"></span></span>
                                        </li>
                                    </ul>

                                </div>
                                <div class="text-dark card-footer d-flex justify-content-center">
                                    <button id="printmodal" class="btn btn-primary btn-sm">
                                        <i class="fas fa-print"></i> Print Payslip
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 d-flex">
                            <div class="card mb-3 shadow-sm w-100 d-flex flex-column">
                                <div class="p-2 bg-danger justify-content-between d-flex text-white">
                                    <strong>Basic Salary</strong>
                                    <a href="#"><i id="add_earning" class=" text-white fa fa-plus mx-2"></i></a>
                                </div>

                                <div class="card-body flex-grow-1 d-flex flex-column overflow-auto"
                                    style="max-height: 300px;">
                                    <!-- Scrollable list -->
                                    <ul id="basic_salary" class="list-group flex-grow-1">

                                        <!-- JS will inject items -->
                                    </ul>
                                </div>
                                <div class="text-dark card-footer d-flex justify-content-between">
                                    <strong>Total :</strong>
                                    <strong>₱<strong id="total_bonus">0</strong></strong>
                                </div>
                            </div>
                        </div>


                        <!-- DEDUCTIONS LIST -->
                        <div class="col-md-4 d-flex">
                            <div class="card mb-3 shadow-sm w-100 d-flex flex-column">

                                <div class="p-2 bg-danger justify-content-between d-flex text-white">
                                    <strong>Benefits Deduction</strong>
                                    <a href="#"><i id="add_deduction" class=" text-white fa fa-plus mx-2"></i></a>
                                </div>

                                <div class="card-body flex-grow-1 d-flex flex-column overflow-auto"
                                    style="max-height: 300px;">
                                    <!-- Scrollable list -->
                                    <ul id="deduction_list" class="list-group mb-2 flex-grow-1">
                                        <!-- JS will inject items -->

                                    </ul>
                                </div>
                                <div class="text-dark card-footer d-flex justify-content-between ">
                                    <strong>Total :</strong>
                                    <strong>₱<strong id="total_deduction">0</strong></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- PAYROLL HISTORY -->
            <div class="card mb-3 shadow-sm">
                <div class=" p-2 bg-secondary text-white">
                    <strong>Payroll History</strong>
                </div>
                <div class="card-body  table-responsive overflow-auto w-100" style="max-height: 250px;">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Gross</th>
                                <th>Deductions</th>
                                <th>Net Pay</th>
                            </tr>
                        </thead>
                        <tbody id="history_table" class="">
                            <!-- JS will fill this -->
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card mb-3 shadow-sm d-flex flex-column w-100">
                        <div class="p-2 bg-info justify-content-between d-flex text-white">
                            <strong>Loans</strong>
                            <a href="#"><i class="fa fa-plus mx-2"></i></a>
                        </div>
                        <div class="card-body flex-grow-1 overflow-auto" style="max-height: 250px;">
                            <ul id="loan_list" class="list-group"></ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 d-flex">
                    <div class="card mb-3 shadow-sm d-flex flex-column w-100">
                        <div class="p-2 bg-info justify-content-between d-flex text-white">
                            <strong>Requests</strong>
                            <a href="#"><i class="fa fa-plus mx-2"></i></a>
                        </div>
                        <div class="card-body flex-grow-1 overflow-auto" style="max-height: 250px;">
                            <ul id="request_list" class="list-group"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>


<!-- Modal -->
<div class="modal fade" id="payslipModal" tabindex="-1" aria-labelledby="payslipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payslipModalLabel">Payslip Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Payslip content goes here -->
                <div id="payslipModalReview" class="card p-4"
                    style="max-width:600px; margin:auto; font-family:Arial, sans-serif;">
                    <!-- Header -->
                    <div class="text-center mb-3">
                        <h5>ZAMBOANGA PUERICULTURE CENTER</h5>
                        <p class="mb-0 text-dark">ORGANIZATION NO. 144 INC.</p>
                        <p class="mb-2 text-dark">ZAMBOANGA CITY</p>
                        <h5 class="mb-0 text-dark" style="text-decoration:underline;">P A Y S L I P</h5>
                    </div>
                    <!-- Employee Info -->
                    <div class="mb-2">
                        <p class="d-flex text-dark justify-content-between"><strong>NAME</strong><span
                                id="profile_name">---</span></p>
                        <p class="d-flex text-dark justify-content-between"><strong>DESIGNATION</strong><span
                                id="profile_position">---</span></p>
                        <p class="d-flex text-dark justify-content-between"><strong>PAY PERIOD</strong><span
                                id="pay_date">---</span></p>
                    </div>
                    <!-- Earnings -->
                    <div class="mb-3">
                        <p class="d-flex text-dark justify-content-between"><strong>Basic Salary</strong><span>₱<span
                                    id="basic_pay">0.00</span></span></p>
                        <ul id="earning_list" class="list-group mb-2">

                        </ul>
                        <p class="d-flex text-dark justify-content-between"><strong>Total Earnings</strong><span>₱<span
                                    id="gross_pay">0.00</span></span></p>
                    </div>
                    <!-- Deductions -->
                    <div class="mb-3">
                        <p><strong>LESS : DEDUCTIONS :</strong></p>
                        <ul id="deduction_list" class="list-group mb-2">

                        </ul>
                        <p class="d-flex text-dark justify-content-between"><strong>TOTAL
                                DEDUCTIONS</strong><span>₱<span id="total_deductions">0.00</span></span></p>
                    </div>
                    <!-- Net Pay -->
                    <div class="mb-3">
                        <p class="d-flex text-dark justify-content-between"><strong>NET PAY FOR
                                30TH</strong><span>₱<span id="net_pay">0.00</span></span></p>
                    </div>
                    <!-- Prepared by -->
                    <div class="text-center mt-4">
                        <p class=" text-dark">Prepared by:</p>
                        <p class=" text-dark"><strong>Julius Baguio</strong></p>
                        <p class=" text-dark">HR Staff</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="printPayslipBtn" class="btn btn-success">Save/Print Payslip</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ADD ITEM MODAL -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="modal_title">Add Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="itemForm">
                    <input type="hidden" id="user_id">

                    <!-- PAY TYPE -->
                    <div class="mb-3">
                        <label class="form-label">Payment Type</label>
                        <select id="salary_type" class="form-control">
                            <option value="">Select type</option>
                            <option value="direct">Direct Pay</option>
                            <option value="hourly">Hourly Pay</option>
                        </select>
                    </div>

                    <!-- DIRECT PAY -->
                    <div id="direct_pay" class="d-none">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input type="text" id="item_desc" class="form-control" placeholder="Enter description">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" id="item_amount" class="form-control" placeholder="0.00">
                        </div>
                    </div>

                    <!-- HOURLY PAY -->
                    <div id="hourly_pay" class="d-none">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input type="text" id="hourly_desc" class="form-control" placeholder="Enter description">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hours Worked</label>
                            <input type="number" id="hours_worked" class="form-control" placeholder="Hours">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pay Rate (₱ per hour)</label>
                            <input type="number" id="pay_rate" class="form-control" placeholder="Rate per hour">
                        </div>
                    </div>

                    <input type="hidden" id="item_type">

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" id="saveItemBtn">Save</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>



<script>
    $(document).ready(function () {

        // open modal for earnings
        $("#add_earning").on("click", function () {
            $("#modal_title").text("Add Basic Salary");
            $("#item_type").val("earning");
            $("#salary_type").val("");
            $("#addItemModal").modal("show");
        });

        // open modal for deductions
        $("#add_deduction").on("click", function () {
            $("#modal_title").text("Add Deduction");
            $("#item_type").val("deduction");
            $("#addItemModal").modal("show");
        });

        $("#salary_type").on("change", function () {
            let type = $(this).val();
            let action = $("#item_type").val();

            if (action === "deduction") {
                $("#direct_pay").removeClass("d-none");
                $("#hourly_pay").addClass("d-none");
                $("#salary_type").val("direct");

                $("#hours_worked, #pay_rate, #hourly_desc").val("");
            } else {
                if (type === "direct") {
                    $("#direct_pay").removeClass("d-none");
                    $("#hourly_pay").addClass("d-none");
                } else if (type === "hourly") {
                    $("#hourly_pay").removeClass("d-none");
                    $("#direct_pay").addClass("d-none");
                } else {
                    $("#direct_pay, #hourly_pay").addClass("d-none");
                }
            }
        });

        $(document).on("input", "#hours_worked, #pay_rate", function () {
            let action = $("#item_type").val();

            if (action === "deduction") {
                let hours = parseFloat($("#hours_worked").val()) || 0;
                let rate = parseFloat($("#pay_rate").val()) || 0;
                let total = (hours * rate).toFixed(2);

                $("#item_amount").val(total);

                $("#hours_worked, #pay_rate, #hourly_desc").val("");
            } else if ($("#salary_type").val() === "hourly") {
                let hours = parseFloat($("#hours_worked").val()) || 0;
                let rate = parseFloat($("#pay_rate").val()) || 0;
                let total = (hours * rate).toFixed(2);
                $("#hourly_total").val(total);
            }
        });

        $(document).on("submit", "#itemForm", function (e) {
            e.preventDefault();

            let action = $("#item_type").val();
            let payType = $("#salary_type").val();
            let description, amount, hours, rate;

            if (action === "deduction") {
                description = $("#item_desc").val().trim();
                amount = $("#item_amount").val();

                if (!description || !amount) {
                    alert("Fill in deduction fields.");
                    return;
                }

                hours = null;
                rate = null;
                payType = "direct";

            } else {
                if (payType === "direct") {
                    description = $("#item_desc").val().trim();
                    amount = $("#item_amount").val();

                    if (!description || !amount) {
                        alert("Fill in all direct pay fields.");
                        return;
                    }

                    hours = null;
                    rate = null;

                } else if (payType === "hourly") {
                    description = $("#hourly_desc").val().trim();
                    hours = $("#hours_worked").val();
                    rate = $("#pay_rate").val();

                    if (!description || !hours || !rate) {
                        alert("Complete hourly pay fields.");
                        return;
                    }

                    amount = (hours * rate).toFixed(2);
                }
            }

            $.ajax({
                url: `${base_url}/authentication/transact_action.php?action=earduct`,
                method: "POST",
                dataType: "json",
                data: {
                    user_id: $("#user_id").val(),
                    action: action,
                    pay_type: payType,
                    description: description,
                    hours: hours,
                    rate: rate,
                    amount: amount
                },
                success: function (res) {
                    if (res.status) {
                        alert(res.message);
                        $("#addItemModal").modal("hide");
                        $("#itemForm")[0].reset();
                        $("#direct_pay, #hourly_pay").addClass("d-none");
                    } else {
                        alert(res.message || res.error);
                    }
                },
                error: function (xhr) {
                    alert("Error saving item.");
                }
            });
        });
        $("#saveItemBtn").on("click", function () {
            $("#itemForm").submit();
        });

        $('#printmodal').on('click', function () {

            var element = document.getElementById('payslipModalLabel');

            // Open a new window for printing
            var printWindow = window.open('_blank', 'width=600,height=800');

            printWindow.document.write(`
                <html>
                <head>
                    <title>Payslip</title>
                    <style>
                        /* Page setup for half bond paper */
                        @page { size: 5.5in 8.5in; margin: 0.4in; }
                        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 12pt; margin:0; padding:0; }
                        .card {
                            width: 100%;
                            max-width: 100%;
                            border: 1px solid #000;
                            padding: 15px;
                            box-sizing: border-box;
                        }
                        .text-center { text-align: center; }
                        .header h6 { margin: 0; font-weight: bold; font-size: 14pt; }
                        .header small { display: block; font-size: 10pt; }
                        .section { margin-top: 10px; }
                        .d-flex { display: flex; justify-content: space-between; }
                        .fw-bold { font-weight: 600; }
                        .list-group { list-style-type: none; padding-left: 0; margin-bottom: 5px; }
                        .list-group li { display: flex; justify-content: space-between; padding: 2px 0; font-size: 11pt; border-bottom: 0.5px solid #ccc; }
                        .netpay { font-size: 13pt; font-weight: bold; margin-top: 10px; }
                        .footer { margin-top: 20px; text-align: center; font-size: 11pt; }
                        hr { border: 0; border-top: 1px solid #000; margin: 5px 0; }
                    </style>
                </head>
                <body>
                    <div class="card">
                        <div class="text-center header">
                            <h6>ZAMBOANGA PUERICULTURE CENTER</h6>
                            <small>ORGANIZATION NO. 144 INC.</small>
                            <small>ZAMBOANGA CITY</small>
                            <h6 style="text-decoration: underline; margin-top: 5px;">P A Y S L I P</h6>
                        </div>

                        <div class="section">
                            <div class="d-flex"><strong>Name:</strong> <span id="print_name">${document.getElementById('profile_name').innerText}</span></div>
                            <div class="d-flex"><strong>Designation:</strong> <span id="print_position">${document.getElementById('profile_position').innerText}</span></div>
                            <div class="d-flex"><strong>Pay Period:</strong> <span id="print_paydate">${document.getElementById('pay_date').innerText}</span></div>
                        </div>

                        <div class="section">
                            <div class="fw-bold">BASIC SALARY</div>
                            <ul class="list-group">
                                <li>Salary <span>₱${document.getElementById('basic_pay').innerText}</span></li>

                                ${(() => {
                    const items = Array.from(document.querySelectorAll('#basic_salary li'))
                        .map(li => `<li>${li.children[0].innerText} <span>${li.children[1].innerText}</span></li>`);

                    return items.length
                        ? items.join('')
                        : `<li>--- <span></span></li>`;
                            })()
                            }
                            </ul>
                            <div class="d-flex fw-bold">
                                Gross Pay <span>₱${document.getElementById('gross_pay').innerText}</span>
                            </div>
                        </div>
                        <div class="section">
                            <div class="fw-bold">LESS: DEDUCTIONS</div>
                            <ul class="list-group">
                                ${(() => {
                    const items = Array.from(document.querySelectorAll('#deduction_list li'))
                        .map(li => `<li>${li.children[0].innerText} <span>${li.children[1].innerText}</span></li>`);

                    return items.length
                        ? items.join('')
                        : `<li>--- <span></span></li>`;
                })()
                }
                            </ul>

                            <div class="d-flex fw-bold">
                                Total Deductions <span>₱${document.getElementById('total_deductions').innerText}</span>
                            </div>
                        </div>
                        <div class="section netpay">
                            <div class="d-flex">
                                <span>Net Pay:</span>
                                <span>₱${document.getElementById('net_pay').innerText}</span>
                            </div>
                        </div>
                        <div class="footer">
                            Prepared by:<br>
                            <strong>Julius Baguio</strong><br>
                            HR Staff
                        </div>
                    </div>
                </body>
                </html>
            `) || '';

            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        });
        // Fetch payroll data via AJAX
        $.ajax({
            type: "GET",
            url: `${base_url}/authentication/transact_action.php?action=get_payroll_data`,
            dataType: "json",   // must be json
            success: function (response) {
                if (response.status == 1) {
                    let tbody = '';
                    response.data.forEach(emp => {
                        tbody += `
                    <tr>
                        <td>${emp.employeeID}</td>
                        <td class="text-uppercase">${emp.firstname} ${emp.middlename}, ${emp.lastname}</td>
                        <td>${emp.position}</td>
                        <td>${emp.department || ''}</td>
                        <td>${emp.date_hired || 0}</td>
                        <td>${emp.user_request || 0}</td>
                        <td class="text-center">
                            <button class="btn btn-primary btn-sm p-2 viewbtn" data-id="${emp.employee_id}"><i class="fa fa-eye"></i></button>
                        </td>
                    </tr>
                    `;
                    });
                    $('#employee_table').html(tbody);
                    $("#payrollTable").DataTable({
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
                            lengthMenu: "_MENU_  Payroll Data", // custom text
                            search: "Search:",                     // optional custom search text
                            info: "Showing _START_ to _END_ of _TOTAL_ entries",
                            infoFiltered: "(filtered from _MAX_ total records)",

                        }
                    });

                } else {
                    $('#employee_table').html('<tr><td colspan="7" class="text-center">No data found</td></tr>');
                }
            },
            error: function (err) {
                console.error(err);
                $('#employee_table').html('<tr><td colspan="7" class="text-center">Error fetching data</td></tr>');
            }


        });

        const employeeData = {};
        $('#payrollTable tbody').on('click', '.viewbtn', function () {
            let id = $(this).data('id');

            // Show payslip panel
            $("#user_id").val(id);
            $("#payslipReview").removeClass("d-none");
            // Hide summary + table
            $("#payroll-summary").addClass("d-none");
            $("#payroll-table-container").addClass("d-none");

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
            $("#payslipReview").addClass("d-none");
            $("#payroll-summary").removeClass("d-none");
            $("#payroll-table-container").removeClass("d-none");
        });

        $(document).on("click", ".remove-earning", function () {
            let earningId = $(this).data("id");

            if (confirm("Are you sure you want to remove this earning?")) {
                $.ajax({
                    url: `${base_url}/authentication/transact_action.php?action=delete_items`,
                    method: "POST",
                    data: {
                        id: earningId,
                        action: "earning"
                    },
                    success: function (res) {
                        if (res.status) {
                            alert(res.message);

                        } else {
                            alert(res.message || res.error);
                        }
                    }
                });
            }
        });

        $(document).on("click", ".remove-deduction", function () {

            let deductionId = $(this).data("id");
            alert(deductionId)
            if (confirm("Are you sure you want to remove this deduction?")) {
                $.ajax({
                    url: `${base_url}/authentication/transact_action.php?action=delete_items`,
                    method: "POST",
                    data: {
                        id: deductionId,
                        action: "deduction"
                    },
                    success: function (res) {
                        if (res.status) {
                            alert(res.message);
                        } else {
                            alert(res.message || res.error);
                        }
                    }
                });
            }
        });


        const sampleData = {

            profile: {
                name: "Juan Dela Cruz",
                id: "EMP-00123",
                position: "Software Developer",
                department: "IT Department",
                photo: "http://localhost/zclient/assets/image/users.png"
            },

            pay: {
                gross: 35000,
                deductions: 5200,
                net: 29800,
                date: "2025-01-30"
            },

            deductions: [
                { label: "SSS Contribution", amount: 600 },
                { label: "PhilHealth", amount: 450 },
                { label: "Pag-IBIG", amount: 200 },
                { label: "Late / Absences", amount: 1200 },
                { label: "Cash Advance", amount: 2750 }
            ],

            benefits: [
                { label: "Rice Subsidy", amount: 1500 },
                { label: "Health Allowance", amount: 1000 },
                { label: "Transportation", amount: 800 }
            ],

            history: [
                { date: "2024-12-30", gross: 35000, deductions: 5000, net: 30000 },
                { date: "2024-11-30", gross: 35000, deductions: 4800, net: 30200 },
                { date: "2024-10-30", gross: 35000, deductions: 4700, net: 30300 },
                { date: "2024-12-30", gross: 35000, deductions: 5000, net: 30000 },
                { date: "2024-11-30", gross: 35000, deductions: 4800, net: 30200 },
                { date: "2024-10-30", gross: 35000, deductions: 4700, net: 30300 },
            ],

            loans: [
                { label: "SSS Salary Loan", balance: 15000 },
                { label: "Pag-IBIG Multi-Purpose Loan", balance: 4200 },
                { label: "SSS Salary Loan", balance: 15000 },
                { label: "Pag-IBIG Multi-Purpose Loan", balance: 4200 },
                { label: "SSS Salary Loan", balance: 15000 },
                { label: "Pag-IBIG Multi-Purpose Loan", balance: 4200 },
            ],

            requests: [
                { type: "Leave Request", status: "Approved", date: "2025-01-15" },
                { type: "Overtime Request", status: "Pending", date: "2025-01-10" },
                { type: "Schedule Adjustment", status: "Denied", date: "2025-01-03" },
                { type: "Leave Request", status: "Approved", date: "2025-01-15" },
                { type: "Overtime Request", status: "Pending", date: "2025-01-10" },
                { type: "Schedule Adjustment", status: "Denied", date: "2025-01-03" },
            ],

            attendance: [
                { date: "2025-01-29", in: "08:01 AM", out: "05:02 PM", status: "Present" },
                { date: "2025-01-28", in: "08:05 AM", out: "05:10 PM", status: "Late" },
                { date: "2025-01-27", in: "-", out: "-", status: "Absent" },
                { date: "2025-01-29", in: "08:01 AM", out: "05:02 PM", status: "Present" },
                { date: "2025-01-28", in: "08:05 AM", out: "05:10 PM", status: "Late" },
                { date: "2025-01-27", in: "-", out: "-", status: "Absent" },
            ]
        };


        // ===== INSERT PAYROLL HISTORY =====
        sampleData.history.forEach(row => {
            $("#history_table").append(`
            <tr>
                <td>${row.date}</td>
                <td>₱${row.gross.toLocaleString()}</td>
                <td>₱${row.deductions.toLocaleString()}</td>
                <td>₱${row.net.toLocaleString()}</td>
            </tr>
        `);
        });


        // ===== INSERT LOANS =====
        sampleData.loans.forEach(l => {
            $("#loan_list").append(`
            <li class="list-group-item d-flex justify-content-between">
                <span>${l.label}</span>
                <strong>₱${l.balance.toLocaleString()}</strong>
            </li>
        `);
        });


        // ===== INSERT REQUESTS =====
        sampleData.requests.forEach(r => {
            $("#request_list").append(`
            <li class="list-group-item d-flex justify-content-between">
                <span>${r.type} — <em>${r.date}</em></span>
                <span class="badge bg-${r.status === "Approved" ? "success" :
                    r.status === "Pending" ? "warning" : "danger"}">
                    ${r.status}
                </span>
            </li>
        `);
        });


        // ===== INSERT ATTENDANCE =====
        sampleData.attendance.forEach(a => {
            $("#attendance_table").append(`
            <tr>
                <td>${a.date}</td>
                <td>${a.in}</td>
                <td>${a.out}</td>
                <td>${a.status}</td>
            </tr>
        `);
        });
    });
</script>