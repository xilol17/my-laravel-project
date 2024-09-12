<x-layout>
    <x-slot:heading>
        Project List
    </x-slot:heading>
    <style>
        .filter-icon {
            cursor: pointer;
            font-size: 1.2rem;
            color: #007bff;
            margin-left: 8px;
        }
        .filter-icon:hover {
            color: #0056b3;
        }
        .filter-icon.asc::after {
            content: "\f0de"; /* Font Awesome up arrow */
            font-family: "Font Awesome 5 Free";
        }
        .filter-icon.desc::after {
            content: "\f0dd"; /* Font Awesome down arrow */
            font-family: "Font Awesome 5 Free";
        }
        .hidden {
            display: none;
        }
    </style>

    <div class="container mt-5">
        <div class="form-outline mb-4 d-flex align-items-center">
            <input type="text" class="form-control" id="datatable-search-input" placeholder="Search..." value="{{ request('search') }}" />
            <label class="form-label" for="datatable-search-input"></label>
            <button id="clear-search" class="btn btn-outline-secondary ml-2" style="display: none;">&#x2715;</button> <!-- Close button -->
        </div>

        <div id="datatable" class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    @foreach([
                        ['label' => 'Project Name', 'field' => 'name'],
                        ['label' => 'Region', 'field' => 'Region'],
                        ['label' => 'Sales Name', 'field' => 'salesName'],
                        ['label' => 'Customer Name', 'field' => 'customerName'],
                        ['label' => 'ASSC Visit Date', 'field' => 'visitDate'],
                        ['label' => 'Discussion Start Date', 'field' => 'startDate'],
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
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->Region }}</td>
                        <td>{{ $project->salesName }}</td>
                        <td>{{ $project->customerName }}</td>
                        <td>{{ $project->visitDate }}</td>
                        <td>{{ $project->startDate }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $projects->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('datatable-search-input');
            const clearButton = document.getElementById('clear-search');

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
            }
        });
    </script>
</x-layout>
