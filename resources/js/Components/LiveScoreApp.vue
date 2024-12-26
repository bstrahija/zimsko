<script setup>
import ScoreButtonGroup from "./ScoreButtonGroup.vue";
import ScoreBar from "./ScoreBar.vue";
import FoulsTimeouts from "./FoulsTimeouts.vue";
import PlayersOnCourt from "./PlayersOnCourt.vue";
import PlayersOnBench from "./PlayersOnBench.vue";
import GameControls from "./GameControls.vue";
import PeriodIndicator from "./PeriodIndicator.vue";
import Log from "./Log.vue";
import Pretty from "./Pretty.vue";

let props = defineProps({
    game: Object,
    log: Array,
});
</script>

<template>
    <div class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] grid-bg">
        <div class="grid gap-4 mb-4 score-top" style="grid-template-columns: 1fr 160px 1fr">
            <div class="space-y-4 home-team-top">
                <ScoreBar :score="game.home_score" :team="game.home_team" :side="'home'" />

                <FoulsTimeouts :side="'home'" :team="game.home_team" :game="game" />
            </div>

            <div class="grid text-center rounded bg-slate-800/40">
                <Pretty />

                <PeriodIndicator :game="game" />
            </div>

            <div class="space-y-4 away-team-top">
                <ScoreBar :score="game.away_score" :team="game.away_team" :side="'away'" />

                <FoulsTimeouts :side="'away'" :team="game.away_team" :game="game" />
            </div>
        </div>

        <div class="grid gap-12 mb-4 score-court" style="grid-template-columns: 1fr 8% 1fr">
            <div class="grid sub-bar-home">
                <PlayersOnCourt :game="game" :team="game.home_team" :players="game.home_players_on_court" />
            </div>

            <div class="grid text-sm text-center uppercase">
                <GameControls :game="game" :log="log" />
            </div>

            <div class="grid sub-bar-away">
                <PlayersOnCourt :game="game" :team="game.away_team" :players="game.away_players_on_court" />
            </div>
        </div>

        <div class="grid gap-4 score-controls" style="grid-template-columns: 1fr 25% 1fr">
            <div class="grid flex-row grid-cols-1 gap-4 md:grid-cols-2 home-controls sm:flex sm:flex-row-reverse">
                <PlayersOnBench :players="game.home_players_on_bench" :game="game" :team="game.home_team" />

                <ScoreButtonGroup :team="game.home_team" :game="game" />
            </div>

            <div class="overflow-auto h-full max-h-[50svh] hidden sm:block">
                <Log :log="log" :game="game" />
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 away-controls">
                <ScoreButtonGroup :team="game.away_team" :game="game" />

                <PlayersOnBench :players="game.away_players_on_bench" :game="game" :team="game.away_team" />
            </div>
        </div>
    </div>
</template>
