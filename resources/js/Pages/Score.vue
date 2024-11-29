<script setup>
// import Layout from './Layout';
import { Head } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import FoulTimeoutIndicator from '../Components/FoulTimeoutIndicator.vue';
import Log from '../Components/Log.vue';
import PlayerBlock from '../Components/PlayerBlock.vue';
import PlayersOnBench from '../Components/PlayersOnBench.vue';
import PlayersOnCourt from '../Components/PlayersOnCourt.vue';
import ScoreButton from '../Components/ScoreButton.vue';
import ScoreButtonGroup from '../Components/ScoreButtonGroup.vue';

defineProps({
    log: Array,
    status: String,
    game: Object,
    game_live: Object,
    home_score: Number,
    away_score: Number,
    home_team: Object,
    away_team: Object,
    home_players: Array,
    away_players: Array,
    home_players_on_court: Array,
    away_players_on_court: Array,
    home_players_on_bench: Array,
    away_players_on_bench: Array,
});
</script>

<template>
    <Layout>
        <Head title="Welcome" />

        <div class="grid grid-cols-12 gap-4 p-4">
            <div class="col-span-10">
                <div class="grid grid-cols-2 gap-5 mb-4 score-bar">
                    <div class="grid grid-cols-12 rounded border border-r border-gray-200 shadow home-team">
                        <div class="flex col-span-3 justify-center items-center border-r"><img :src="home_team.logo" alt="" class="w-20 h-20 rounded-full" /></div>
                        <h3 class="col-span-7 py-10 text-4xl font-bold text-center font-oswald">{{ home_team.title }}</h3>
                        <p class="flex col-span-2 justify-center items-center h-full text-6xl font-bold text-center border-l font-oswald">{{ home_score }}</p>
                        <div class="flex col-span-12 gap-6 border-t">
                            <div class="px-5 py-3 pr-4 text-sm border-r">Prekršaja: 3</div>
                            <div class="px-5 py-3 pr-4 text-sm border-r">Timeout: 2</div>
                        </div>
                        <!-- <ScoreButton>SUB</ScoreButton>
                        <FoulTimeoutIndicator /> -->
                    </div>
                    <div class="grid grid-cols-12 rounded border border-r border-gray-200 shadow away-team">
                        <p class="flex col-span-2 justify-center items-center h-full text-6xl font-bold text-center border-r font-oswald">{{ away_score }}</p>
                        <h3 class="col-span-7 py-10 text-4xl font-bold text-center font-oswald">{{ away_team.title }}</h3>
                        <div class="flex col-span-3 justify-center items-center border-l"><img :src="away_team.logo" alt="" class="w-20 h-20 rounded-full" /></div>
                        <div class="flex col-span-12 gap-6 border-t">
                            <div class="px-5 py-3 pr-4 text-sm border-r">Prekršaja: 4</div>
                            <div class="px-5 py-3 pr-4 text-sm border-r">Timeout: 1</div>
                        </div>
                        <!-- <ScoreButton>SUB</ScoreButton>
                        <FoulTimeoutIndicator /> -->
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5 mb-2 sub-bar">
                    <div class="grid sub-bar-home">
                        <PlayersOnCourt :players="home_players_on_court" />
                    </div>

                    <div class="grid sub-bar-home">
                        <PlayersOnCourt :players="away_players_on_court" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 activity-bar">
                    <div class="grid grid-cols-2 gap-2 activity-bar-home">
                        <PlayersOnBench :players="home_players_on_bench" />

                        <ScoreButtonGroup :team="home_team" :players="home_players" :playersOnCourt="home_players_on_court" :game="game" />
                    </div>

                    <div class="grid grid-cols-2 gap-2 activity-bar-away">
                        <ScoreButtonGroup :team="away_team" :players="away_players" :playersOnCourt="away_players_on_court" :game="game" />

                        <PlayersOnBench :players="away_players_on_bench" />
                    </div>
                </div>
            </div>

            <div class="col-span-2">
                <Log :log="log" />
            </div>
        </div>
    </Layout>
</template>
