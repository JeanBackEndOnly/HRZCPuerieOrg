document.addEventListener("DOMContentLoaded", function() {
    const birthdayInput = document.getElementById("birthday");
    const ageInput = document.getElementById("age");

    function calculateAge() {
        if (!birthdayInput.value) {
            ageInput.value = "";
            return;
        }

        const birthDate = new Date(birthdayInput.value);
        const today = new Date();

        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        const dayDiff = today.getDate() - birthDate.getDate();

        if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
            age--;
        }

        ageInput.value = age;
    }

    birthdayInput.addEventListener("change", calculateAge);

    calculateAge();
});

function getEmploymentData(user_id, designation, salary) {
    document.getElementById('user_id_careerPath').value = user_id;
    document.getElementById('currentDesignationId').value = designation;
    document.getElementById('currentSalaryId').value = salary;
}