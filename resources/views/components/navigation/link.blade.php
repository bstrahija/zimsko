@php
    $href = $attributes->get('href');
    $target = $attributes->get('target');
@endphp

<a href="{{ $href }}" class="inline-block text-sm font-semibold uppercase transition-colors text-secondary lg:text-white font-nav hover:text-primary lg:text-base"
    target="{{ $target ?? '_self' }}">
    {{ $slot }}
</a>
