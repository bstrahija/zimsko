<input
    class="flex w-full rounded border border-input bg-background px-5 py-3 text-sm text-foreground shadow-sm
    shadow-black/5 ring-offset-background transition-shadow placeholder:text-muted-foreground/70
    focus-visible:border-ring focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring/30 focus-visible:ring-offset-2
    disabled:cursor-not-allowed disabled:opacity-50 {{ $class ?? '' }}"
    id="{{ $id ?? '' }}" placeholder="{{ $placeholder ?? '' }}" type="{{ $type ?? 'text' }}">
