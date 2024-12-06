<script setup>
// import Layout from './Layout';
import { Head } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import FoulsTimeouts from '../Components/FoulsTimeouts.vue';
import Log from '../Components/Log.vue';
import PlayerBlock from '../Components/PlayerBlock.vue';
import PlayersOnBench from '../Components/PlayersOnBench.vue';
import PlayersOnCourt from '../Components/PlayersOnCourt.vue';
import ScoreBar from '../Components/ScoreBar.vue';
import ScoreButton from '../Components/ScoreButton.vue';
import ScoreButtonGroup from '../Components/ScoreButtonGroup.vue';
import PeriodIndicator from '../Components/PeriodIndicator.vue';
import Pretty from '../Components/Pretty.vue';

defineProps({
    log: Array,
    game: Object,
    live: Object,
});
</script>

<template>
    <Layout>

        <Head title="Zimsko Live Score" />

        <div class="flex relative justify-center items-center min-h-screen">
            <div class="w-full space-y-2 max-w-[1920px]">
                <div
                    class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] grid-bg">
                    <div class="grid gap-4 mb-4 score-top" style="grid-template-columns: 1fr 12% 1fr">
                        <div class="space-y-4 home-team-top">
                            <ScoreBar :score="live.home_score" :team="live.home_team" :side="'home'" />

                            <FoulsTimeouts :side="'home'" :team="live.home_team" />
                        </div>

                        <div class="grid text-center rounded bg-slate-800/40">
                            <Pretty />

                            <PeriodIndicator :live="live" />
                        </div>

                        <div class="space-y-4 away-team-top">
                            <ScoreBar :score="live.away_score" :team="live.away_team" :side="'away'" />

                            <FoulsTimeouts :side="'away'" :team="live.away_team" />
                        </div>
                    </div>

                    <div class="grid gap-12 mb-4 score-court" style="grid-template-columns: 1fr 8% 1fr">
                        <div class="grid sub-bar-home">
                            <PlayersOnCourt :players="live.home_players_on_court" />
                        </div>

                        <div class="flex justify-center items-center text-sm text-center uppercase">
                            Na terenu
                        </div>

                        <div class="grid sub-bar-away">
                            <PlayersOnCourt :players="live.away_players_on_court" />
                        </div>
                    </div>

                    <div class="grid gap-6 score-controls" style="grid-template-columns: 1fr 25% 1fr">
                        <div class="grid gap-6 home-controls" style="grid-template-columns: 1fr 1fr">
                            <PlayersOnBench :players="live.home_players_on_bench" />

                            <ScoreButtonGroup :team="live.home_team" :players="live.home_players"
                                :playersOnCourt="live.home_players_on_court" :game="game"
                                :opponents="live.away_players_on_court" />
                        </div>

                        <div class="overflow-auto h-full max-h-[50svh]">
                            <Log :log="log" :game="game" :live="live" />
                        </div>

                        <div class="grid gap-6 away-controls" style="grid-template-columns: 1fr 1fr">
                            <ScoreButtonGroup :team="live.away_team" :players="live.away_players"
                                :playersOnCourt="live.away_players_on_court" :game="game"
                                :opponents="live.away_players_on_court" />

                            <PlayersOnBench :players="live.away_players_on_bench" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-span-2">
                <Log :log="log" :game="game" :live="live" />
            </div> -->

        <!-- <div>
            <small>
                <pre>{{ live }}</pre>
            </small>
        </div> -->
    </Layout>
</template>
