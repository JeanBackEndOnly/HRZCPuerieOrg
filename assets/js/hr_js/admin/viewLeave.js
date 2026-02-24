
document.addEventListener("DOMContentLoaded", () => {
    const leaveTypes = ["vacation", "sick", "special"];
    const leaveTypeInput = document.querySelector("input[name='leaveType']:checked");
    const numberOfDaysInput = document.querySelector("input[name='numberOfDays']");

    let selectedLeaveType = "";
    if (leaveTypeInput) {
        const val = leaveTypeInput.value.toLowerCase();
        if (val.includes("vacation")) selectedLeaveType = "vacation";
        else if (val.includes("sick")) selectedLeaveType = "sick";
        else if (val.includes("special")) selectedLeaveType = "special";
    }

    leaveTypes.forEach(type => {
        const balance = document.querySelector(`input[name='${type}Balance']`);
        const earned = document.querySelector(`input[name='${type}Earned']`);
        const credits = document.querySelector(`input[name='${type}Credits']`);
        const lessLeave = document.querySelector(`input[name='${type}LessLeave']`);
        const balanceToDate = document.querySelector(`input[name='${type}BalanceToDate']`);

        function updateCalculation() {
            const balVal = parseFloat(balance.value) || 0;
            const earnedVal = parseFloat(earned.value.replace('+', '')) || 0;
            let lessVal = parseFloat(lessLeave.value) || 0;
            const leaveDays = parseFloat(numberOfDaysInput.value) || 0;

            if (type === selectedLeaveType) {
                lessVal = leaveDays;
                lessLeave.value = leaveDays;
            }

            const totalCredits = balVal + earnedVal;
            const finalBalance = totalCredits - lessVal;

            credits.value = totalCredits.toFixed(2);
            balanceToDate.value = finalBalance.toFixed(2);
        }

        [balance, earned, lessLeave, numberOfDaysInput].forEach(input => {
            input?.addEventListener("input", updateCalculation);
        });

        if (balance && earned && credits && lessLeave && balanceToDate) {
            updateCalculation();
        }
    });
});

// Form submission handling
$(document).ready(function() {
    // Handle confirmation modal submit
    $('#confirmSubmitBtn').on('click', function() {
        // Close confirmation modal
        $('#updateModalEBG').modal('hide');

        // Submit the main form
        $('#leaveProcess-form').submit();
    });

    // Main form submission
    $('#leaveProcess-form').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);

        if ($form.data("isSubmitted")) return;
        $form.data("isSubmitted", true);

        const formData = new FormData(this);
        const $submitBtn = $('#showConfirmationBtn');

        $submitBtn.prop("disabled", true).html(
            '<i class="fas fa-spinner fa-spin me-1"></i> Processing...');

        $.ajax({
            url: base_url + "authentication/action.php?action=leaveProcess_form",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                Swal.fire({
                    title: response.status === 1 ? 'Success!' : 'Error!',
                    text: response.message,
                    icon: response.status === 1 ? 'success' : 'error',
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    $('#leaveDetailsModal').modal('hide');
                    window.location.href = "index.php?page=contents/leave";
                });
            },
            error: function(jqXHR, textStatus, err) {
                console.error("AJAX error:", textStatus, err);
                Swal.fire({
                    title: 'Connection Error',
                    text: 'Please check your connection and try again.',
                    icon: 'error',
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            complete: function() {
                $form.data("isSubmitted", false);
                $submitBtn.prop("disabled", false).html(
                    '<i class="fas fa-check"></i> Submit Leave');
            }


        });
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const printBtn = document.querySelector(".btn.btn-info.m-0");
    if (printBtn) {
        printBtn.addEventListener("click", generatePDF);
    }
});

function generatePDF() {
    const formElement = document.querySelector("#leaveProcess-form");
    if (!formElement) {
        alert("Leave form not found to generate PDF.");
        return;
    }

    const clonedForm = formElement.cloneNode(true);

    // Remove interactive or hidden elements
    clonedForm.querySelectorAll(
        "button, .modal-footer, .modal-header.bg-primary, .btn, [data-bs-toggle], [data-bs-target], input[type='hidden']"
    ).forEach(el => el.remove());

    // Convert checked radio buttons to text
    clonedForm.querySelectorAll('input[type="radio"]').forEach(radio => {
        if (radio.checked) {
            const label = document.createElement('span');
            label.textContent = '✓ ' + (radio.nextElementSibling?.textContent.trim() || radio.value);
            label.style.marginLeft = '5px';
            radio.parentNode.replaceChild(label, radio);
        } else {
            radio.remove();
        }
    });

    // Simplify readonly fields
    clonedForm.querySelectorAll('input[readonly], textarea[readonly]').forEach(input => {
        input.style.border = 'none';
        input.style.background = 'transparent';
    });

    const orgHeader = clonedForm.querySelector("h5.w-100.text-center.m-0");
    const pdfContainer = document.createElement('div');
    pdfContainer.style.padding = '20px';
    pdfContainer.style.fontFamily = 'Arial, sans-serif';

    if (orgHeader) {
        let current = orgHeader;
        while (current) {
            pdfContainer.appendChild(current.cloneNode(true));
            current = current.nextElementSibling;
        }
    } else {
        pdfContainer.innerHTML = clonedForm.innerHTML;
    }

    const options = {
        margin: [0.5, 0.5, 0.5, 0.5],
        filename: `Leave_Request_${document.querySelector('input[name="lastname"]')?.value || 'Form'}.pdf`,
        image: {
            type: 'jpeg',
            quality: 1
        },
        html2canvas: {
            scale: 2,
            useCORS: true
        },
        jsPDF: {
            unit: 'in',
            format: 'a4',
            orientation: 'portrait'
        }
    };

    const styles = `
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 11px !important;
                color: #000;
                margin: 0;
                padding: 0;
            }
            .w-100{
                width: 100%;
                text-align: center;
            }
            h5, strong {
                text-align: center;
                display: flex;
            }
            .form-label {
                font-weight: bold;
                font-size: 11px;
                margin-bottom: 0 !important;
                display: flex;
            }

            .form-control, input, textarea {
                border: none;
                border-bottom: 1px solid #000;
                background: transparent;
                font-size: 11px;
                box-sizing: border-box;
            }
                .name-section{
                    display: flex;
                    flex-direction: row !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }

            .modal-body {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: wrap;
                gap: 8px;
            }

            /* Fix Bootstrap columns for PDF (make row layout visible) */
            .row {
                display: flex !important;
                flex-wrap: wrap !important;
                width: 100%;
            }
            .col-md-3, .col-md-4, .col-md-6, .col-md-12 {
                flex: 1;
                min-width: 150px;
                padding: 4px;
            }
            .col-md-3 { display: flex; flex-direction: row !important; flex-basis: 25%; }
            .col-md-4 { display: flex; flex-direction: row !important; flex-basis: 33%; }
            .col-md-6 { display: flex; flex-direction: row !important; flex-basis: 50%; }
            .col-md-12 { display: flex; flex-direction: row !important; flex-basis: 100%; }

            .approvalContent {
                border: 1px solid #000;
                margin-top: 15px;
                padding: 10px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
                font-size: 10.5px;
            }
            th, td {
                border: 1px solid #000;
                padding: 4px;
                text-align: center;
            }

            .text-center { text-align: center; }
            .text-danger { color: #d00; }

            @page { size: A4; margin: 0.5in; }
        </style>
    `;

    const html = `
        <!DOCTYPE html>
        <html>
        <head><meta charset="utf-8">${styles}</head>
        <body>${pdfContainer.innerHTML}</body>
        </html>
    `;

    const iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    document.body.appendChild(iframe);
    const doc = iframe.contentDocument || iframe.contentWindow.document;
    doc.open();
    doc.write(html);
    doc.close();

    html2pdf().set(options).from(doc.body).save().then(() => {
        document.body.removeChild(iframe);
    });
}