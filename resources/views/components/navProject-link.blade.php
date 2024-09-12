@props(['active' => false])

<a class="{{ $active ? 'nav-link d-flex justify-content-between align-items-center': 'nav-link collapsed d-flex justify-content-between align-items-center' }}"
    {{ $attributes }}>
    {{ $slot }}</a>
