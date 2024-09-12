<x-layout>
    <x-slot:heading>
        Account Management
    </x-slot:heading>
    <style>
        .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .form-control, .form-select {
            border-radius: 0.375rem;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-edit, .btn-delete {
            font-size: 1.2rem;
        }
        .btn-edit {
            color: #0d6efd;
        }
        .btn-delete {
            color: #dc3545;
        }
        .btn-edit:hover, .btn-delete:hover {
            text-decoration: none;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">My Projects</h5>
                        <div class="activity">
                            <div class="col-lg-12">
                                <!-- Search Bar -->
                                <div class="form-outline mb-4 d-flex align-items-center">
                                    <input type="text" class="form-control" id="datatable-search-input" name="search" placeholder="Search..." value="{{ request('search') }}" />
                                    <label class="form-label" for="datatable-search-input"></label>
                                    <button id="clear-search" class="btn btn-outline-secondary ml-2" style="display: {{ request('search') ? 'inline-block' : 'none' }};">&#x2715;</button> <!-- Close button -->
                                </div>
                                <div id="datatable" class="table-responsive mt-4">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th> <!-- Add a header for the project number -->
                                            @foreach([
                                                ['label' => 'Sales Name', 'field' => 'name'],
                                                ['label' => 'Region', 'field' => 'region'],
                                                ['label' => 'Email', 'field' => 'email'],
                                                ['label' => 'Username', 'field' => 'username'],
                                            ] as $column)
                                                <th>
                                                    <a href="{{ route('sales_list', array_merge(request()->query(), ['sort_field' => $column['field'], 'sort_order' => request('sort_field') == $column['field'] && request('sort_order') == 'asc' ? 'desc' : 'asc', 'page' => request('page')])) }}">
                                                        {{ $column['label'] }}
                                                        @if (request('sort_field') == $column['field'])
                                                            <span class="{{ request('sort_order') }}">{{ request('sort_order') == 'asc' ? '▲' : '▼' }}</span>
                                                        @endif
                                                    </a>
                                                </th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $index => $user)
                                            <tr>
                                                <td>{{ $users->firstItem() + $index }}</td> <!-- Display the index number -->
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->region }}</td>
                                                <td>{{ $user->user->email }}</td>
                                                <td>{{ $user->user->username }}</td>
                                                <td class="text-end"> <!-- Add this class to align the buttons to the right -->
                                                    <div class="d-inline-flex">
                                                        <form action="{{ route('sales.destroy', $user->user->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        {{ $users->links('vendor.pagination.bootstrap-5') }}

                                        <form id="delete-sales" method="POST" action="">
                                            @csrf
                                        </form>
                                        </tbody>
                                    </table>
{{--                                    @if($projects->isEmpty())--}}
{{--                                        <p id="notExist">No existing project try to add a new project</p>--}}
{{--                                    @endif--}}
{{--                                    {{ $projects->links('vendor.pagination.bootstrap-5') }}--}}
                                    <div class="mt-4">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addsales">Add New Sales</button>
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <!-- Include jQuery and Select2 JS (Remove this if Select2 is no longer used) -->
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const searchInput = document.getElementById('datatable-search-input');
                                    const clearButton = document.getElementById('clear-search');
                                    const notExistParagraph = document.getElementById('notExist');

                                    searchInput.addEventListener('input', () => {
                                        clearButton.style.display = searchInput.value ? 'inline-block' : 'none';
                                    });

                                    searchInput.addEventListener('keydown', (event) => {
                                        if (event.key === 'Enter') {
                                            const searchValue = searchInput.value;
                                            const searchParams = new URLSearchParams(window.location.search);
                                            searchParams.set('search', searchValue);
                                            searchParams.set('page', 1); // Reset to the first page

                                            window.location.search = searchParams.toString(); // Triggers a new request with the search query
                                        }
                                    });

                                    clearButton.addEventListener('click', () => {
                                        searchInput.value = '';
                                        clearButton.style.display = 'none';

                                        const searchParams = new URLSearchParams(window.location.search);
                                        searchParams.delete('search'); // Remove the search parameter
                                        searchParams.set('page', 1); // Reset to the first page

                                        window.location.search = searchParams.toString(); // Reload the page without search parameter
                                    });

                                    // Handle page load with existing search term
                                    if (searchInput.value) {
                                        clearButton.style.display = 'inline-block';
                                        notExistParagraph.textContent = 'No projects found for the search term. Try a different query.';
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addsales" tabindex="-1">
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
                        <h5 class="card-title">Create New Sales Account</h5>
                        <hr>
                        <div class="modal-body">
                            <form action="/addsales" id="addSales" method="POST">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingUsername1" name="username" placeholder="example123" value="{{ old('username') }}" required>
                                    <label for="floatingUsername1">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingUsername2" name="name" placeholder="example123" value="{{ old('name') }}" required>
                                    <label for="floatingUsername2">Sales Full Name</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingEmail" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                                    <label for="floatingEmail">Email address</label>
                                </div>
                                <div class="form-floating mb-3">
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
                                    <label for="floatingSelect">Select Region</label>

                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                                    <label for="floatingPassword">Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingPasswordConfirmation" name="password_confirmation" placeholder="Password Confirmation" required>
                                    <label for="floatingPasswordConfirmation">Password Confirmation</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="saveButton">Save changes</button>
                                </div>
                            </form>
                            <script>
                                document.getElementById('saveButton').addEventListener('click', function () {
                                    let isValid = true;
                                    const form = document.getElementById('addSales');
                                    const inputs = form.querySelectorAll('input');

                                    // Reset previous validation styles
                                    inputs.forEach(input => {
                                        input.style.borderColor = '';
                                        input.classList.remove('invalid');
                                    });

                                    // Validate input fields
                                    inputs.forEach(input => {
                                        if (input.value.trim() === '') {
                                            isValid = false;
                                            input.classList.add('invalid');
                                        }
                                    });

                                    if (isValid) {
                                        form.submit(); // Submit the form if all fields are valid
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Vertically centered Modal-->


</x-layout>
