// script.js
function openTab(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tabbuttons;

    // Get all elements with class="tab-content" and hide them
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tab-button" and remove the "active" class
    tabbuttons = document.getElementsByClassName("tab-button");
    for (i = 0; i < tabbuttons.length; i++) {
        tabbuttons[i].className = tabbuttons[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";

    // If the student tab is opened, fetch and populate teachers
    if (tabName === 'student') {
        fetchTeachersAndPopulateDropdown();
    }
}

// Set the default tab to open when the page loads
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".tab-button").click();
});

// Function to fetch teachers and populate the dropdown
function fetchTeachersAndPopulateDropdown() {
    const teacherSelect = document.getElementById('student-teacher');
    // Clear existing options, keeping the default "Select a Teacher"
    teacherSelect.innerHTML = '<option value="" disabled selected>Select a Teacher</option>';

    fetch('get_teachers.php')
        .then(response => response.json())
        .then(teachers => {
            if (teachers.length > 0) {
                teachers.forEach(teacher => {
                    const option = document.createElement('option');
                    option.value = teacher.id; // Use teacher's primary key ID as value
                    option.textContent = teacher.name;
                    teacherSelect.appendChild(option);
                });
            }
        })
        .catch(error => console.error('Error fetching teachers:', error));
}
