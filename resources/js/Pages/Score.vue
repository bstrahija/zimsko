<script setup>
import { onMounted, toRefs } from 'vue';
import { Head } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import FoulsTimeouts from '../Components/FoulsTimeouts.vue';
import GameControls from '../Components/GameControls.vue';
import Log from '../Components/Log.vue';
import PlayerBlock from '../Components/PlayerBlock.vue';
import PlayersOnBench from '../Components/PlayersOnBench.vue';
import PlayersOnCourt from '../Components/PlayersOnCourt.vue';
import ScoreBar from '../Components/ScoreBar.vue';
import ScoreButton from '../Components/ScoreButton.vue';
import ScoreButtonGroup from '../Components/ScoreButtonGroup.vue';
import PeriodIndicator from '../Components/PeriodIndicator.vue';
import Pretty from '../Components/Pretty.vue';

let props = defineProps({
    log: Array,
    game: Object,
});
</script>

<template>
    <Layout>

        <Head title="Zimsko Live Score" />

        <div class="flex relative justify-center items-center min-h-screen">
            <div class="w-full space-y-2 max-w-[1920px]">
                <div
                    class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] grid-bg">
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
                        <div class="grid gap-4 home-controls" style="grid-template-columns: 1fr 1fr">
                            <PlayersOnBench :players="game.home_players_on_bench" :game="game" :team="game.home_team" />

                            <ScoreButtonGroup :team="game.home_team" :game="game" />
                        </div>

                        <div class="overflow-auto h-full max-h-[50svh]">
                            <Log :log="log" :game="game" />
                        </div>

                        <div class="grid gap-4 away-controls" style="grid-template-columns: 1fr 1fr">
                            <ScoreButtonGroup :team="game.away_team" :game="game" />

                            <PlayersOnBench :players="game.away_players_on_bench" :game="game" :team="game.away_team" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-span-2">
                <Log :log="log" :game="game" :game="game" />
            </div> -->

        <!-- <div>
            <small>
                <pre>{{ game }}</pre>
            </small>
        </div> -->
    </Layout>
</template>
