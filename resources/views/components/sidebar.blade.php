@php use Illuminate\Support\Facades\Auth; @endphp
    <!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @php
            if(Auth::user()->sales){
                $main = 'My Projects';
                $link = '/my-project';
                $link2 = 'my-project';
            }else{
                $main = 'Dashboard';
                $link = '/dashboard';
                $link2 = 'dashboard';
            }
        @endphp
        <li class="nav-item">
            <x-nav-link href="{{ $link }}" :active="request()->is($link2)">
                <i class="bi bi-grid"></i>
                <span>{{ $main }}</span>
            </x-nav-link>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Projects</span>
                @if(Auth::user()->sales)
                    <button type="button" class="btn btn-outline-primary ctn" data-bs-toggle="modal"
                            data-bs-target="#verticalycentered">Create New
                    </button>
                @endif

                <i class="bi bi-chevron-down ms-auto"></i>
            </a>


            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                @if(Auth::user()->admin)
                    @if($sideprojects->isEmpty())
                        <li class="nav-item">
                            not exists projects
                        </li>
                    @else
                        @foreach($sideprojects as $sideproject)
                            <li class="nav-item">
                                <abbr
                                    title="{{ $sideproject->project->status }} by {{ $sideproject->project->salesName }}   Win Rate: {{ $sideproject->project->winRate }}%">
                                    <x-navProject-link href="/project/{{ $sideproject->project->id }}"
                                                       :active="request()->is('project/' . $sideproject->project->id)">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-circle"></i>
                                            <span>
                                        {{ $sideproject->project->name }}
                                    </span>
                                        </div>
                                        <x-winrate-indicator :winrate="$sideproject->project->winRate"/>
                                    </x-navProject-link>
                                </abbr>
                            </li>
                        @endforeach
                    @endif
                @else
                    @if($sideprojects->isEmpty())
                        <li class="nav-item">
                            not exists projects
                        </li>
                    @else
                        @foreach($sideprojects as $sideproject)
                            <li class="nav-item">
                                <abbr
                                    title="{{ $sideproject->status }} by {{ $sideproject->salesName }}   Win Rate: {{ $sideproject->winRate }}%">
                                    <x-navProject-link href="/project/{{ $sideproject->id }}"
                                                       :active="request()->is('project/' . $sideproject->id)">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-circle"></i>
                                            <span>
                                        {{ $sideproject->name }}
                                    </span>
                                        </div>
                                        <x-winrate-indicator :winrate="$sideproject->winRate"/>
                                    </x-navProject-link>
                                </abbr>
                            </li>
                        @endforeach
                    @endif
                @endif


            </ul>
        </li>
        <li class="nav-item">
            <x-nav-link href="/projects-list" :active="request()->is('projects-list')">
                <i class="bi bi-grid"></i>

                <span>Project list</span>
            </x-nav-link>

        </li><!-- End projects list Nav -->
        @if(Auth::user()->admin)
            <li class="nav-item">
                <x-nav-link href="/sales-list" :active="request()->is('sales-list')">
                    <i class="bi bi-grid"></i>

                    <span>Account Management</span>
                </x-nav-link>
            </li>
        @endif



    </ul>

</aside><!-- End Sidebar-->

