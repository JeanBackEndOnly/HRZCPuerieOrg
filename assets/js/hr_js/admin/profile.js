    document.addEventListener('DOMContentLoaded', function() {
        initProfileTabs();
        
    });

    function initProfileTabs() {
        const tabButtons = document.querySelectorAll('#ProfileInfoTabs .nav-link');
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
                    if (targetId === '#Employment') {
                        // loadEmployeeData_hr_pending();
                    } else if (targetId === '#Personal') {
                        // loadEmployeeData_hr();
                    } else if (targetId === '#Education') {
                        // loadEmployeeData_hr_rejected();
                    } else if (targetId === '#Family') {
                        // loadEmployeeData_hr_rejected();
                    }
                }
            });
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        const profileContents = document.querySelector('.profile-contents');
        if (profileContents) {
            // Override the scrollbar display property
            profileContents.style.setProperty('scrollbar-width', 'thin', 'important');
            profileContents.style.setProperty('-webkit-scrollbar', 'auto', 'important');

            // Add custom scrollbar styling
            const style = document.createElement('style');
            style.textContent = `
                .profile-contents::-webkit-scrollbar {
                    display: block !important;
                    width: 8px !important;
                }
                .profile-contents::-webkit-scrollbar-track {
                    background: #f1f1f1 !important;
                    border-radius: 4px !important;
                }
                .profile-contents::-webkit-scrollbar-thumb {
                    background: #c1c1c1 !important;
                    border-radius: 4px !important;
                }
                .profile-contents::-webkit-scrollbar-thumb:hover {
                    background: #a8a8a8 !important;
                }
            `;
            document.head.appendChild(style);
        }

        const birthdayInput = document.getElementById('birthday');
        const ageInput = document.getElementById('age');

        // Function to calculate age from birthday
        function calculateAge(birthday) {
            if (!birthday) return '';

            const birthDate = new Date(birthday);
            const today = new Date();

            // Check if birthdate is valid and not in the future
            if (birthDate > today) {
                ageInput.classList.add('is-invalid');
                return 'Invalid date';
            }

            ageInput.classList.remove('is-invalid');

            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            const dayDiff = today.getDate() - birthDate.getDate();

            // Adjust age if birthday hasn't occurred this year yet
            if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                age--;
            }

            return age >= 0 ? age : 0;
        }

        // Function to validate birthday (not in future)
        function validateBirthday(birthday) {
            if (!birthday) return true;

            const birthDate = new Date(birthday);
            const today = new Date();

            if (birthDate > today) {
                birthdayInput.classList.add('is-invalid');
                return false;
            }

            birthdayInput.classList.remove('is-invalid');
            return true;
        }

        // Calculate age when birthday changes
        birthdayInput.addEventListener('change', function() {
            if (validateBirthday(this.value)) {
                const age = calculateAge(this.value);
                ageInput.value = age;
            } else {
                ageInput.value = '';
            }
        });

        // Real-time age calculation
        birthdayInput.addEventListener('input', function() {
            if (validateBirthday(this.value)) {
                const age = calculateAge(this.value);
                ageInput.value = age;
            } else {
                ageInput.value = '';
            }
        });

        // Calculate initial age if birthday is already set
        if (birthdayInput.value) {
            if (validateBirthday(birthdayInput.value)) {
                const initialAge = calculateAge(birthdayInput.value);
                ageInput.value = initialAge;
            }
        }

        // Make age field read-only since it's auto-calculated
        ageInput.readOnly = true;
        ageInput.placeholder = 'Auto-calculated from birthday';
    });

    // ============================= CAREER PATH =================================== //
    function getEmploymentData(user_id, designation, salary){
        document.getElementById('user_id_careerPath').value = user_id
        document.getElementById('currentDesignationId').value = designation
        document.getElementById('currentSalaryId').value = salary
    } 