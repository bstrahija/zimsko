<script setup>
import { inject, onMounted, toRefs } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import LiveScoreApp from '../Components/LiveScoreApp.vue';
import SelectPlayers from '../Components/SelectPlayers.vue';
import SelectStartingPlayers from '../Components/SelectStartingPlayers.vue';

const helpers = inject('helpers');

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

    helpers.checkPlayersForFouls(game.value);
});

router.on('success', (event) => {
    helpers.checkPlayersForFouls(game.value);
})
</script>

<template>
    <Layout>

        <Head title="Zimsko Live Score" />

        <div class="flex relative justify-center min-h-[98svh]">
            <div class="w-full space-y-2 max-w-[1920px]">
                <SelectPlayers :game="game" v-if="!game.home_players || !game.away_players || game.home_players.length < 5 || game.away_players.length < 5" />

                <SelectStartingPlayers :game="game"
                    v-if="!game.home_starting_players || !game.away_starting_players || game.home_starting_players.length < 5 || game.away_starting_players.length < 5" />

                <LiveScoreApp v-else :game="game" :log="log" />
            </div>
        </div>
    </Layout>
</template>
