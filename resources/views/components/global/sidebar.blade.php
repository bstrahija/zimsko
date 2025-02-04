<div class="{{ $class ?? '' }}">
    {{ $slot }}

    <x-leaderboards.leaderboard-widget hideTitle="true" class="mb-12" />

    <x-global.social />

    <x-leaderboards.points-widget />
</div>
