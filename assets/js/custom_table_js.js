var tablesDT;
document.addEventListener("DOMContentLoaded", function () {
    if (tablesDT === undefined) {
        tablesDT = new DataTable('#table', {
            responsive: true,
            autoWidth: false,
            pageLength: 5,
            lengthMenu: [5, 10, 20],
            order: [[-1, "asc"]],
            columnDefs: [{ targets: [-1], orderable: false }],
            language: {
                searchPlaceholder: "Search records...",
                search: "Search:",
                lengthMenu: "_MENU_ Records per page",
                zeroRecords: "Nothing found - sorry",
                info: "Showing page _PAGE_ of _PAGES_",
                infoEmpty: "No records available",
                infoFiltered: "(filtered from _MAX_ total records)",
                paginate: {
                    first: '<i class="fa fa-angle-double-left"></i>',
                    last: '<i class="fa fa-angle-double-right"></i>',
                    next: '<i class="fa fa-angle-right"></i>',
                    previous: '<i class="fa fa-angle-left"></i>'
                }
            }
        });
    }
});

/* Home page dashboard */
const ctx = document.getElementById('summaryChart').getContext('2d');
    const summaryData = {
        labels: [
            'Hospital Department',
            'School Department',
            'Office Department',
            'Active Users' // New label added
        ],
        datasets: [{
            label: 'Employees Count',
            data: [12, 25, 40, 18], // Added value for Active Users
            backgroundColor: [
                '#708090',
                '#c2c2c2',
                '#8c92ac',
                '#36454F' // New color for Active Users
            ],
            borderColor: [
                'rgba(255, 255, 255, 0.9)',
                'rgba(255, 255, 255, 0.9)',
                'rgba(255, 255, 255, 0.9)',
                'rgba(255, 255, 255, 0.9)' // Border for Active Users
            ],
            borderWidth: 5
        }]
    };

    const summaryConfig = {
        type: 'doughnut',
        data: summaryData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    };

    new Chart(ctx, summaryConfig);

