<script setup>
import { onMounted, toRefs } from 'vue';
import { Head, router } from '@inertiajs/vue3';
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
import LiveScoreApp from '../Components/LiveScoreApp.vue';
import SelectStartingPlayers from '../Components/SelectStartingPlayers.vue';

let props = defineProps({
    log: Array,
    game: Object,
});

let { log, game } = toRefs(props);

onMounted(() => {
    const channel = window.Echo.channel(`live-score`)
        .listen('LiveScoreUpdated', (e) => {
            router.visit('/live/' + game.value.game_id, {
                only: ['game', 'log'],
                preserveState: true,
                preserveScroll: true,
            });
        });
});
</script>

<template>
    <Layout>

        <Head title="Zimsko Live Score" />

        <div class="flex relative justify-center min-h-[98svh]">
            <div class="w-full space-y-2 max-w-[1920px]">
                <SelectStartingPlayers :game="game"
                    v-if="!game.home_starting_players || !game.away_starting_players || game.home_starting_players.length < 5 || game.away_starting_players.length < 5" />

                <LiveScoreApp v-else :game="game" :log="log" />
            </div>
        </div>
    </Layout>
</template>
