document.addEventListener('DOMContentLoaded', function () {
    const openModalBtn = document.getElementById('open-modal-btn');
    const modal = document.getElementById('modal');
    const closeModalBtn = document.getElementById('close-modal-btn');

    // Open the modal
    if (openModalBtn) {
        openModalBtn.addEventListener('click', function () {
            modal.style.display = 'block';
        });
    }

    // Close the modal
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }

    // Close the modal if the user clicks outside of the modal content
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });


});
    document.addEventListener('DOMContentLoaded', function() {
    const yesVisit = document.getElementById('yesvi');
    const noVisit = document.getElementById('novi');
    const dateViContainer = document.getElementById('datevicontainer');
    const dateViInput = document.getElementById('datevi');

    const yesDis = document.getElementById('yesdis');
    const noDis = document.getElementById('nodis');
    const dateDisContainer = document.getElementById('datediscontainer');
    const dateDisInput = document.getElementById('datedis');

    function toggleDateInput() {
    if (noVisit.checked) {
    dateViContainer.style.display = 'none';
    dateViInput.removeAttribute('required');
} else {
    dateViContainer.style.display = 'block';
    dateViInput.setAttribute('required', 'required');
}
}

    function toggleDateInput2() {
    if (noDis.checked) {
    dateDisContainer.style.display = 'none';
    dateDisInput.removeAttribute('required');
} else {
    dateDisContainer.style.display = 'block';
    dateDisInput.setAttribute('required', 'required');
}
}

    yesVisit.addEventListener('change', toggleDateInput);
    noVisit.addEventListener('change', toggleDateInput);
    yesDis.addEventListener('change', toggleDateInput2);
    noDis.addEventListener('change', toggleDateInput2);

    toggleDateInput2();
    toggleDateInput(); // Initialize visibility on page load
});


// script.js

let currentTab = 0;
showTab(currentTab);

function showTab(n) {
    const tabs = document.getElementsByClassName("tab");
    tabs[n].style.display = "block";

    document.getElementById("prevBtn").style.display = n === 0 ? "none" : "inline";
    document.getElementById("nextBtn").innerHTML = n === (tabs.length - 1) ? "Submit" : "Next";

    updateStepIndicator(n);
}

function nextPrev(n) {
    const tabs = document.getElementsByClassName("tab");

    // Exit the function if the validation fails and we are moving forward
    if (n === 1 && !validateForm()) return false;

    // Hide the current tab
    tabs[currentTab].style.display = "none";

    // Increase or decrease the current tab by 1
    currentTab += n;

    // If you have reached the end of the form, submit it
    if (currentTab >= tabs.length) {
        document.getElementById("createForm").submit();
        return false;
    }

    // Otherwise, display the correct tab
    showTab(currentTab);
}


function validateForm() {
    const currentTabElement = document.getElementsByClassName("tab")[currentTab];
    const inputs = currentTabElement.getElementsByTagName("input");
    const selects = currentTabElement.getElementsByTagName("select");
    let valid = true;

    // Validate input fields
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].hasAttribute('required') && inputs[i].value.trim() === "") {
            inputs[i].classList.add("invalid"); // Add invalid class
            valid = false;
        } else {
            inputs[i].classList.remove("invalid"); // Remove invalid class if valid
        }
    }

    // Validate select fields
    for (let i = 0; i < selects.length; i++) {
        if (selects[i].hasAttribute('required') && (selects[i].value === "" || selects[i].selectedIndex === 0)) {
            selects[i].classList.add("invalid"); // Add invalid class
            alert(`Please select a value for ${selects[i].name}`); // Show alert with the select field's name
            valid = false;
        } else {
            selects[i].classList.remove("invalid"); // Remove invalid class if valid
        }
    }

    if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
    }

    return valid;
}


function updateStepIndicator(n) {
    const steps = document.getElementsByClassName("step");
    for (let i = 0; i < steps.length; i++) {
        steps[i].className = steps[i].className.replace(" active", "");
    }
    steps[n].className += " active";
}

