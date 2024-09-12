<x-layout>
    <x-slot:heading>
        Dashboard
    </x-slot:heading>

    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-6">
            <div class="row">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent View</h5>

                        <div class="activity">

                            @foreach($recentViews as $recentView)
                                <div class="activity-item d-flex">
                                    <x-time-recentview :time="$recentView->viewed_at"></x-time-recentview>
                                    <div class="activity-content">
                                        <a href="/project/{{ $recentView->project->id }}" class="fw-bold text-dark">{{ $recentView->project->name }}</a> by <span class="text-success small pt-1 fw-bold">{{ $recentView->project->salesName }}</span><span class="text-muted small pt-2 ps-1">{{ $recentView->project->lastUpdateDate ? 'last updated at '.\Carbon\Carbon::parse($recentView->project->lastUpdateDate)->format('Y-m-d') : 'Not Updated Yet' }}
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
        <div class="col-lg-8">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">New Project</h5>

                        <div class="activity">
                            @foreach($NewprojectsTime as $Newproject)
                                <div class="activity-item d-flex">
                                    <x-time-newproject :time="$Newproject->hoursAgo"></x-time-newproject>
                                    <div class="activity-content">
                                        <a href="/project/{{ $Newproject->id }}" class="fw-bold text-dark">{{ $Newproject->name }}</a> by <span class="text-success small pt-1 fw-bold">{{ $Newproject->salesName }}</span> created at <span class="text-muted small pt-2 ps-1">{{ $Newproject->created_at->format('Y.m.d') }}</span>
                                    </div>
                                </div><!-- End activity item-->
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
