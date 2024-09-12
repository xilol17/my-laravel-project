<x-layout>
    <x-slot:heading>
        Project List
    </x-slot:heading>
    <style>
        a {
            text-decoration: none;
        }
        th {
            white-space: nowrap; /* Prevents header text from wrapping */
        }
        .form-control, .form-select {
            margin-bottom: 0.5rem;
        }
    </style>
    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Display the flash message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="container mt-5">
                    <!-- Search Bar -->
                    <div class="form-outline mb-4 d-flex align-items-center">
                        <input type="text" class="form-control" id="datatable-search-input" name="search" placeholder="Search..." value="{{ request('search') }}" />
                        <label class="form-label" for="datatable-search-input"></label>
                        <button id="clear-search" class="btn btn-outline-secondary ml-2" style="display: {{ request('search') ? 'inline-block' : 'none' }};">&#x2715;</button> <!-- Close button -->
                    </div>

                    <!-- Filters -->
                    <form id="filter-form" action="{{ route('projects.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="region" class="form-select">
                                    <option value="">Select Region</option>
                                    <option value="Malaysia" {{ request('region') == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                                    <option value="Singapore" {{ request('region') == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                    <option value="Thailand" {{ request('region') == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                                    <option value="Vietnam" {{ request('region') == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                                    <option value="Indonesia" {{ request('region') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="ROA" {{ request('region') == 'ROA' ? 'selected' : '' }}>ROA</option>
                                    <option value="Korea" {{ request('region') == 'Korea' ? 'selected' : '' }}>Korea</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <!-- Searchable Select Box for Sales Name -->
                                <select name="sales_name" id="sales-name-select" class="form-select">
                                    <option value="">Select Sales Name</option>
                                    @foreach($uniqueSalesNames as $salesName)
                                        <option value="{{ $salesName }}" {{ request('sales_name') == $salesName ? 'selected' : '' }}>{{ $salesName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select name="win_rate" class="form-select">
                                    <option value="">Select Win Rate</option>
                                    <option value="0" {{ request('win_rate') == '0' ? 'selected' : '' }}>0%</option>
                                    <option value="25" {{ request('win_rate') == '25' ? 'selected' : '' }}>25%</option>
                                    <option value="50" {{ request('win_rate') == '50' ? 'selected' : '' }}>50%</option>
                                    <option value="75" {{ request('win_rate') == '75' ? 'selected' : '' }}>75%</option>
                                    <option value="100" {{ request('win_rate') == '100' ? 'selected' : '' }}>100%</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 mt-3 row">
                            <div class="col-md-6">
                                <!-- Apply Filters and Cancel Filters aligned left -->
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                                <button type="button" id="cancel-filters" class="btn btn-outline-secondary">Cancel Filters</button>
                            </div>

                            <div class="col-md-6 text-end">
                                <!-- Export Form and Button aligned right -->
                                <button type="submit" class="btn btn-outline-primary" form="export-form">Export Excel</button>
                            </div>
                        </div>

                    </form>
                    <form id="export-form" action="{{ route('projects.export') }}" method="GET" class="d-inline">
                        @foreach($projects as $project)
                            <input type="hidden" name="project_ids[]" value="{{ $project->id }}">
                        @endforeach
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="region" value="{{ request('region') }}">
                        <input type="hidden" name="sales_name" value="{{ request('sales_name') }}">
                        <input type="hidden" name="win_rate" value="{{ request('win_rate') }}">
                    </form>

                    <div id="datatable" class="table-responsive mt-4">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th> <!-- Add a header for the project number -->
                                @foreach([
                                    ['label' => 'Project Name', 'field' => 'name'],
                                    ['label' => 'Region', 'field' => 'Region'],
                                    ['label' => 'Sales Name', 'field' => 'salesName'],
                                    ['label' => 'Customer Name', 'field' => 'customerName'],
                                    ['label' => 'Revenue', 'field' => 'revenue'],
                                    ['label' => 'Win Rate', 'field' => 'winRate'],
                                ] as $column)
                                    <th>
                                        <a href="{{ route('projects.index', array_merge(request()->query(), ['sort_field' => $column['field'], 'sort_order' => request('sort_field') == $column['field'] && request('sort_order') == 'asc' ? 'desc' : 'asc', 'page' => request('page')])) }}">
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
                            @foreach($projects as $index => $project)
                                <tr>
                                    <td>{{ $projects->firstItem() + $index }}</td> <!-- Display the index number -->
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->region }}</td>
                                    <td>{{ $project->salesName }}</td>
                                    <td>{{ $project->customerName }}</td>
                                    <td>
                                        <div style="display: flex; align-items: center; white-space: nowrap;">
                                            $ {{ number_format($project->revenue, 2) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <x-winrate-indicator :winrate="$project->winRate" />
                                            <span style="margin-left: 8px; white-space: nowrap;">{{ $project->winRate }}%</span>
                                        </div>
                                    </td>
                                    <td><a href="/project/{{ $project->id }}">View</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($projects->isEmpty())
                            <p id="notExist">No existing project try to add a new project</p>
                        @endif

                        {{ $projects->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('datatable-search-input');
            const clearButton = document.getElementById('clear-search');
            const cancelFiltersButton = document.getElementById('cancel-filters');
            const notExistParagraph = document.getElementById('notExist');
            const filterForm = document.getElementById('filter-form');
            const salesNameSelect = $('#sales-name-select');

            // Initialize Select2
            salesNameSelect.select2({
                placeholder: 'Select Sales Name',
                width: '100%'
            });

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

            cancelFiltersButton.addEventListener('click', () => {
                const searchParams = new URLSearchParams(window.location.search);
                searchParams.delete('search'); // Remove the search parameter
                searchParams.delete('region'); // Remove the region filter
                searchParams.delete('sales_name'); // Remove the sales name filter
                searchParams.delete('win_rate'); // Remove the win rate filter
                searchParams.set('page', 1); // Reset to the first page

                window.location.search = searchParams.toString(); // Reload the page without filters
            });

            // Handle page load with existing search term
            if (searchInput.value) {
                clearButton.style.display = 'inline-block';
                notExistParagraph.textContent = 'No projects found for the search term. Try a different query.';
            }
        });
    </script>
</x-layout>
