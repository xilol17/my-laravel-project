@php use Illuminate\Support\Facades\Auth; @endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $heading }}</title>
    <link rel="icon" href="{{ asset('images/favicon.jpg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- ======= PWA ======= -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#007bff">

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
                .then(function(registration) {
                    console.log('Service Worker registered with scope:', registration.scope);
                }).catch(function(error) {
                console.log('Service Worker registration failed:', error);
            });
        }
    </script>


    @vite(['resources/css/app.css','resources/js/app.js', 'resources/js/js.js'])
    <style>
        .other-input {
            display: none;
        }
    </style>
</head>
<body style="background-color: #f6f9ff;">
@php
    if(Auth::user()->sales){
        $main = 'My Projects';
        $link = '/my-project';
    }else{
        $main = 'Dashboard';
        $link = '/dashboard';
    }
@endphp
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ $link }}" class="logo d-flex align-items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Advantech Logo">
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3 mx-2">

                @guest
                    <x-nav-link href="/login">Login</x-nav-link>
                @endguest
                @auth
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="{{ asset('images/favicon.jpg') }}" alt="Profile" class="rounded-circle">
                        @if(Auth::user()->admin)
                            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->admin->name }}</span>
                        @else
                            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->sales->name }}</span>
                        @endif
                    </a><!-- End Profile Iamge Icon -->
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                @if(Auth::user()->admin)
                                    <h6>{{ Auth::user()->admin->name }}</h6>
                                    <span>Admin</span>
                                @else
                                    <h6>{{ Auth::user()->sales->name }}</h6>
                                    <span>Sales</span>
                                @endif

                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                    <i class="bi bi-person"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                    <i class="bi bi-gear"></i>
                                    <span>Account Settings</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/logout">
                                    <i class="bi bi-box-arrow-right"></i>

                                    <span>Sign Out</span>
                                </a>
                            </li>


                        </ul><!-- End Profile Dropdown Items -->
                @endauth
{{--                    @guest--}}
{{--                        <x-nav-link href="/login" :active="request()->is('login')">Login</x-nav-link>--}}
{{--                        <x-nav-link href="/register" :active="request()->is('register')">Register</x-nav-link>--}}
{{--                    @endguest--}}
{{--                    @auth--}}
{{--                        <form method="POST" action="/logout">--}}
{{--                            @csrf--}}

{{--                            <x-form-button>Log Out</x-form-button>--}}
{{--                        </form>--}}
{{--                    @endauth--}}
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<x-sidebar>

</x-sidebar>
<main id="main" class="main">

    <div class="pagetitle">
        <div class="d-flex justify-content-between align-items-center">
            <h1>{{ $heading }}</h1>
            @if(request()->routeIs('project.show'))
                <h1>Project Leader: {{ $leader }}</h1>
            @endif
        </div>
        <nav>
            <ol class="breadcrumb d-flex justify-content-between">
                <div class="d-flex">
                    <li class="breadcrumb-item"><a href="{{ $link }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $heading }}</li>
                </div>
                @if(request()->routeIs('project.show'))
                    <li>Start at: {{ $start }}</li>
                @endif

            </ol>
        </nav>

    </div><!-- End Page Title -->
    <div id="modal" class="modal">

    </div>
    <section class="section dashboard">

        <div class="modal fade" id="verticalycentered" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content">
                        <div class="d-flex align-items-center justify-content-between mb-5">
                            <img src="{{ asset('images/logo2.png') }}" alt="Advantech logo" style="width: 40%;">
                            <p class="mb-0">
                                <span class="close" id="close-modal-btn" data-bs-dismiss="modal" aria-label="Close">&times;</span>
                            </p>
                        </div>
                        <div class="card modal-card">
                            <div class="card-body">
                                <h5 class="card-title">Create New Project</h5>

                                <!-- Floating Labels Form -->
                                <form id="createForm" class="row g-3" action="/projects" method="POST">
                                    @csrf

                                    <!-- Step 1 -->
                                    <div class="tab">
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input type="text" name="projectName" class="form-control" id="floatingName" placeholder="Your Name" required>
                                                <label for="floatingName">Project Name</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="tab">
                                        <div class="col-md-12">
                                            <div class="form-floating mb-2">
                                                <label for="selectDate" class="col-md-6 col-form-label">ASSC visit date</label><br><br>
                                                <div class="radio-group col-md-6">

                                                    <label for="yes">Yes</label>
                                                    <input type="radio" id="yesvi" name="dateViSelect" value="yes">
                                                    <label for="no">No</label>
                                                    <input type="radio" id="novi" name="dateViSelect" value="no" checked>
                                                </div>

                                                <div id="datevicontainer" style="display: none;">
                                                    <label for="date">Select a date:</label>
                                                    <input type="date" id="datevi" name="dateVi" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-2">
                                                <label for="Date" class="col-md-6 col-form-label">Discussion start date</label><br><br>
                                                <div class="radio-group col-md-6">
                                                    <label for="yes">Yes</label>
                                                    <input type="radio" id="yesdis" name="dateDisSelect" value="yes">
                                                    <label for="no">No</label>
                                                    <input type="radio" id="nodis" name="dateDisSelect" value="no" checked>
                                                </div>

                                                <div id="datediscontainer" style="display: none;">
                                                    <label for="date">Select a date:</label>
                                                    <input type="date" id="datedis" name="dateDi" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-12 form-floating">
                                                <select class="form-select" name="region" id="floatingSelect" aria-label="Floating label select example" required>
                                                    <option selected disabled value="">Region</option>
                                                    <option value="Malaysia">Malaysia</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Vietnam">Vietnam</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="ROA">Rest Of Asean (ROA)</option>
                                                    <option value="Korea">Korea</option>
                                                </select>
                                                <label for="floatingSelect" class="col-md-6 col-form-label mx-2">Select Region</label>

                                            </div>
                                        </div>
                                    </div>
                                    <script>
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
                                    </script>

                                    <!-- Step 3 -->
                                    <div class="tab col-md-12">
                                        <div class="col-md-12 mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="floatingCity" name="customerName" placeholder="Customer Name" required>
                                                    <label for="floatingCity">Customer Name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <div class="col-form-label pt-0">Products</div>
                                                    <div class="d-inline-flex justify-content-between">
                                                        <div class="form-check my-2 mx-2">
                                                            <input class="form-check-input" type="checkbox" id="iFactory" value="iFactory" name="products[]">
                                                            <label class="form-check-label" for="iFactory">iFactory</label>
                                                        </div>

                                                        <div class="form-check my-2 mx-2">
                                                            <input class="form-check-input" type="checkbox" id="iEMS" value="iEMS" name="products[]">
                                                            <label class="form-check-label" for="iEMS">iEMS</label>
                                                        </div>

                                                        <div class="form-check my-2 mx-2">
                                                            <input class="form-check-input" type="checkbox" id="Partner Solutions" value="Partner Solutions" name="products[]">
                                                            <label class="form-check-label" for="Partner Solutions">Partner Solutions</label>
                                                        </div>
                                                    </div>

                                                    <div class="d-inline-flex justify-content-between">
                                                        <div class="form-check my-2 mx-2">
                                                            <input class="form-check-input" type="checkbox" id="Iot Suite" value="IoT Suite" name="products[]">
                                                            <label class="form-check-label" for="Iot Suite">IoT Suite</label>
                                                        </div>

                                                        <div class="form-check my-2 mx-2">
                                                            <input class="form-check-input" type="checkbox" id="Edge Hub" value="Edge Hub" name="products[]">
                                                            <label class="form-check-label" for="Edge Hub">Edge Hub</label>
                                                        </div>
                                                    </div>
                                                    <div class="d-inline-flex col-md-12">
                                                        <div class="form-check my-2 col-sm-2 mx-2">
                                                            <input class="form-check-input" type="checkbox" id="other" value="Other" name="products[]">
                                                            <label class="form-check-label" for="other">Other</label>
                                                        </div>

                                                        <!-- Other input field -->
                                                        <div class="row mb-3 col-sm-10" id="otherInput" style="display: none;">
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="otherInputfields" placeholder="other products" name="other_product">
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            document.getElementById('other').addEventListener('change', function() {
                                                var otherInput = document.getElementById('otherInput');
                                                const otherInputfields = document.getElementById('otherInputfields');
                                                if (this.checked) {
                                                    otherInput.style.display = 'block';
                                                    otherInputfields.setAttribute('required', 'required');
                                                } else {
                                                    otherInput.style.display = 'none';
                                                    otherInputfields.removeAttribute('required');
                                                }
                                            });
                                        </script>
                                        <div class="form-floating mb-3">
                                            <input type="number" step="0.01" min="0" name="revenue" class="form-control" id="floatingPassword" placeholder="11">
                                            <label for="floatingPassword">Revenue (USD $)</label>
                                        </div>

                                        <div class="d-flex">
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="BDM/PM" aria-label="BDM/PM" name="BDM/PM" required>
                                                        <option selected disabled>Please Select</option>
                                                        <option value="BDM">BDM</option>
                                                        <option value="PM">PM</option>
                                                        <option value="BDM & PM">BDM & PM</option>
                                                    </select>
                                                    <label for="floatingSelect">BDM/PM</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <select class="form-select" id="floatingSelect" aria-label="Turn Key" name="turnKey" required>
                                                        <option selected disabled>Please Select</option>
                                                        <option value="YES">Yes</option>
                                                        <option value="NO">No</option>
                                                    </select>
                                                    <label for="floatingZip">Turn Key</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <select class="form-select" id="SI" aria-label="SI" name="SI" required>
                                                        <option selected disabled>Please Select</option>
                                                        <option value="YES">Yes</option>
                                                        <option value="NO">No</option>
                                                    </select>
                                                    <label for="floatingZip">SI</label>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- SI input field, hidden by default -->
                                    <div class="form-floating mb-3" id="siNameField" style="display: none;">
                                        <input type="text" class="form-control" name="SIname" id="siName" placeholder="SI Name">
                                        <label for="siNumber">SI Name</label>
                                    </div>
                                    <script>
                                        function toggleSONumber() {
                                            const SI = document.getElementById('SI').value;
                                            const siNameField = document.getElementById('siNameField');
                                            const siNameInput = document.getElementById('siName');

                                            if (SI === 'YES') {
                                                siNameField.style.display = 'block';
                                                siNameInput.setAttribute('required', 'required');
                                            } else {
                                                siNameField.style.display = 'none';
                                                siNameInput.removeAttribute('required');
                                            }
                                        }

                                        // Attach the function to the select box's change event
                                        document.getElementById('SI').addEventListener('change', toggleSONumber);
                                    </script>

                                    <!-- Navigation Buttons -->
                                    <div class="navigation">
                                        <button type="button" class="btn btn-primary" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                        <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                    </div>

                                    <!-- Step Indicator -->
                                    <div class="step-indicator">
                                        <span class="step"></span>
                                        <span class="step"></span>
                                        <span class="step"></span>
                                    </div>
                                </form>
                                <script>
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

                                        for (let i = 0; i < selects.length; i++) {
                                            if (selects[i].hasAttribute('required') && (selects[i].value === "" || selects[i].selectedIndex === 0)) {
                                                selects[i].classList.add("invalid"); // Add invalid class
                                                alert(`Please select a value for ${selects[i].name}`); // Show alert with the select field's name
                                                valid = false;
                                            } else {
                                                selects[i].classList.remove("invalid"); // Remove invalid class if valid
                                            }
                                        }

                                        // Special case for SI Name field (show/hide based on SI selection)
                                        const SI = document.getElementById('SI').value;
                                        const siNameField = document.getElementById('siNameField');
                                        const siNameInput = document.getElementById('siName');
                                        if (SI === 'YES' && siNameInput.value.trim() === "") {
                                            siNameInput.classList.add("invalid");
                                            valid = false;
                                        } else {
                                            siNameInput.classList.remove("invalid");
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

                                    // Function to show/hide SI Name based on SI dropdown selection
                                    function toggleSONumber() {
                                        const SI = document.getElementById('SI').value;
                                        const siNameField = document.getElementById('siNameField');
                                        const siNameInput = document.getElementById('siName');

                                        if (SI === 'YES') {
                                            siNameField.style.display = 'block';
                                            siNameInput.setAttribute('required', 'required');
                                        } else {
                                            siNameField.style.display = 'none';
                                            siNameInput.removeAttribute('required');
                                        }
                                    }

                                    // Attach the function to the select box's change event
                                    document.getElementById('SI').addEventListener('change', toggleSONumber);
                                </script>

                            </div>
                        </div>

                        <!-- End floating Labels Form -->



                    </div>
                </div>
            </div>
        {{ $slot }}
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>Asean Domain Focused Integration Team</span></strong>.
    </div>
    <div class="credits">

    </div>
</footer><!-- End Footer -->

</body>
</html>
