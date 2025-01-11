<script setup>
import { inject, onMounted, reactive, toRefs, watch } from 'vue';
import Layout from './Layout.vue';
import ScoreBar from '../Components/ScoreBar.vue';
import PlayerSelectBlock from '../Components/PlayerSelectBlock.vue';
import PlayerEmptyBlock from '../Components/PlayerEmptyBlock.vue';
import Pretty from '../Components/Pretty.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const helpers = inject('helpers');

let props = defineProps({
    game: Object,
    gameLive: Object,
});

let { game, gameLive } = toRefs(props);

let data = reactive({
    saving: false,
    homePlayers: props.game.home_players,
    awayPlayers: props.game.away_players,
    gameId: props.game.game_id,
});

const addHomePlayer = (player) => {
    if (!data.homePlayers.includes(player)) {
        data.homePlayers.push(player);
    }
}
const addAwayPlayer = (player) => {
    if (!data.awayPlayers.includes(player)) {
        data.awayPlayers.push(player);
    }
}

const removeHomePlayer = (player) => {
    data.homePlayers = data.homePlayers.filter(p => p.id !== player.id);
}

const removeAwayPlayer = (player) => {
    data.awayPlayers = data.awayPlayers.filter(p => p.id !== player.id);
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
        'home_players': data.homePlayers,
        'away_players': data.awayPlayers,
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
                    <h1 class="relative px-3 py-2 -mt-6 -mr-6 mb-4 -ml-6 text-xs text-center uppercase text-white/80 bg-cyan-400/15">
                        <Link href="/live" class="absolute right-3 top-1/2 text-red-500 transition-transform -translate-y-1/2 hover:text-cyan-300 hover:rotate-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        </Link>
                        <Link :href="'/live/' + game.id" class="absolute left-3 top-1/2 text-cyan-400 transition-transform -translate-y-1/2 hover:text-cyan-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:animate-pulse" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        </Link>

                        {{ game.title }}
                    </h1>

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
                                <PlayerSelectBlock v-for="player in data.homePlayers" :key="'home-selected-' + player.id" :player="player" @click="removeHomePlayer(player)" />
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
                                <PlayerSelectBlock v-for="player in data.awayPlayers" :key="'away-selected-' + player.id" :player="player" @click="removeAwayPlayer(player)" />
                            </div>
                        </div>
                    </div>

                    <hr class="mt-12 mb-8 opacity-20">

                    <div class="grid gap-12 mt-8 score-controls" style="grid-template-columns: 1fr 8% 1fr">
                        <div class="space-y-4 home-controls">
                            <h2 class="text-sm text-center text-white uppercase">
                                Dostupni igrači ({{ game.available_home_players.length - helpers.pluck(data.homePlayers, 'id').length }})
                            </h2>
                            <div class="grid grid-cols-4 auto-rows-min gap-2 grid-min-rows players-on-bench starting-players-on-bench">
                                <PlayerSelectBlock v-for="player in game.available_home_players" :key="'home-available-' + player.id" :player="player"
                                    @click="addHomePlayer(player)" :class="{ hidden: helpers.pluck(data.homePlayers, 'id').includes(player.id) }" />
                            </div>
                        </div>

                        <div></div>

                        <div class="space-y-4 away-controls">
                            <h2 class="text-sm text-center text-white uppercase">
                                Dostupni igrači ({{ game.available_away_players.length - helpers.pluck(data.awayPlayers, 'id').length }})
                            </h2>
                            <div class="grid grid-cols-4 auto-rows-min gap-2 grid-min-rows players-on-bench starting-players-on-bench">
                                <PlayerSelectBlock v-for="player in game.available_away_players" :key="'away-available-' + player.id" :player="player"
                                    @click="addAwayPlayer(player)" :class="{ hidden: helpers.pluck(data.awayPlayers, 'id').includes(player.id) }" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
