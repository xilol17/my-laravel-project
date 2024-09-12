@props(['name'])

@if($name == "err")
    @error($name)
    <p class="text-danger fw-semibold fst-italic mt-1 text-center small" style="font-size: 0.75rem;">{{ $message }}</p>
    @enderror
@else
    @error($name)
    <p class="text-danger fw-semibold fst-italic mt-1" style="font-size: 0.75rem;">{{ $message }}</p>
    @enderror
@endif

