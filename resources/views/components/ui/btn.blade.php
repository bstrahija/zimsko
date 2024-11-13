@php
    $variant = $variant ?? 'primary';

    if ($variant === 'primary') {
        $classes = 'text-white bg-primary hover:bg-primary/90 focus:bg-primary/95';
    } elseif ($variant === 'secondary') {
        $classes = 'text-white bg-secondary hover:bg-secondary/90 focus:bg-secondary/95';
    } elseif ($variant === 'accent') {
        $classes = 'text-white bg-accent hover:bg-accent/90 focus:bg-accent/95';
    } else {
        $classes = 'text-white bg-accent hover:bg-accent/90 focus:bg-accent/95';
    }

@endphp

<a href="{{ $href ?? '#' }}"
    class="inline-flex items-center justify-center rounded-md border border-transparent px-4 py-2 text-sm font-medium
     transition-colors duration-150 focus:outline-none focus:ring-1 focus:ring-offset-2 {{ $classes }} {{ $class ?? '' }}">
    {{ $slot }}
</a>
