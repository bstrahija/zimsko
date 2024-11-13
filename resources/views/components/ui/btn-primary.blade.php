<a href="{{ $href ?? '#' }}"
    class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium
    text-white transition-colors duration-150 hover:bg-primary/90 focus:bg-primary/95 focus:outline-none focus:ring-1 focus:ring-offset-2 {{ $class ?? '' }}">
    {{ $slot }}
</a>
