<script setup>
import { inject, onMounted, reactive, toRefs, watch } from 'vue';
import Layout from './Layout.vue';
import ScoreBar from '../Components/ScoreBar.vue';
import PlayerSelectBlock from '../Components/PlayerSelectBlock.vue';
import PlayerEmptyBlock from '../Components/PlayerEmptyBlock.vue';
import Pretty from '../Components/Pretty.vue';
import { Head, router } from '@inertiajs/vue3';

const helpers = inject('helpers');

let props = defineProps({
    game: Object,
    gameLive: Object,
});

let { game, gameLive } = toRefs(props);

let data = reactive({
    saving: false,
    gameId: game.value.game_id,
});

const addHomePlayer = (player) => {
    if (!props.game.home_players.includes(player)) {
        props.game.home_players.push(player);
    }
}
const addAwayPlayer = (player) => {
    if (!props.game.away_players.includes(player)) {
        props.game.away_players.push(player);
    }
}

const removeHomePlayer = (player) => {
    game.value.home_players = game.value.home_players.filter(p => p.id !== player.id);
}

const removeAwayPlayer = (player) => {
    game.value.away_players = game.value.away_players.filter(p => p.id !== player.id);
}

function backToDetails() {
    router.visit('/live/' + props.game.id + '');
}

function canBeSaved() {
    if (props.game.home_players.length < 5 || props.game.away_players.length < 5) {
        return false
    }

    return true
}

const save = async function () {
    data.saving = true
    await router.post('/live/' + props.game.id + '/players', {
        'home_players': props.game.home_players,
        'away_players': props.game.away_players,
    });
    data.saving = false
};
</script>

<template>
    <Layout>

        <Head title="Zimsko Live Score | Igrači" />

        <div class="flex relative justify-center min-h-[98svh]">
            <div class="w-full space-y-2 max-w-[1920px]">
                <div class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] h-full grid-bg">
                    <h1 class="px-3 py-2 -mt-6 -mr-6 mb-4 -ml-6 text-xs text-center uppercase text-white/80 bg-cyan-400/15">{{ game.title }}</h1>

                    <div class="grid gap-4 mb-4 score-top" style="grid-template-columns: 1fr 160px 1fr">
                        <div class="space-y-4 home-team-top">
                            <ScoreBar :score="0" :team="game.home_team" :side="'home'" />
                        </div>

                        <div class="grid text-center rounded bg-slate-800/40">
                            <Pretty />
                        </div>

                        <div class="space-y-4 away-team-top">
                            <ScoreBar :score="0" :team="game.away_team" :side="'away'" />
                        </div>
                    </div>

                    <div class="grid gap-12 score-controls" style="grid-template-columns: 1fr 8% 1fr">
                        <div class="home-controls">
                            <div class="grid grid-cols-4 auto-rows-min gap-2 grid-min-rows players-on-bench starting-players-on-bench">
                                <PlayerSelectBlock v-for="player in game.home_players" :key="'home-selected-' + player.id" :player="player" @click="removeHomePlayer(player)" />
                            </div>
                        </div>

                        <div class="space-y-4">
                            <button class="w-full btn btn-secondary" @click="save" :class="{ 'opacity-50': !canBeSaved(), 'pointer-events-none': !canBeSaved() }"
                                :disabled="!canBeSaved()">
                                DALJE NA PETORKE
                            </button>

                            <button class="block w-full btn btn-error" @click="backToDetails">
                                NATRAG
                            </button>
                        </div>

                        <div class="away-controls">
                            <div class="grid grid-cols-4 auto-rows-min gap-2 grid-min-rows players-on-bench starting-players-on-bench">
                                <PlayerSelectBlock v-for="player in game.away_players" :key="'away-selected-' + player.id" :player="player" @click="removeAwayPlayer(player)" />
                            </div>
                        </div>
                    </div>

                    <hr class="mt-12 mb-8 opacity-20">

                    <div class="grid gap-12 mt-8 score-controls" style="grid-template-columns: 1fr 8% 1fr">
                        <div class="space-y-4 home-controls">
                            <h2 class="text-sm text-center text-white uppercase">
                                Dostupni igrači ({{ game.available_home_players.length - helpers.pluck(game.home_players, 'id').length }})
                            </h2>
                            <div class="grid grid-cols-4 auto-rows-min gap-2 grid-min-rows players-on-bench starting-players-on-bench">
                                <PlayerSelectBlock v-for="player in game.available_home_players" :key="'home-available-' + player.id" :player="player"
                                    @click="addHomePlayer(player)" :class="{ hidden: helpers.pluck(game.home_players, 'id').includes(player.id) }" />
                            </div>
                        </div>

                        <div></div>

                        <div class="space-y-4 away-controls">
                            <h2 class="text-sm text-center text-white uppercase">
                                Dostupni igrači ({{ game.available_away_players.length - helpers.pluck(game.away_players, 'id').length }})
                            </h2>
                            <div class="grid grid-cols-4 auto-rows-min gap-2 grid-min-rows players-on-bench starting-players-on-bench">
                                <PlayerSelectBlock v-for="player in game.available_away_players" :key="'away-available-' + player.id" :player="player"
                                    @click="addAwayPlayer(player)" :class="{ hidden: helpers.pluck(game.away_players, 'id').includes(player.id) }" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
