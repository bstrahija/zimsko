<h2 class="mb-10 space-y-3 text-center">
    @if (isset($sub))
        <div class="text-sm font-bold uppercase text-secondary">{{ $sub ?? '' }}</div>
    @endif
    <div class="text-3xl font-bold uppercase text-secondary font-heading">{{ $slot ?? '' }}</div>
</h2>
