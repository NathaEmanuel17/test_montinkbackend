@props(['active' => false])

@php
    $classes = 'nav-link';
    if ($active) {
        $classes .= ' active fw-semibold text-dark border-bottom border-primary';
    } else {
        $classes .= ' text-secondary';
    }
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
