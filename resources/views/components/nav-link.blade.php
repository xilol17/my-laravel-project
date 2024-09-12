@props(['active' => false])

<a class="{{ $active ? 'nav-link': 'nav-link collapsed' }}"
    {{ $attributes }}>
{{ $slot }}</a>
