<div class="{{ $class ?? '' }}">
    {{ $slot }}

    <x-basket.leaderboard hideTitle="true" class="mb-12" />

    <x-social />

    <x-basket.leaders />
</div>
