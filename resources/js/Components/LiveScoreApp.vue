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
import { Head, Link, router } from '@inertiajs/vue3';

let props = defineProps({
    game: { type: Object, required: true },
    log: { type: Array, required: true },
});
</script>

<template>
    <div class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] h-full grid-bg">
        <h1 class="relative px-3 py-2 -mt-6 -mr-6 mb-4 -ml-6 text-xs text-center uppercase text-white/80 bg-cyan-400/15">
            <Link href="/live" class="absolute right-3 top-1/2 text-red-500 transition-transform -translate-y-1/2 hover:text-cyan-300 hover:rotate-90">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
            </Link>
            <Link :href="'/live/' + game.game_id + '/players-starting'"
                class="absolute left-3 top-1/2 text-cyan-400 transition-transform -translate-y-1/2 hover:text-cyan-300 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            </Link>

            {{ game.title }}
        </h1>

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

        <div class="grid gap-4 mb-4 score-court grid-cols-[1fr_100px_1fr] md:grid-cols-[1fr_160px_1fr]">
            <div class="sub-bar-home">
                <PlayersOnCourt :game="game" :team="game.home_team" :players="game.home_players_on_court" />
            </div>

            <div class="text-sm text-center uppercase">
                <GameControls :game="game" :log="log" />
            </div>

            <div class="sub-bar-away">
                <PlayersOnCourt :game="game" :team="game.away_team" :players="game.away_players_on_court" />
            </div>
        </div>

        <div class="grid gap-4 items-start score-controls grid-cols-2 sm:grid-cols-[1fr_200px_1fr] md:grid-cols-[1fr_230px_1fr]">
            <div class="flex flex-col-reverse gap-4 lg:flex-row home-controls">
                <div class="w-full">
                    <PlayersOnBench :players="game.home_players_on_bench" :game="game" :team="game.home_team" />
                </div>
                <div class="w-full">
                    <ScoreButtonGroup :team="game.home_team" :game="game" />
                </div>
            </div>

            <div class="overflow-auto h-full max-h-[50svh] hidden sm:block">
                <Log :log="log" :game="game" />
            </div>

            <div class="flex flex-col-reverse gap-4 lg:flex-row-reverse away-controls">
                <div class="w-full">
                    <PlayersOnBench :players="game.away_players_on_bench" :game="game" :team="game.away_team" />
                </div>
                <div class="w-full">
                    <ScoreButtonGroup :team="game.away_team" :game="game" />
                </div>
            </div>
        </div>
    </div>
</template>
