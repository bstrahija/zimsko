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
import LiveTopBar from "./LiveTopBar.vue";

let props = defineProps({
    game: { type: Object, required: true },
    log: { type: Array, required: true },
});
</script>

<template>
    <div class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] h-full grid-bg">
        <LiveTopBar :title="game.title" :game="game" :backUrl="'/live/' + game.id + '/players-starting'" />

        <div class="grid gap-4 mb-4 score-top grid-cols-[1fr_1fr] md:grid-cols-[1fr_100px_1fr] lg:grid-cols-[1fr_120px_1fr] xl:grid-cols-[1fr_160px_1fr]">
            <div class="space-y-4 home-team-top">
                <ScoreBar :score="game.home_score" :team="game.home_team" :side="'home'" />
            </div>

            <div class="hidden text-center rounded bg-slate-800/40 md:block">
                <Pretty class="" />
            </div>

            <div class="space-y-4 away-team-top">
                <ScoreBar :score="game.away_score" :team="game.away_team" :side="'away'" />
            </div>
        </div>

        <div class="grid gap-4 mb-4 score-top grid-cols-[1fr_100px_1fr] md:grid-cols-[1fr_100px_1fr] lg:grid-cols-[1fr_120px_1fr] xl:grid-cols-[1fr_160px_1fr]">
            <div class="space-y-4 home-team-top">
                <FoulsTimeouts :side="'home'" :team="game.home_team" :game="game" />
            </div>

            <div class="grid text-center rounded bg-slate-800/40">
                <PeriodIndicator :game="game" />
            </div>

            <div class="space-y-4 away-team-top">
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
