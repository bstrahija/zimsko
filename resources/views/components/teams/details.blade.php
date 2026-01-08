@if ($team->photo())
    <a
        href="{{ $team->photo('original') }}"
        target="_blank"
        class="lightbox"
        data-pswp-width="{{ $team->photoSize('w') }}"
        data-pswp-height="{{ $team->photoSize('h') }}">
        <img
            src="{{ $team->photo('original') }}"
            alt="{{ $team->title }}"
            class="w-full">
    </a>
@endif

<table class="mt-8 w-full text-left text-xs">
    <tr class="border-b border-gray-200">
        <th class="py-2">Utakmica ukupno:</th>
        <td class="py-2">{{ $team->gameCount() }}</td>
    </tr>
    <tr class="border-b border-gray-200">
        <th class="py-2">Utakmica ({{ $currentEvent?->title ?? 'Zimsko' }}):</th>
        <td class="py-2">{{ $team->gameCountCurrent() }}</td>
    </tr>
    <tr class="border-b border-gray-200">
        <th class="py-2">Prosjek ukupno:</th>
        <td class="py-2">{{ $team->pointsAverage() }}</td>
    </tr>
    <tr class="border-b border-gray-200">
        <th class="py-2">Prosjek ({{ $currentEvent?->title ?? 'Zimsko' }}):</th>
        <td class="py-2">{{ $team->pointsAverageCurrent() }}</td>
    </tr>
</table>
