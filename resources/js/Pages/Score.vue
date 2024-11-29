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

        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-10">
                <div class="grid grid-cols-3 score-bar">
                    <div class="home-team">
                        <div><img :src="home_team.logo" alt="" /></div>
                        <h3>{{ home_team.title }}</h3>
                        <p>{{ home_score }}</p>
                        <ScoreButton>SUB</ScoreButton>
                        <FoulTimeoutIndicator />
                    </div>
                    <div class="game-time">
                        <p>7:32</p>
                        <a href="#">Pauza</a>
                    </div>
                    <div class="away-team">
                        <p>{{ away_score }}</p>
                        <h3>{{ away_team.title }}</h3>
                        <div><img :src="away_team.logo" alt="" /></div>
                        <ScoreButton>SUB</ScoreButton>
                        <FoulTimeoutIndicator />
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
