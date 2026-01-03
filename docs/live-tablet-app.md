# Live Tablet App (Vue 3 + Inertia)

The in-game stat keeper is a Vue 3 application mounted via Inertia.

-   Entry: resources/js/live.js
-   Pages: resources/js/Pages/\*.vue (Score.vue is the primary input surface)
-   Modals: resources/js/Components/Modals/\*.vue (opened via vue-final-modal)
-   Helpers: resources/js/helpers/live.js (modal orchestrations, lookups, guards)

## Page flow

1. Select game: /live (index)
2. Setup players: starting lineup and on-court players
3. Scoring surface: /live/{game}/score (Inertia page 'Score')
4. Update stats through modals (score, miss, foul, rebound, blocks, steals, turnover, timeout, substitution)

## Data contract (simplified)

-   Live data provided by LiveScore::toData() (server):
    -   game: {...}
        -   home_team, away_team (+ logos)
        -   home_players, away_players
        -   home_starting_players, away_starting_players
        -   home_players_on_court, away_players_on_court
        -   player_stats: keyed by "player\_\_{id}"
    -   log: event stream of GameLog entries

On update:

-   Client submits action payload to PUT /live/{game}/score
-   ScoreController@update -> LiveScore::addStatFromRequest -> Action
-   Actions write to GameLog and broadcast LiveScoreUpdated
-   Client can listen on Echo channel 'live-score' for real-time updates

## Realtime

-   Echo config in resources/js/echo.js
-   Channel: live-score
-   Event: App\\LiveScore\\Events\\LiveScoreUpdated with payload { event, data }

## Modals

Helpers in helpers/live.js open modals with expected bindings:

-   AddScoreModal: { game, team, players, player? }
-   AddMissModal: { game, team, players }
-   AddFoulModal: { game, team, players, opponentPlayers, type }
-   AddReboundModal, AddStealModal, AddBlockModal, AddTurnoverModal
-   AddSubstitutionModal: { game, team, players, playersOnBench, playerIn?, playerOut? }
-   MultiModal: combined quick actions

Guard rails:

-   checkIfCanUpdateStats: only allow when game.status === 'in_progress'
-   Fouls: prevent sub-in when player has reached foul limit

## Styling & UX

-   Tailwind classes throughout, built with tablet in mind (landscape and portrait)
-   Vue Final Modal for overlays; @meforma/vue-toaster for notifications

## Adding new stat types

-   Add a new Action in app/LiveScore/Actions
-   Update LiveScore::addStatFromRequest mapping
-   Extend helpers/live.js and a modal if needed
-   Ensure GameLog types in config/live.php include your new type
-   Wire up UI affordances in Score.vue
