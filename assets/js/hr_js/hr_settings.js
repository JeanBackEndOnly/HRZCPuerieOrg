// hr_settings.js
document.addEventListener('DOMContentLoaded', function() {
    initializeTabs();
    initializeSearch();
    initializePrintSchedule();
    initializeCSVDownload();
});

function initializeTabs() {
    const tabButtons = document.querySelectorAll('#hr_settingsTabs .nav-link');
    const tabContents = document.querySelectorAll('.tab-pane');
    
    // UI elements
    const displayButton = document.getElementById('displayButton');
    const displayFilter = document.getElementById('displayFilter');
    const displaySearch = document.getElementById('displaySearch');
    const display_csv = document.getElementById('display-csv');
    
    // Initialize tabs - hide all except active
    tabContents.forEach(content => {
        if (!content.classList.contains('active')) {
            content.style.display = 'none';
        }
    });
    
    // Set initial state (Schedule Template tab is active)
    updateUIVisibility('#schedule_template', displayButton, displayFilter, displaySearch, display_csv);
    
    tabButtons.forEach((button) => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active button
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.style.display = 'none';
                content.classList.remove('show', 'active');
            });
            
            // Show the selected tab
            const targetId = this.getAttribute('data-bs-target');
            const targetContent = document.querySelector(targetId);
            if (targetContent) {
                targetContent.style.display = 'flex';
                targetContent.classList.add('show', 'active');
                
                // Update UI visibility based on active tab
                updateUIVisibility(targetId, displayButton, displayFilter, displaySearch, display_csv);
                
                // Load data for print schedule tab
                if (targetId === '#print_schedule') {
                    loadScheduleData();
                } else if(targetId === '#employee_schedule') {
                    displayFilter.style.display = 'none !important';
                }
            }
        });
    });
}

function updateUIVisibility(targetId, displayButton, displayFilter, displaySearch, display_csv) {
    // Hide all first
    displayButton.style.display = 'none';
    displayFilter.style.display = 'none';
    displaySearch.style.display = 'none';
    display_csv.style.display = 'none';

    if (targetId === '#schedule_template') {
        displayButton.style.display = 'flex';
    } else if (targetId === '#employee_schedule') {
        displaySearch.style.display = 'block';
        displayFilter.style.display = 'none';
    } else if (targetId === '#print_schedule') {
        displayFilter.style.display = 'flex';
        display_csv.style.display = 'flex';
    }
}

// Updated search function for employee schedule cards
function initializeSearch() {
    const searchInput = document.getElementById('searchEmployee');
    if (!searchInput) return;
    
    const employeeContainer = document.getElementById('employee_schedule');
    if (!employeeContainer) return;
    
    // Get all employee card links
    const employeeCards = employeeContainer.querySelectorAll('a.col-md-4');
    
    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase().trim();
        
        employeeCards.forEach(card => {
            // Get employee name from the strong element with class 'font-13'
            const nameElement = card.querySelector('.font-13');
            // Get department and ID from the span element with class 'font-12'
            const deptElement = card.querySelector('.font-12');
            
            if (nameElement && deptElement) {
                const name = nameElement.textContent.toLowerCase();
                const deptAndId = deptElement.textContent.toLowerCase();
                
                // Show card if name OR department/ID matches the filter
                if (name.includes(filter) || deptAndId.includes(filter)) {
                    card.style.display = ''; // Show the card (revert to default display)
                } else {
                    card.style.display = 'none'; // Hide the card
                }
            }
        });
    });
    
    // Trigger initial search to show all cards
    setTimeout(() => {
        if (searchInput.value) {
            searchInput.dispatchEvent(new Event('keyup'));
        }
    }, 100);
}

function initializePrintSchedule() {
    // Filter elements
    const filterDepartment = document.getElementById('filter_department');
    const scheduleFrom = document.getElementById('scheduleFrom');
    const scheduleTo = document.getElementById('scheduleTo');
    
    if (!filterDepartment || !scheduleFrom || !scheduleTo) return;
    
    // Set default dates (current month)
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    
    scheduleFrom.value = formatDate(firstDay);
    scheduleTo.value = formatDate(lastDay);
    
    // Add event listeners for filter changes
    filterDepartment.addEventListener('change', loadScheduleData);
    scheduleFrom.addEventListener('change', loadScheduleData);
    scheduleTo.addEventListener('change', loadScheduleData);
}

function initializeCSVDownload() {
    const downloadBtn = document.getElementById('download-csv');
    
    if (downloadBtn) {
        downloadBtn.addEventListener('click', function() {
            downloadScheduleAsCSV();
        });
    }
}

function downloadScheduleAsCSV() {
    try {
        const csvContent = generateScheduleCSV();
        if (!csvContent) {
            alert('No data available to download');
            return;
        }
        
        // Get date range for filename
        const scheduleFrom = document.getElementById('scheduleFrom');
        const scheduleTo = document.getElementById('scheduleTo');
        const fromDate = scheduleFrom ? scheduleFrom.value : 'unknown';
        const toDate = scheduleTo ? scheduleTo.value : 'unknown';
        
        const filename = `schedule_${fromDate}_to_${toDate}.csv`;
        
        // Download the CSV
        downloadCSV(csvContent, filename);
    } catch (error) {
        console.error('Error generating CSV:', error);
        alert('Failed to generate CSV. Please try again.');
    }
}

function generateScheduleCSV() {
    const table = document.getElementById('scheduleTable');
    if (!table) return null;
    
    const rows = table.querySelectorAll('tr');
    if (rows.length === 0) return null;
    
    const csv = [];
    
    // Process each row
    rows.forEach(row => {
        const rowData = [];
        const cells = row.querySelectorAll('th, td');
        
        // Skip if this is the "no data" message row
        if (cells.length === 1 && cells[0].colSpan > 1) {
            return;
        }
        
        cells.forEach(cell => {
            // Get text content and clean it
            let cellText = cell.innerText.trim();
            
            // Handle schedule cells with line breaks (replace with space)
            cellText = cellText.replace(/\n/g, ' ').replace(/\s+/g, ' ').trim();
            
            // If cell is empty or just a dash, use empty string
            if (cellText === '—' || cellText === '') {
                rowData.push('');
            } else {
                // Escape quotes and wrap in quotes
                rowData.push('"' + cellText.replace(/"/g, '""') + '"');
            }
        });
        
        if (rowData.length > 0) {
            csv.push(rowData.join(','));
        }
    });
    
    return csv.join('\n');
}

function downloadCSV(csvContent, filename) {
    const blob = new Blob(["\uFEFF" + csvContent], { type: 'text/csv;charset=utf-8;' }); // Add BOM for UTF-8
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    
    link.setAttribute('href', url);
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function getDatesBetween(startDate, endDate) {
    const dates = [];
    let currentDate = new Date(startDate);
    const lastDate = new Date(endDate);
    
    while (currentDate <= lastDate) {
        dates.push(formatDate(currentDate));
        currentDate.setDate(currentDate.getDate() + 1);
    }
    return dates;
}

function loadScheduleData() {
    const filterDepartment = document.getElementById('filter_department');
    const scheduleFrom = document.getElementById('scheduleFrom');
    const scheduleTo = document.getElementById('scheduleTo');
    
    if (!filterDepartment || !scheduleFrom || !scheduleTo) return;
    
    const department = filterDepartment.value;
    const fromDate = scheduleFrom.value;
    const toDate = scheduleTo.value;
    
    if (!fromDate || !toDate) {
        alert('Please select both from and to dates');
        return;
    }
    
    if (new Date(fromDate) > new Date(toDate)) {
        alert('From date cannot be greater than to date');
        return;
    }
    
    // Show loading state
    const tableBody = document.getElementById('scheduleTableBody');
    if (tableBody) {
        tableBody.innerHTML = '<tr><td colspan="100" class="text-center">Loading schedules...</td></tr>';
    }
    
    // Fetch schedule data via AJAX
    fetch(base_url + 'authentication/get_schedules.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            department: department,
            from_date: fromDate,
            to_date: toDate
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        updateScheduleTable(data, fromDate, toDate);
    })
    .catch(error => {
        console.error('Error:', error);
        const tableBody = document.getElementById('scheduleTableBody');
        if (tableBody) {
            tableBody.innerHTML = '<tr><td colspan="100" class="text-center text-danger">Error loading schedules. Please try again.</td></tr>';
        }
    });
}

function updateScheduleTable(data, fromDate, toDate) {
    const dates = getDatesBetween(fromDate, toDate);
    const tableHead = document.querySelector('#scheduleTable thead tr');
    const tableBody = document.getElementById('scheduleTableBody');
    
    if (!tableHead || !tableBody) return;
    
    // Update table headers
    let headerHtml = '<th>Employee Name</th>';
    dates.forEach(date => {
        const displayDate = new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        headerHtml += `<th>${displayDate}</th>`;
    });
    tableHead.innerHTML = headerHtml;
    
    // Update table body
    if (!data || data.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="' + (dates.length + 1) + '" class="text-center text-muted">No schedules found for the selected criteria</td></tr>';
        return;
    }
    
    let bodyHtml = '';
    data.forEach(employee => {
        bodyHtml += '<tr>';
        bodyHtml += `<td>${escapeHtml(employee.lastname)}, ${escapeHtml(employee.firstname)} ${employee.middlename ? employee.middlename.charAt(0) + '.' : ''}</td>`;
        
        // Create a map of schedule dates for this employee
        const scheduleMap = {};
        if (employee.schedules && employee.schedules.length > 0) {
            employee.schedules.forEach(sched => {
                scheduleMap[sched.schedule_at] = sched;
            });
        }
        
        // Fill in schedule for each date
        dates.forEach(date => {
            if (scheduleMap[date]) {
                const sched = scheduleMap[date];
                bodyHtml += `<td class="text-center">
                    <small>${escapeHtml(sched.scheduleName)}<br>
                    ${formatTime(sched.schedule_from)} - ${formatTime(sched.schedule_to)}</small>
                </td>`;
            } else {
                bodyHtml += '<td class="text-center text-muted">OFF</td>';
            }
        });
        
        bodyHtml += '</tr>';
    });
    
    tableBody.innerHTML = bodyHtml;
}

function formatTime(timeString) {
    if (!timeString) return '';
    try {
        const date = new Date('2000-01-01T' + timeString);
        return date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
    } catch (e) {
        return timeString;
    }
}

// Helper function to escape HTML and prevent XSS
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}