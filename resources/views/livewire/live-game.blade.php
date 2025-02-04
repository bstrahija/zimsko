<div>
    <x-games.score :game="$game" />

    <x-games.stats :game="$game" :live="$live" />

    <x-games.log-stream :game="$game" :live="$live" />
</div>
