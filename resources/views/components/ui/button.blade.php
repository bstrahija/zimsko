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
    class="
        inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background
        transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring/70 focus-visible:ring-offset-2
        disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:shrink-0
        shadow-sm shadow-black/5 h-9 px-4 py-2 {{ $classes }} {{ $class ?? '' }}">
    {{ $slot }}
</a>
