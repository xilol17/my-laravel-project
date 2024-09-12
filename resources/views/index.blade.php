<x-layout>
    <x-slot:heading>
        Home
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
    <!-- Include Select2 CSS (Remove this if Select2 is no longer used) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-6">
            <div class="row">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Latest Projects</h5>

                        <div class="activity">

                            @foreach($latestProjects as $latestProject)
                                <div class="activity-item d-flex">
                                    <x-time-recentview :time="$latestProject->created_at"></x-time-recentview>
                                    <div class="activity-content">
                                        <a href="/project/{{ $latestProject->id }}" class="fw-bold text-dark">{{ $latestProject->name }}</a><span class="text-muted small pt-2 ps-1">created at {{ $latestProject->created_at->format('Y-m-d') }}
</span>
                                    </div><!-- End activity item-->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-6">
            <!-- Recent Update -->
            <div class="card m-lg-0">
                <div class="card-body">
                    <h5 class="card-title">Recent Update</h5>

                    <div class="activity">

                        @foreach($UpdatedprojectsTime as $UpdatedprojectTime)
                            <div class="activity-item d-flex">
                                <x-time-newproject :time="$UpdatedprojectTime->hoursAgo"></x-time-newproject>
                                <div class="activity-content">
                                        <a href="/project/{{ $UpdatedprojectTime->id }}" class="fw-bold text-dark">{{ $UpdatedprojectTime->name }}</a> by <span class="text-success small pt-1 fw-bold">{{ $UpdatedprojectTime->salesName }}</span> last updated at <span class="text-muted small pt-2 ps-1">{{ \Carbon\Carbon::parse($UpdatedprojectTime->lastUpdateDate)->format('Y-m-d') }}</span>
                                </div><!-- End activity item-->
                            </div>
                        @endforeach

                    </div>
                </div>
            </div><!-- End Recent Activity -->
        </div>
    </div><!-- End Right side columns -->
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
                                                ['label' => 'Project Name', 'field' => 'name'],
                                                ['label' => 'Region', 'field' => 'Region'],
                                                ['label' => 'Sales Name', 'field' => 'salesName'],
                                                ['label' => 'Customer Name', 'field' => 'customerName'],
                                                ['label' => 'Revenue', 'field' => 'revenue'],
                                                ['label' => 'Win Rate', 'field' => 'winRate'],
                                            ] as $column)
                                                <th>
                                                    <a href="{{ route('index', array_merge(request()->query(), ['sort_field' => $column['field'], 'sort_order' => request('sort_field') == $column['field'] && request('sort_order') == 'asc' ? 'desc' : 'asc', 'page' => request('page')])) }}">
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

</x-layout>
