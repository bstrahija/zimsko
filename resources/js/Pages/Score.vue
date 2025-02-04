<script setup>
import { inject, onMounted, toRefs } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import LiveScoreApp from '../Components/LiveScoreApp.vue';
import SelectPlayers from '../Components/SelectPlayers.vue';
import SelectStartingPlayers from '../Components/SelectStartingPlayers.vue';

const helpers = inject('helpers');

let props = defineProps({
    game: { type: Object, required: true },
    log: { type: Array, required: true },
});

// let { log, game, gameLive } = toRefs(props);

onMounted(() => {
    const channel = window.Echo.channel(`zimsko-local`)
        .listen('LiveScoreUpdated', (e) => {
            router.visit('/live/' + props.game.id + '/score', {
                only: ['game', 'log'],
                preserveState: true,
                preserveScroll: true,
            });
        });

    helpers.checkPlayersForFouls(props.game);
});

router.on('success', (event) => {
    helpers.checkPlayersForFouls(props.game);
})
</script>

<template>
    <Layout>

        <Head title="Zimsko Live Score" />

        <div class="flex relative justify-center min-h-[98svh]">
            <div class="w-full space-y-2 max-w-[1920px]">
                <LiveScoreApp :game="game" :log="log" />
            </div>
        </div>
    </Layout>
</template>
