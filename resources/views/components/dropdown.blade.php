@props(['align' => 'right', 'width' => '48', 'contentClasses' => ''])

@php
    // Alinhamento Bootstrap (right ou left)
    $alignmentClass = $align === 'left' ? 'dropdown-menu-start' : 'dropdown-menu-end';

    // Largura customizada opcional (usando estilo inline para personalização)
    $widthStyle = $width === '48' ? 'min-width: 12rem;' : '';
@endphp

<div class="dropdown">
    {{-- Trigger --}}
    <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" role="button">
        {{ $trigger }}
    </div>

    {{-- Menu --}}
    <div class="dropdown-menu {{ $alignmentClass }} shadow {{ $contentClasses }}" style="{{ $widthStyle }}">
        {{ $content }}
    </div>
</div>
