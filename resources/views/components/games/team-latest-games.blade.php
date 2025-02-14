<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
    <x-games.team-latest-games-column :game="$game" :team="$game->homeTeam" :opponent="$game->awayTeam" :side="'home'" :live="$live" :games="$homeGames" />

    <x-games.team-latest-games-column :game="$game" :team="$game->awayTeam" :opponent="$game->homeTeam" :side="'away'" :live="$live" :games="$awayGames" />
</div>
