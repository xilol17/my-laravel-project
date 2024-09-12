<!-- resources/views/components/winrate-indicator.blade.php -->
@props(['winrate'])

@php
    $color = '#C8102E'; // Default to dark red
    if ($winrate == 100) {
        $color = '#00ff00'; // Green
    } elseif ($winrate >= 75) {
        $color = '#9ACD32'; // Light green
    } elseif ($winrate >= 50) {
        $color = '#FFD700'; // Yellow
    } elseif ($winrate >= 25) {
        $color = '#FF8C00'; // Orange
    }
@endphp

<div class="d-flex align-items-center">
    <div class="status-circle me-2" style="width: 10px; height: 10px; border-radius: 50%; background-color: {{ $color }};"></div>
</div>
