$(document).ready(function() {
    $('#update').ready(function(e) {
        const careerPath_auth_type_as_id = document.getElementById("careerPath_auth_type_as_id").value =
            'Update';
    });
    $('#Promote').on("click", function(e) {
        const careerPath_auth_type_as_id = document.getElementById("careerPath_auth_type_as_id").value =
            'Promote';
    });
    $('#Demote').on("click", function(e) {
        const careerPath_auth_type_as_id = document.getElementById("careerPath_auth_type_as_id").value =
            'Demote';
    });

});
function simpleSearch(inputId, tbodyId, noResultText, colspanCount) {
    const input = document.getElementById(inputId);
    const tbody = document.getElementById(tbodyId); // Changed from getElementById to querySelector

    if (!input || !tbody) {
        console.error(`Element not found: inputId=${inputId}, tbodyId=${tbodyId}`);
        return;
    }

    input.addEventListener("input", function() {
        const term = this.value.toLowerCase().trim();
        const rows = tbody.getElementsByTagName("tr");
        let foundAny = false;

        // Remove old "no results"
        const oldMsg = document.getElementById("no-results-" + tbodyId);
        if (oldMsg) oldMsg.remove();

        for (let row of rows) {
            const cells = row.getElementsByTagName("th"); // Your tables use <th> in tbody
            if (cells.length === 0) continue;

            // Reset highlighting
            for (let cell of cells) {
                cell.innerHTML = cell.textContent; // Reset HTML
            }

            if (term === "") {
                row.style.display = "";
                continue;
            }

            let rowMatch = false;

            for (let cell of cells) {
                const text = cell.textContent.toLowerCase();

                if (text.includes(term)) {
                    rowMatch = true;
                    cell.innerHTML = cell.textContent.replace(
                        new RegExp(term, "gi"),
                        m => `<span class="search-highlight">${m}</span>`
                    );
                }
            }

            row.style.display = rowMatch ? "" : "none";
            if (rowMatch) foundAny = true;
        }

        // Add "no results" row
        if (!foundAny && term !== "") {
            const noRow = document.createElement("tr");
            noRow.id = "no-results-" + tbodyId;
            noRow.innerHTML =
                `<td colspan="${colspanCount}" class="text-center text-muted py-3">${noResultText}</td>`;
            tbody.appendChild(noRow);
        }
    });
}

// Then call them as before:
simpleSearch("searchDepartments", "departments",
    "No departments found matching your search", 5);

simpleSearch("searchJobtitles", "jobtitles",
    "No job titles found matching your search", 5);
// Search functionality for Career Paths
document.addEventListener('DOMContentLoaded', function() {
    const searchCareerPaths = document.getElementById('searchCareerPaths');

    searchCareerPaths.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase().trim();

        // Reset if search is empty
        if (searchTerm === '') {
            resetCareerPathsSearch();
            return;
        }

        // Search and highlight in career paths table
        searchAndHighlightTable('careerPathEmployees', searchTerm);
    });

    function searchAndHighlightTable(tableId, searchTerm) {
        const table = document.getElementById(tableId);
        if (!table) return;

        const rows = table.getElementsByTagName('tr');
        let hasVisibleRows = false;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;

            if (cells.length === 0) continue;

            // Reset cell contents first
            resetRowHighlights(row);

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];

                // Skip action cells
                if (cell.querySelector('button') || cell.querySelector('a')) {
                    continue;
                }

                const originalText = cell.textContent;
                const lowerText = originalText.toLowerCase();

                if (lowerText.includes(searchTerm)) {
                    found = true;
                    hasVisibleRows = true;

                    // Highlight the matched text
                    const highlightedText = originalText.replace(
                        new RegExp(searchTerm, 'gi'),
                        match => `<span class="search-highlight">${match}</span>`
                    );
                    cell.innerHTML = highlightedText;
                }
            }

            row.style.display = found ? '' : 'none';
        }

        // Show "no results" message if needed
        showNoResultsMessage(tableId, hasVisibleRows);
    }

    function resetRowHighlights(row) {
        const cells = row.getElementsByTagName('td');
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            if (cell.querySelector('.search-highlight')) {
                cell.innerHTML = cell.textContent; // Remove HTML tags, keep text
            }
        }
    }

    function resetCareerPathsSearch() {
        const table = document.getElementById('careerPathEmployees');
        if (!table) return;

        const rows = table.getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            resetRowHighlights(row);
            row.style.display = '';
        }
        hideNoResultsMessage('careerPathEmployees');
    }

    function showNoResultsMessage(tableId, hasVisibleRows) {
        let noResultsRow = document.getElementById(`no-results-${tableId}`);

        if (!hasVisibleRows && !noResultsRow) {
            const table = document.getElementById(tableId);
            noResultsRow = document.createElement('tr');
            noResultsRow.id = `no-results-${tableId}`;
            noResultsRow.innerHTML =
                `<td colspan="7" class="text-center text-muted py-3">No employees found matching your search</td>`;
            table.appendChild(noResultsRow);
        } else if (hasVisibleRows && noResultsRow) {
            noResultsRow.remove();
        }
    }

    function hideNoResultsMessage(tableId) {
        const noResultsRow = document.getElementById(`no-results-${tableId}`);
        if (noResultsRow) {
            noResultsRow.remove();
        }
    }
});

// Add CSS for highlighting (only once)
if (!document.querySelector('#search-highlight-style')) {
    const style = document.createElement('style');
    style.id = 'search-highlight-style';
    style.textContent = `
        .search-highlight {
            background-color: #ffeb3b;
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: bold;
            color: #333;
        }
    `;
    document.head.appendChild(style);
}
// Print functionality for career path history
document.getElementById('print_history').addEventListener('click', function() {
    // Get modal content
    const modal = document.getElementById('viewCareerPath');
    const modalContent = modal.querySelector('.modal-content');
    const modalBody = modal.querySelector('.modal-body');

    // Check if there's content to print
    if (!modalBody || modalBody.innerHTML.includes('spinner-border')) {
        alert('Please wait for the data to load before printing.');
        return;
    }

    // Create a new window for printing
    const printWindow = window.open('', '_blank', 'width=800,height=600');

    // Get employee info if available
    let employeeInfo = '';
    const employeeDetails = modalBody.querySelector('.card-body');
    if (employeeDetails) {
        employeeInfo = employeeDetails.innerHTML;
    }

    // Get history table if available
    let historyTable = '';
    const table = modalBody.querySelector('table');
    if (table) {
        const tableClone = table.cloneNode(true);

        // Add print-specific classes
        tableClone.classList.add('table-print');
        tableClone.style.width = '100%';
        tableClone.style.borderCollapse = 'collapse';

        // Style table headers
        const thElements = tableClone.querySelectorAll('th');
        thElements.forEach(th => {
            th.style.backgroundColor = '#f8f9fa';
            th.style.border = '1px solid #dee2e6';
            th.style.padding = '8px';
            th.style.textAlign = 'left';
        });

        // Style table cells
        const tdElements = tableClone.querySelectorAll('td');
        tdElements.forEach(td => {
            td.style.border = '1px solid #dee2e6';
            td.style.padding = '8px';
        });

        // Style table rows
        const trElements = tableClone.querySelectorAll('tr');
        trElements.forEach((tr, index) => {
            if (index > 0) { // Skip header row
                tr.style.borderTop = '1px solid #dee2e6';
            }
        });

        historyTable = tableClone.outerHTML;
    }

    // Get current date for print header
    const now = new Date();
    const printDate = now.toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });

    // Write print content
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Career Path History - ${printDate}</title>
            <style>
                @media print {
                    body { 
                        font-family: Arial, sans-serif; 
                        margin: 20px; 
                        color: #333;
                    }
                    .print-header {
                        text-align: center;
                        border-bottom: 2px solid #dc3545;
                        padding-bottom: 15px;
                        margin-bottom: 20px;
                    }
                    .print-header h1 {
                        color: #dc3545;
                        margin-bottom: 5px;
                    }
                    .print-header .print-date {
                        color: #666;
                        font-size: 14px;
                    }
                    .employee-info {
                        background-color: #f8f9fa;
                        border: 1px solid #dee2e6;
                        border-radius: 4px;
                        padding: 15px;
                        margin-bottom: 20px;
                    }
                    .table-print {
                        width: 100%;
                        margin-bottom: 20px;
                    }
                    .table-print th {
                        background-color: #f8f9fa;
                        font-weight: bold;
                    }
                    .table-print td, .table-print th {
                        border: 1px solid #dee2e6;
                        padding: 8px;
                    }
                    .no-data {
                        text-align: center;
                        color: #666;
                        font-style: italic;
                        padding: 20px;
                    }
                    .print-footer {
                        margin-top: 30px;
                        padding-top: 10px;
                        border-top: 1px solid #dee2e6;
                        font-size: 12px;
                        color: #666;
                        text-align: center;
                    }
                    @page {
                        size: A4 landscape;
                        margin: 15mm;
                    }
                }
                @media screen {
                    body { 
                        font-family: Arial, sans-serif; 
                        margin: 20px; 
                        color: #333;
                    }
                    .print-header {
                        text-align: center;
                        border-bottom: 2px solid #dc3545;
                        padding-bottom: 15px;
                        margin-bottom: 20px;
                    }
                    .print-header h1 {
                        color: #dc3545;
                        margin-bottom: 5px;
                    }
                    .print-header .print-date {
                        color: #666;
                        font-size: 14px;
                    }
                    .employee-info {
                        background-color: #f8f9fa;
                        border: 1px solid #dee2e6;
                        border-radius: 4px;
                        padding: 15px;
                        margin-bottom: 20px;
                    }
                    .table-print {
                        width: 100%;
                        margin-bottom: 20px;
                        border-collapse: collapse;
                    }
                    .table-print th {
                        background-color: #f8f9fa;
                        font-weight: bold;
                    }
                    .table-print td, .table-print th {
                        border: 1px solid #dee2e6;
                        padding: 8px;
                    }
                    .no-data {
                        text-align: center;
                        color: #666;
                        font-style: italic;
                        padding: 20px;
                    }
                    .print-footer {
                        margin-top: 30px;
                        padding-top: 10px;
                        border-top: 1px solid #dee2e6;
                        font-size: 12px;
                        color: #666;
                        text-align: center;
                    }
                }
            </style>
        </head>
        <body>
            <div class="print-header">
                <h1>Career Path History</h1>
                <div class="print-date">Printed: ${printDate}</div>
            </div>
            
            ${employeeInfo ? `<div class="employee-info">${employeeInfo}</div>` : ''}
            
            ${historyTable ? historyTable : '<div class="no-data">No career history data available for printing</div>'}
            
            <div class="print-footer">
                <p>Confidential - For internal use only</p>
                <p>Generated by Career Path Management System</p>
            </div>
            
            <script>
                // Auto print when page loads
                window.onload = function() {
                    setTimeout(function() {
                        window.print();
                        // Close window after printing or if user cancels
                        setTimeout(function() {
                            window.close();
                        }, 1000);
                    }, 500);
                };
                
                // Also allow manual print
                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                        e.preventDefault();
                        window.print();
                    }
                });
            <\/script>
        </body>
        </html>
    `);

    printWindow.document.close();
});

// Alternative: Simple print function for the modal content only
function printCareerPathHistory() {
    const modalContent = document.querySelector('#viewCareerPath .modal-content');
    if (!modalContent) return;

    // Store original display settings
    const originalDisplay = modalContent.style.display;

    // Show modal content for printing
    modalContent.style.display = 'block';

    // Print the modal content
    window.print();

    // Restore original display
    modalContent.style.display = originalDisplay;
}