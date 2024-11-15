@php
    $variant = $variant ?? 'default';

    if ($variant === 'primary') {
        $classes = 'text-white bg-primary hover:bg-primary/90 focus:bg-primary/95';
    } elseif ($variant === 'secondary') {
        $classes = 'text-white bg-secondary hover:bg-secondary/90 focus:bg-secondary/95';
    } elseif ($variant === 'accent') {
        $classes = 'text-white bg-accent hover:bg-accent/90 focus:bg-accent/95';
    } elseif ($variant === 'error') {
        $classes = 'text-white bg-rose-500 hover:bg-rose-600 focus:bg-rose-700';
    } elseif ($variant === 'success') {
        $classes = 'text-white bg-emerald-500 hover:bg-emerald-600 focus:bg-emerald-700';
    } elseif ($variant === 'info') {
        $classes = 'text-white bg-indigo-500 hover:bg-indigo-600 focus:bg-indigo-700';
    } elseif ($variant === 'dark') {
        $classes = 'text-white bg-gray-900 hover:bg-gray-800 focus:bg-gray-700';
    } else {
        $classes = 'text-gray-900 bg-gray-50 hover:bg-gray-200/50 focus:bg-gray-100/75 border border-gray-200';
    }
@endphp

<a href="{{ $href ?? '#' }}"
    class="
        inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background
        transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring/70 focus-visible:ring-offset-2
        disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:shrink-0
        shadow-sm shadow-black/5 h-9 px-4 py-2 {{ $classes }} {{ $class ?? '' }}">
    {{ $slot }}
</a>
