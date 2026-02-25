document.addEventListener('DOMContentLoaded', function() {
    initTabs();
});

function initTabs() {
    const tabButtons = document.querySelectorAll('#LeaveRequestTabs .nav-link');
    const tabContents = document.querySelectorAll('.tab-pane');
    
    // Initialize tabs - hide all except active
    tabContents.forEach(content => {
        if (!content.classList.contains('active')) {
            content.style.display = 'none';
        }
    });
    
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
                targetContent.style.display = 'block';
                targetContent.classList.add('show', 'active');
                
                // Load data for the active tab
                if (targetId === '#Pending_Leave') {
                } else if (targetId === '#Approved_leave') {
                } else if (targetId === '#Rejected_Leave') {
                }
            }
        });
    });
}
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchForAllLeave');
    
    if (!searchInput) return;
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        const tabs = {
            pending: document.getElementById('Pending_Leave'),
            approved: document.getElementById('Approved_leave'),
            rejected: document.getElementById('Rejected_Leave')
        };
        
        searchInTab(tabs.pending, searchTerm);
        searchInTab(tabs.approved, searchTerm);
        searchInTab(tabs.rejected, searchTerm);
    });
    
    // Function to search within a specific tab
    function searchInTab(tabElement, searchTerm) {
        if (!tabElement) return;
        
        // Get all table rows in this tab (excluding the header row)
        const table = tabElement.querySelector('table');
        if (!table) return;
        
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        
        const rows = tbody.querySelectorAll('tr');
        
        // Handle empty state rows (like "No Recommended Leave Data")
        rows.forEach(row => {
            // Check if this is a "no data" row (has colspan)
            const noDataCell = row.querySelector('td[colspan]');
            if (noDataCell) {
                // For no-data rows, keep them visible if search is empty, otherwise hide
                row.style.display = searchTerm === '' ? '' : 'none';
                return;
            }
            
            // Get all cells in this row
            const cells = row.querySelectorAll('th, td');
            
            // Skip the first cell (usually # counter) and check other cells
            let rowText = '';
            for (let i = 1; i < cells.length; i++) {
                rowText += cells[i].textContent.toLowerCase() + ' ';
            }
            
            // Check if the row matches the search term
            const matches = rowText.includes(searchTerm);
            
            // Show/hide the row based on match
            row.style.display = matches || searchTerm === '' ? '' : 'none';
        });
        
        // Check if all rows are hidden and show "no results" message if needed
        checkForNoResults(tabElement, searchTerm);
    }
    
    // Function to check if there are any visible rows and show "no results" if needed
    function checkForNoResults(tabElement, searchTerm) {
        if (searchTerm === '') return;
        
        const table = tabElement.querySelector('table');
        if (!table) return;
        
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        
        const rows = tbody.querySelectorAll('tr');
        let visibleRows = 0;
        
        rows.forEach(row => {
            // Skip no-data rows in count
            const noDataCell = row.querySelector('td[colspan]');
            if (noDataCell) return;
            
            if (row.style.display !== 'none') {
                visibleRows++;
            }
        });
        
        // Check if there's already a "no results" row
        const existingNoResult = tbody.querySelector('.no-search-results');
        
        if (visibleRows === 0) {
            // If no visible rows and no "no results" row exists, add one
            if (!existingNoResult) {
                const colspan = getColumnCount(table);
                const noResultRow = document.createElement('tr');
                noResultRow.className = 'no-search-results';
                noResultRow.innerHTML = `<td colspan="${colspan}" class="text-center"><strong>No results found for "${searchTerm}"</strong></td>`;
                tbody.appendChild(noResultRow);
            }
        } else {
            // If there are visible rows, remove any existing "no results" row
            if (existingNoResult) {
                existingNoResult.remove();
            }
        }
    }
    
    // Helper function to get column count
    function getColumnCount(table) {
        const headerRow = table.querySelector('thead tr');
        if (headerRow) {
            return headerRow.children.length;
        }
        return 6; // Default to 6 columns
    }
    
    // Optional: Add debounce for better performance (waits for user to stop typing)
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const searchTerm = this.value;
        
        searchTimeout = setTimeout(() => {
            const tabs = {
                pending: document.getElementById('Pending_Leave'),
                approved: document.getElementById('Approved_leave'),
                rejected: document.getElementById('Rejected_Leave')
            };
            
            searchInTab(tabs.pending, searchTerm.toLowerCase().trim());
            searchInTab(tabs.approved, searchTerm.toLowerCase().trim());
            searchInTab(tabs.rejected, searchTerm.toLowerCase().trim());
        }, 300); // Wait 300ms after user stops typing
    });
    
    // Clear search when switching tabs (optional)
    const tabLinks = document.querySelectorAll('#LeaveRequestTabs .nav-link');
    tabLinks.forEach(link => {
        link.addEventListener('shown.bs.tab', function() {
            // Optionally clear search when switching tabs
            // searchInput.value = '';
            // Trigger search to show all rows
            // searchInput.dispatchEvent(new Event('keyup'));
        });
    });
    
    // Function to reset search and show all rows
    window.resetLeaveSearch = function() {
        if (searchInput) {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('keyup'));
        }
    };
});