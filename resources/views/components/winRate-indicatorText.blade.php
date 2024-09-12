<!-- resources/views/components/winrate-indicator.blade.php -->
@props(['winrate'])

@php
    $text = "";
    $color = '#C8102E'; // Default to dark red
    if ($winrate == 100) {
        $color = '#00ff00'; // Green
        $text = "Completed";
    } elseif ($winrate >= 75) {
        $color = '#9ACD32'; // Light green
    } elseif ($winrate >= 50) {
        $color = '#FFD700'; // Yellow
    } elseif ($winrate >= 25) {
        $color = '#FF8C00'; // Orange
    }
@endphp

<h6 {{ $attributes->merge(['style'=>"color:$color;"]) }}> {{ $slot }} {{ $text }}</h6>

