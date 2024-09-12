@props(['time'])


@if($time < 1)
    @if($time * 60 < 10)  <!-- If less than 10 minute -->
    <div class="activite-label">Just now</div>
        @php
            $color = 'text-success'; // Green
        @endphp
    @elseif($time * 60 <= 30)
        <div class="activite-label">30 min</div>
        @php
            $color = 'text-danger'; // Green
        @endphp
    @else
        @if(round($time * 60) == 60)
            <div class="activite-label">1 hour</div>
            @php
                $color = 'text-primary'; // Green
            @endphp
        @else
            <div class="activite-label">{{ round($time * 60) }} min</div>
            @php
                $color = 'text-danger'; // Green
            @endphp
        @endif
    @endif
@elseif($time < 24)
    <div class="activite-label">{{ round($time) }} hours</div>
    @php
    if (round($time) > 12){
        $color = 'text-primary';
    }else{
        $color = 'text-info';
    }
    @endphp
@else
    @php
        $daysAgo = floor($time / 24);
    @endphp
    <div class="activite-label">{{ $daysAgo }} days</div>
    @php
        $color = 'text-muted'; // Green
    @endphp
@endif

<i class='bi bi-circle-fill activity-badge align-self-start {{$color}}'></i>
