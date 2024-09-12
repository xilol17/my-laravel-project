@php use Illuminate\Support\Facades\Auth; @endphp
<x-layout>
    <x-slot:heading>
        Project {{ $project['name'] }}
    </x-slot:heading>
    <x-slot:leader>
        {{ $project['salesName'] }}
    </x-slot:leader>
    <x-slot:start>
        {{ $project['created_at']->format('d-m-Y') }}
    </x-slot:start>
    @vite(['resources/css/app.css','resources/js/app.js', 'resources/js/js.js'])

    <style>
        body {
            margin-top: 20px;
        }

        .card {
            margin-bottom: 30px;
            border: none;
            border-radius: 5px;
            box-shadow: 0 0 30px rgba(1, 41, 112, 0.1);
        }

        .card-title {
            padding: 20px 0 15px 0;
            font-size: 18px;
            font-weight: 500;
            color: #012970;
            font-family: Arial, sans-serif;
        }

        .card-title span {
            color: #899bbd;
            font-size: 14px;
            font-weight: 400;
        }

        .card-body {
            padding: 0 20px 20px 20px;
        }

        .timeline_area {
            position: relative;
            z-index: 1;
        }

        .single-timeline-area {
            position: relative;
            z-index: 1;
            padding-left: 180px;
        }

        @media only screen and (max-width: 575px) {
            .single-timeline-area {
                padding-left: 100px;
            }
        }

        .single-timeline-area .timeline-date {
            position: absolute;
            width: 180px;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -ms-grid-row-align: center;
            align-items: center;
            -webkit-box-pack: end;
            -ms-flex-pack: end;
            justify-content: flex-end;
            padding-right: 60px;
        }

        @media only screen and (max-width: 575px) {
            .single-timeline-area .timeline-date {
                width: 100px;
            }
        }

        .single-timeline-area .timeline-date::after {
            position: absolute;
            width: 3px;
            height: 100%;
            content: "";
            background-color: #ebebeb;
            top: 0;
            right: 30px;
            z-index: 1;
        }

        .single-timeline-area .timeline-date::before {
            position: absolute;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background-color: #f1c40f;
            content: "";
            top: 50%;
            right: 26px;
            z-index: 5;
            margin-top: -5.5px;
        }

        .single-timeline-area .timeline-date p {
            margin-bottom: 0;
            color: #020710;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 500;
        }


        .single-timeline-area .single-timeline-content {
            position: relative;
            z-index: 1;
            padding: 30px 30px 25px;
            border-radius: 6px;
            margin-bottom: 15px;
            margin-top: 15px;
            -webkit-box-shadow: 0 0.25rem 1rem 0 rgba(47, 91, 234, 0.125);
            box-shadow: 0 0.25rem 1rem 0 rgba(47, 91, 234, 0.125);
            border: 1px solid #ebebeb;

        }

        @media only screen and (max-width: 575px) {
            .single-timeline-area .single-timeline-content {
                padding: 20px;
            }
        }

        .single-timeline-area .single-timeline-content .timeline-icon {
            -webkit-transition-duration: 500ms;
            transition-duration: 500ms;
            width: 30px;
            height: 30px;
            background-color: #f1c40f;
            -webkit-box-flex: 0;
            -ms-flex: 0 0 30px;
            flex: 0 0 30px;
            text-align: center;
            max-width: 30px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .single-timeline-area .single-timeline-content .timeline-icon i {
            color: #ffffff;
            line-height: 30px;
        }

        .single-timeline-area .single-timeline-content .timeline-text h6 {
            -webkit-transition-duration: 500ms;
            transition-duration: 500ms;
        }

        .single-timeline-area .single-timeline-content .timeline-text p {
            font-size: 13px;
            margin-bottom: 0;
        }

        .single-timeline-area .single-timeline-content:hover .timeline-icon,
        .single-timeline-area .single-timeline-content:focus .timeline-icon {
            background-color: #aac6ff;
        }

        .single-timeline-area .single-timeline-content:hover .timeline-text h6,
        .single-timeline-area .single-timeline-content:focus .timeline-text h6 {
            color: #3f43fd;
        }

        .single-timeline-content {
            background-color: #f6fbff;
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex: 1;
            margin-bottom: 15px;
        }

        .single-timeline-content:hover {
            transform: scale(1.05);
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-12.col-md-6.col-lg-4 {
            display: flex;
            align-items: stretch;
        }

        .button-none {
            background: none;
            border: none;
            padding: 0;
            margin: 0;
            font: inherit;
            color: inherit;
            text-align: inherit;
            cursor: pointer;
            outline: none;
            position: relative;
            transition: background-color 0.3s ease, width 0.3s ease, height 0.3s ease, border-radius 0.3s ease;
        }

        .button-none:hover {
            background-color: #f0f0f0; /* Light grey background on hover */
            width: 30px; /* Circle width */
            height: 30px; /* Circle height */
            border-radius: 50%; /* Make it a circle */
            align-items: center;
            justify-content: center;
        }

        .edit-btn {
            cursor: pointer;
            color: #007bff;
            font-size: 18px;
        }

        .edit-btn:hover {
            text-decoration: underline;
        }

        .editable {
            display: none;
        }

        .edit-mode .editable {
            display: inline;
        }

        .save-btn {
            cursor: pointer;
            color: #28a745;
            font-size: 18px;
        }

        .cancel-btn {
            cursor: pointer;
            color: #dc3545;
            font-size: 18px;
        }

        .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
        }

        .other-input {
            display: none;
        }

        .attachment-container {
            position: relative;
            display: inline-block; /* Ensure the container only takes up as much width as needed */
            margin-bottom: 1rem; /* Optional: space between attachments */
        }

        .attachment-box {
            position: relative;
            display: inline-block;
        }

        .delete-button-wrapper {
            position: absolute;
            top: 50%;
            left: 90%;
            transform: translate(-50%, -50%);
            z-index: 10; /* Make sure the button is above the attachment */
        }

        .delete-button-wrapper form {
            margin: 0; /* Remove default margin */
        }


    </style>


    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session('info'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row">
                    <!-- Lastest Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Latest Update</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('images/update.jpeg') }}" alt="icon"
                                             class="card-icon rounded-circle">
                                    </div>
                                    <div class="ps-3">
                                        @if($hoursAgo === 'Not update yet.')
                                            <h6>{{ $hoursAgo }}</h6>
                                        @elseif($hoursAgo < 1)
                                            @if($hoursAgo * 60 < 15)
                                                <!-- If less than 1 minute -->
                                                <h6>Just now</h6>
                                            @elseif($hoursAgo * 60 <= 30)
                                                <h6>30 minutes ago</h6>
                                            @else
                                                @if(round($hoursAgo * 60) == 60)
                                                    <h6>1 hour ago</h6>
                                                @else
                                                    <h6>{{ round($hoursAgo * 60) }} minutes ago</h6>
                                                @endif
                                            @endif
                                        @elseif($hoursAgo < 24)
                                            <h6>{{ round($hoursAgo) }} hours ago</h6>
                                        @else
                                            @php
                                                // Convert $hoursAgo to a float to ensure arithmetic operations work
                                                $hoursAgo = (float) $hoursAgo;

                                                // Calculate the number of days ago
                                                $daysAgo = floor($hoursAgo / 24);
                                            @endphp
                                            <h6>{{ $daysAgo }} days ago</h6>
                                        @endif
                                        @if($hoursAgo != 'Not update yet.')
                                            <span class="text-success small pt-1 fw-bold">Updated at</span> <span
                                                class="text-muted small pt-2 ps-1">{{ $project->lastUpdateDate }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Latest Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <div class="filter">
                                    @can('edit', $project)
                                        <x-button href="#" data-bs-toggle="dropdown">Update</x-button>
                                    @endcan
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Update Revenue</h6>
                                        </li>
                                        <form action="/project/{{ $project->id }}" method="POST" class="dropdown-item">
                                            @csrf
                                            @method('PATCH')

                                            <div class="form-floating mb-3" style="width: 200px;">
                                                <input type="number" step="0.01" min="0" name="revenue"
                                                       class="form-control" id="floatingPassword"
                                                       placeholder={{ $project->revenue }}>
                                                <label for="floatingPassword">Revenue (USD $)</label>
                                            </div>
                                            <button class="btn btn-primary btn-sm" type="submit">Update</button>
                                        </form>
                                    </ul>
                                </div>

                                <h5 class="card-title">Revenue</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('images/sales.jpg') }}" alt="icon"
                                             class="card-icon rounded-circle">
                                    </div>
                                    <div class="ps-3">
                                        <h6>USD <br>$ {{ number_format($project->revenue, 2) }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Win Rate Card -->
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card info-card customers-card">
                            <div class="card-body">

                                <div class="filter">
                                    @can('edit', $project)
                                        <x-button href="#" data-bs-toggle="dropdown">Update</x-button>
                                    @endcan
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Update Win Rate</h6>
                                        </li>
                                        <form action="/project/{{ $project->id }}" method="POST" class="dropdown-item">
                                            @csrf
                                            @method('PATCH')

                                            <!-- Win Rate Dropdown -->
                                            <div class="form-floating mb-3" style="width: 200px;">
                                                <select class="form-select" name="winRate" id="winrate" aria-label="Floating label select example">
                                                    <option selected disabled>Win Rate</option>
                                                    <option value="0">0%</option>
                                                    <option value="25">25%</option>
                                                    <option value="50">50%</option>
                                                    <option value="75">75%</option>
                                                    <option value="100">100%</option>
                                                </select>
                                                <label for="floatingSelect">Select win rate</label>
                                            </div>

                                            <!-- SO Number input field, hidden by default -->
                                            <div class="form-floating mb-3" id="soNumberField" style="display: none; width: 200px;">
                                                <input type="text" class="form-control" name="SO" id="soNumber" placeholder="SO Number">
                                                <label for="soNumber">SO Number</label>
                                            </div>

                                            <button class="btn btn-primary btn-sm" type="submit">Update</button>
                                        </form>
                                        <script>
                                            function toggleSONumber() {
                                                const winRate = document.getElementById('winrate').value;
                                                const soNumberField = document.getElementById('soNumberField');
                                                const soNumberInput = document.getElementById('soNumber');

                                                if (winRate === '100') {
                                                    soNumberField.style.display = 'block';
                                                    soNumberInput.setAttribute('required', 'required');
                                                } else {
                                                    soNumberField.style.display = 'none';
                                                    soNumberInput.removeAttribute('required');
                                                }
                                            }

                                            // Attach the function to the select box's change event
                                            document.getElementById('winrate').addEventListener('change', toggleSONumber);
                                        </script>

                                    </ul>
                                </div>

                                <h5 class="card-title">Win Rate</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('images/winrate.png') }}" alt="icon"
                                             class="card-icon rounded-circle">
                                    </div>
                                    <div class="ps-3">
                                        <x-winRate-indicatorText
                                            winrate="{{ $project->winRate }}">{{ $project->winRate }}%
                                        </x-winRate-indicatorText>
                                        @if($project->winRate == 100)
                                            <span class="text-success small pt-1 fw-bold">SO Number</span>
                                            <div class="copy-text" id="textToCopy">
                                                <span class="text-danger fw-bold small pt-2 ps-1">{{ $project->SO }}</span>
                                            </div>
                                            <i class="bi bi-clipboard icon" onclick="copyText()"></i>
                                            <script>
                                                function copyText() {
                                                    // Get the text from the div
                                                    const textToCopy = document.getElementById('textToCopy').innerText;

                                                    // Create a temporary textarea element
                                                    const tempTextarea = document.createElement('textarea');
                                                    tempTextarea.value = textToCopy;
                                                    document.body.appendChild(tempTextarea);

                                                    // Select the text and copy it
                                                    tempTextarea.select();
                                                    document.execCommand('copy');

                                                    // Remove the temporary textarea
                                                    document.body.removeChild(tempTextarea);

                                                    // Optionally alert the user
                                                    alert('Text copied to clipboard!');
                                                }
                                            </script>
                                        @endif


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div><!-- End Win Rate Card -->
                </div>
            </div>
        </div>
    </section>


    <div class="container mt-4">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Label</th>
                <th>Data</th>
                @can('edit', $project)
                    <th>Action</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>ASSC Visit Date</td>
                <td class="data">{{ $project->visitDate }}</td>
                <td class="editable">
                    <form action="/project/{{ $project->id }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mx-4 d-flex">
                            <input type="date" id="datevi" name="visitDate" class="form-control"
                                   value="{{ $project->visitDate }}">
                            <div class="d-inline-grid">
                                <button class="button-none"><span class="save-btn d-none" onclick="saveChanges(this)"
                                                                  type="submit">✔</span></button>
                                <span class="cancel-btn d-none button-none" onclick="cancelChanges(this)">✖</span>
                            </div>
                        </div>
                    </form>
                </td>
                @can('edit', $project)
                    <td>
                        <span class="edit-btn" onclick="toggleEdit(this)">✎</span>
                    </td>
                @endcan
            </tr>
            <tr>
                <td>Discussion Start Date</td>
                <td class="data">{{ $project->disStartDate }}</td>
                <td class="editable">
                    <form action="/project/{{ $project->id }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mx-4 d-flex">
                            <input type="date" class="form-control px-2" name="disStartDate"
                                   value="{{ $project->disStartDate }}">
                            <div class="d-inline-grid">
                                <button class="button-none"><span class="save-btn d-none" onclick="saveChanges(this)"
                                                                  type="submit">✔</span></button>
                                <span class="cancel-btn d-none button-none" onclick="cancelChanges(this)">✖</span>
                            </div>
                        </div>

                    </form>
                </td>
                @can('edit', $project)
                    <td>
                        <span class="edit-btn" onclick="toggleEdit(this)">✎</span>
                    </td>
                @endcan
            </tr>
            <tr>
                <td>Turn Key</td>
                <td class="data">{{ $project->turnKey }}</td>
                <td class="editable">
                    <form action="/project/{{ $project->id }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-floating mb-3 mx-4 d-flex">
                            <select class="form-select" name="turnKey" id="floatingSelect" aria-label="Select Turn Key">
                                <option selected disabled>{{ $project->turnKey }}</option>
                                <option value="YES">YES</option>
                                <option value="NO">NO</option>
                            </select>
                            <label for="floatingSelect">Turn Key</label>
                            <div class="d-inline-grid">
                                <button class="button-none"><span class="save-btn d-none" onclick="saveChanges(this)"
                                                                  type="submit">✔</span></button>
                                <span class="cancel-btn d-none button-none" onclick="cancelChanges(this)">✖</span>
                            </div>
                        </div>

                    </form>
                </td>
                @can('edit', $project)
                    <td>
                        <span class="edit-btn" onclick="toggleEdit(this)">✎</span>
                    </td>
                @endcan
            </tr>
            <tr>
                <td>Status</td>
                <td class="data">{{ $project->status }}</td>
                <td class="editable">
                    <form action="/project/{{ $project->id }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-floating mb-3 mx-4 d-flex">
                            <select class="form-select" name="status" id="floatingSelect"
                                    aria-label="Floating label select example">
                                <option selected disabled>{{ $project->status }}</option>
                                <option value="New Case">New Case</option>
                                <option value="Processing">Processing</option>
                                <option value="Fail">Fail</option>
                                <option value="Conduction Sent">Conduction Sent</option>
                                <option value="PO Awarded">PO Awarded</option>
                            </select>
                            <label for="floatingSelect">Select Status</label>
                            <div class="d-inline-grid">
                                <button class="button-none"><span class="save-btn d-none" onclick="saveChanges(this)"
                                                                  type="submit">✔</span></button>
                                <span class="cancel-btn d-none button-none" onclick="cancelChanges(this)">✖</span>
                            </div>
                        </div>
                    </form>
                </td>
                @can('edit', $project)
                    <td>
                        <span class="edit-btn" onclick="toggleEdit(this)">✎</span>
                    </td>
                @endcan
            </tr>
            <tr>
                <td>BDM/PM</td>
                <td class="data">{{ $project->BDMPM }}</td>
                <td class="editable">
                    <form action="/project/{{ $project->id }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-floating mb-3 mx-4 d-flex">
                            <select class="form-select" name="BDMPM" id="floatingSelect" aria-label="Select BDM/PM">
                                <option selected disabled>{{ $project->BDMPM }}</option>
                                <option value="BDM">BDM</option>
                                <option value="PM">PM</option>
                                <option value="BDM & PM">BDM & PM</option>
                            </select>
                            <label for="floatingSelect">BDM/PM</label>
                            <div class="d-inline-grid">
                                <button class="button-none"><span class="save-btn d-none" onclick="saveChanges(this)"
                                                                  type="submit">✔</span></button>
                                <span class="cancel-btn d-none button-none" onclick="cancelChanges(this)">✖</span>
                            </div>
                        </div>

                    </form>
                </td>
                @can('edit', $project)
                    <td>
                        <span class="edit-btn" onclick="toggleEdit(this)">✎</span>
                    </td>
                @endcan
            </tr>
            <tr>
                <td>Region</td>
                <td class="data">{{ $project->region }}</td>
                <td class="editable">
                    <form action="/project/{{ $project->id }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-floating mb-3 mx-4 d-flex">
                            <select class="form-select" name="region" id="floatingSelect"
                                    aria-label="Floating label select example">
                                <option selected disabled>{{ $project->region }}</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Vietnam">Vietnam</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="ROA">Rest Of Asean (ROA)</option>
                                <option value="Korea">Korea</option>
                            </select>
                            <label for="floatingSelect">Select Region</label>
                            <div class="d-inline-grid">
                                <button class="button-none"><span class="save-btn d-none" onclick="saveChanges(this)"
                                                                  type="submit">✔</span></button>
                                <span class="cancel-btn d-none button-none" onclick="cancelChanges(this)">✖</span>
                            </div>
                        </div>
                    </form>
                </td>
                @can('edit', $project)
                    <td>
                        <span class="edit-btn" onclick="toggleEdit(this)">✎</span>
                    </td>
                @endcan
            </tr>
            <tr>
                <td>Customer Name</td>
                <td class="data">{{ $project->customerName }}</td>
                <td class="editable">
                    <form action="/project/{{ $project->id }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mx-4 d-flex">
                            <input type="text" class="form-control px-2" name="customerName"
                                   value="{{ $project->customerName }}">
                            <div class="d-inline-grid">
                                <button class="button-none"><span class="save-btn d-none" onclick="saveChanges(this)"
                                                                  type="submit">✔</span></button>
                                <span class="cancel-btn d-none button-none" onclick="cancelChanges(this)">✖</span>
                            </div>
                        </div>

                    </form>
                </td>
                @can('edit', $project)
                    <td>
                        <span class="edit-btn" onclick="toggleEdit(this)">✎</span>
                    </td>
                @endcan
            </tr>
            <tr>
                <td>Products</td>

                @if($project->products != '')
                    @php
                        $productsArray = json_decode($project->products, true) ?? [];
                    @endphp
                    <td class="data">
                        @foreach($productsArray as $product)
                            {{ $product }}<br>
                        @endforeach
                    </td>
                @else
                    <td class="data">{{$project->products}}</td>
                @endif


                <td class="editable">
                    <form action="/project/{{ $project->id }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @php
                            $productsArray = json_decode($project->products, true);
                            $ot1 = $ot2 = $ot3 = $ot4 = $ot5 = $ot6 = '';
                            $othervalue = '';
                            $otherfiled = 'none';

                            if (is_array($productsArray)) {
                                foreach ($productsArray as $product) {
                                    if ($product == "iFactory") {
                                        $ot1 = "checked";
                                    } else if ($product == "iEMS") {
                                        $ot2 = "checked";
                                    } else if ($product == "Partner Solutions") {
                                        $ot3 = "checked";
                                    } else if ($product == "IoT Suite") {
                                        $ot4 = "checked";
                                    } else if ($product == "Edge Hub") {
                                        $ot5 = "checked";
                                    } else if ($product == "Other") {
                                        $ot6 = "checked";
                                        $otherfiled = "block";
                                    } else {
                                        $othervalue = $product;
                                    }
                                }
                            }
                        @endphp

                        <div class="row mb-3 mx-4">
                            <div class="col-form-label pt-0">Products</div>
                            <div class="col-sm-12">
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="iFactoryy" value="iFactory"
                                           name="products[]" {{$ot1}}>
                                    <label class="form-check-label" for="iFactoryy">iFactory</label>
                                </div>

                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="iEMSs" value="iEMS"
                                           name="products[]" {{$ot2}}>
                                    <label class="form-check-label" for="iEMSs">iEMS</label>
                                </div>

                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="Partner_Solutions"
                                           value="Partner Solutions" name="products[]" {{$ot3}}>
                                    <label class="form-check-label" for="Partner_Solutions">Partner Solutions</label>
                                </div>

                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="Iot_Suite" value="IoT Suite"
                                           name="products[]" {{$ot4}}>
                                    <label class="form-check-label" for="Iot_Suite">IoT Suite</label>
                                </div>

                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="Edge_Hub" value="Edge Hub"
                                           name="products[]" {{$ot5}}>
                                    <label class="form-check-label" for="Edge_Hub">Edge Hub</label>
                                </div>

                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="otherCheckbox" value="Other"
                                           name="products[]" {{$ot6}}>
                                    <label class="form-check-label" for="otherCheckbox">Other</label>
                                </div>

                                <!-- Other input field -->
                                <div class="row mb-3" id="otherInputField" style="display: {{$otherfiled}};">
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="otherInput" value="{{$othervalue}}"
                                               name="other_product" placeholder="other products">
                                    </div>
                                </div>

                                <button class="button-none"><span class="save-btn d-none" onclick="saveChanges(this)"
                                                                  type="submit">✔</span></button>
                                <span class="cancel-btn d-none button-none" onclick="cancelChanges(this)">✖</span>
                            </div>
                        </div>
                    </form>

                    <script>
                        document.getElementById('otherCheckbox').addEventListener('change', function () {
                            var otherInputField = document.getElementById('otherInputField');
                            if (this.checked) {
                                otherInputField.style.display = 'block';
                            } else {
                                otherInputField.style.display = 'none';
                            }
                        });
                    </script>


                    {{--                        <div class="form-floating mb-3 mx-4 d-flex">--}}
                    {{--                            <select class="form-select" name="products" id="floatingSelect" aria-label="Select Products">--}}
                    {{--                                <option selected disabled>{{ $project->products }}</option>--}}
                    {{--                                <option value="YES">YES</option>--}}
                    {{--                                <option value="NO">NO</option>--}}
                    {{--                                <option value="YES">YES</option>--}}
                    {{--                                <option value="NO">NO</option>--}}
                    {{--                                <option value="YES">YES</option>--}}
                    {{--                                <option value="NO">NO</option>--}}
                    {{--                            </select>--}}
                    {{--                            <label for="floatingSelect">BDM/PM</label>--}}
                    {{--                            <div class="d-inline-grid">--}}
                    {{--                                <button class="button-none"><span class="save-btn d-none" onclick="saveChanges(this)" type="submit">✔</span></button>--}}
                    {{--                                <span class="cancel-btn d-none button-none" onclick="cancelChanges(this)">✖</span>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                </td>
                @can('edit', $project)
                    <td>
                        <span class="edit-btn" onclick="toggleEdit(this)">✎</span>
                    </td>
                @endcan
            </tr>
            <tr>
                <td>SI</td>
                <td class="data">{{ $project->SI }} {{ $project->SIname }}</td>
                <td class="editable">
                    <form action="/project/{{ $project->id }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-floating mb-3 mx-4 d-flex">
                            <select class="form-select" name="SI" id="Si" aria-label="Select SI">
                                <option selected disabled>{{ $project->SI }}</option>
                                <option value="YES">YES</option>
                                <option value="NO">NO</option>
                            </select>
                            <label for="floatingSelect">SI</label><br>
                            <div class="d-inline-grid">
                                <button class="button-none"><span class="save-btn d-none" onclick="saveChanges(this)"
                                                                  type="submit">✔</span></button>
                                <span class="cancel-btn d-none button-none" onclick="cancelChanges(this)">✖</span>
                            </div>
                        </div>
                        @php
                         if ($project->SI == 'YES'){
                             $dis = 'block';
                         }else{
                             $dis = 'none';
                         }

                        @endphp
                        <div class="form-floating mb-3 mx-4" id="siNamefield" style="display: {{ $dis }};">
                            <input type="text" class="form-control" name="SIname" id="siName" value="{{ $project->SIname }}">
                            <label for="siNumber">SI Name</label>
                        </div>
                        <script>
                            function toggleSONumber() {
                                const SI = document.getElementById('Si').value;
                                const siNamefield = document.getElementById('siNamefield');
                                const siNameinput = document.getElementById('siName');

                                if (SI === 'YES') {
                                    siNamefield.style.display = 'block';
                                    siNameinput.setAttribute('required', 'required');
                                } else {
                                    siNamefield.style.display = 'none';
                                    siNameinput.removeAttribute('required');
                                    siNameinput.value = ''; // Clear the SIname input when SI is NO
                                }
                            }

                            document.getElementById('Si').addEventListener('change', toggleSONumber);

                        </script>

                    </form>
                </td>
                @can('edit', $project)
                    <td>
                        <span class="edit-btn" onclick="toggleEdit(this)">✎</span>
                    </td>
                @endcan

            </tr>
            <!-- Repeat the row for each item with similar structure -->
            </tbody>
        </table>
    </div>

    <script>
        function toggleEdit(button) {
            const row = button.closest('tr');
            row.classList.add('edit-mode');
            row.querySelector('.data').style.display = 'none';
            row.querySelector('.editable').style.display = 'inline';
            row.querySelector('.edit-btn').classList.add('d-none');
            row.querySelector('.save-btn').classList.remove('d-none');
            row.querySelector('.cancel-btn').classList.remove('d-none');
        }

        function saveChanges(button) {
            const row = button.closest('tr');
            const input = row.querySelector('.editable input');
            const dataCell = row.querySelector('.data');

            // Save the new value (here, just update the cell)
            dataCell.textContent = input.value;

            row.classList.remove('edit-mode');
            row.querySelector('.data').style.display = '';
            row.querySelector('.editable').style.display = 'none';
            row.querySelector('.edit-btn').classList.remove('d-none');
            row.querySelector('.save-btn').classList.add('d-none');
            row.querySelector('.cancel-btn').classList.add('d-none');
        }

        function cancelChanges(button) {
            const row = button.closest('tr');
            row.classList.remove('edit-mode');
            row.querySelector('.data').style.display = '';
            row.querySelector('.editable').style.display = 'none';
            row.querySelector('.edit-btn').classList.remove('d-none');
            row.querySelector('.save-btn').classList.add('d-none');
            row.querySelector('.cancel-btn').classList.add('d-none');
        }
    </script>
    <div class="row">
        <div class="col-lg-12">
            @if($project->attachments->isEmpty())
                @if($project->sales && $project->sales->user && $project->sales->user->is(Auth::user()))
                    <x-attachment-card :attachments="$project->attachments" :project="$project"></x-attachment-card>
                @endif
            @else
                <x-attachment-card :attachments="$project->attachments" :project="$project"></x-attachment-card>
            @endif
        </div>
    </div>

    @can('edit', $project)
        <div class="card shadow-sm my-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Remarks</h5>
            </div>
            <div class="card-body mt-4">
                <form action="/project/{{ $project->id }}/remarks" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control" id="remarkText" name="remark" rows="4"
                                  placeholder="Enter your remarks here..."></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">

                        <button type="submit" class="btn btn-success">Submit Remark</button>
                    </div>
                </form>
            </div>
        </div>
    @endcan
    @if($updateHistories->isNotEmpty())
        <section class="timeline_area section_padding_130">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-8 col-lg-6">
                        <!-- Section Heading-->
                        <div class="section_heading text-center">
                            <h6>Update History</h6>
                            <div class="line"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <!-- Timeline Area-->
                        <div class="apland-timeline-area">
                            <hr>
                            @php
                                $olddate = '';
                            @endphp

                            @foreach($updateHistories as $updateHistory)
                                @php
                                    $currentDate = $updateHistory->created_at->format('Y-m-d');
                                @endphp

                                @if($currentDate != $olddate)
                                    @if($olddate != '')
                                        <hr>
                        </div>
                    </div><!-- Closing the last single-timeline-area -->

                    @endif
                    <div class="single-timeline-area">
                        <div class="timeline-date wow fadeInLeft" data-wow-delay="0.1s"
                             style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInLeft;">
                            <p>{{ $currentDate }}</p>
                        </div>
                        <div class="row">
                            @php
                                $olddate = $currentDate;
                            @endphp
                            @endif


                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="single-timeline-content d-flex wow fadeInLeft" data-wow-delay="0.3s"
                                     style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">
                                    <div class="timeline-icon"><i class="fa fa-address-card" aria-hidden="true"></i>
                                    </div>
                                    <div class="timeline-text">
                                        <h6>{{ $updateHistory->title }}</h6>
                                        @if($updateHistory->update_type == 'update')
                                            <p>Change {{ $updateHistory->old_value }}
                                                to {{ $updateHistory->new_value }}</p>
                                        @elseif($updateHistory->update_type == 'remark')
                                            <p>Add Remark "{{ $updateHistory->remark }}"</p>
                                        @else
                                            <p>{{$updateHistory->title}} {{$updateHistory->file_name}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @if($olddate != '')

                            @endif
                        </div> <!-- Closing the previous single-timeline-area -->
                    </div>
                </div>
            </div>
        </section>
    @endif

</x-layout>
