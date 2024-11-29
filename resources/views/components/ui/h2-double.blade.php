<h2 class="space-y-3 text-center mb-10">
    @if (isset($sub))
        <div class="text-sm uppercase font-bold text-secondary">{{ $sub ?? '' }}</div>
    @endif
    <div class="text-3xl uppercase font-medium font-oswald">{{ $slot ?? '' }}</div>
</h2>
