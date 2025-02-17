<script setup>
import { inject, onMounted, reactive, toRefs, watch } from 'vue';
import Layout from './Layout.vue';
import ScoreBar from '../Components/ScoreBar.vue';
import PlayerSelectBlock from '../Components/PlayerSelectBlock.vue';
import PlayerEmptyBlock from '../Components/PlayerEmptyBlock.vue';
import Pretty from '../Components/Pretty.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import LiveTopBar from '../Components/LiveTopBar.vue';

const helpers = inject('helpers');

let props = defineProps({
    game: Object,
});

let { game } = toRefs(props);

let data = reactive({
    saving: false,
    gameId: game.value.id,
    homeStartingPlayers: props.game.home_starting_players,
    awayStartingPlayers: props.game.away_starting_players,
});

function missingHomePlayerNumber() {
    return 5 - data.homeStartingPlayers.length;
}

function missingAwayPlayerNumber() {
    return 5 - data.awayStartingPlayers.length;
}

const addHomePlayer = (player) => {
    if (!data.homeStartingPlayers.includes(player) && data.homeStartingPlayers.length < 5) {
        data.homeStartingPlayers.push(player);
    }
}
const addAwayPlayer = (player) => {
    if (!data.awayStartingPlayers.includes(player) && data.awayStartingPlayers.length < 5) {
        data.awayStartingPlayers.push(player);
    }
}

const removeHomePlayer = (player) => {
    data.homeStartingPlayers = data.homeStartingPlayers.filter(p => p.id !== player.id);
}

const removeAwayPlayer = (player) => {
    data.awayStartingPlayers = data.awayStartingPlayers.filter(p => p.id !== player.id);
}

function backToPlayers() {
    router.visit('/live/' + props.game.id + '/players');
}

function canBeSaved() {
    if (data.homeStartingPlayers.length < 5 || data.awayStartingPlayers.length < 5) {
        return false
    }

    return true
}

const save = async function () {
    data.saving = true
    let players = {
        home_starting_players: data.homeStartingPlayers.map(player => player.id),
        away_starting_players: data.awayStartingPlayers.map(player => player.id),
    };
    // console.log(players);
    await router.put('/live/' + props.game.id + '/starting-players', players);
    data.saving = false
};

const startGame = async function () {
    // if (confirm('Da li ste sigurni da zelite zapoceti utakmicu?')) {
    data.saving = true
    let players = {
        home_starting_players: data.homeStartingPlayers.map(player => player.id),
        away_starting_players: data.awayStartingPlayers.map(player => player.id),
    };
    // console.log(players);
    await router.put('/live/' + props.game.id + '/starting-players?start=1', players);
    data.saving = false
    // }
};
</script>

<template>
    <Layout>

        <Head title="Zimsko Live Score | Igrači" />

        <div class="flex relative justify-center min-h-[98svh]">
            <div class="w-full space-y-2 max-w-[1920px]">
                <div class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] h-full grid-bg">
                    <LiveTopBar :title="game.title" :backUrl="'/live/' + game.id + '/players'" :game="game" />

                    <div class="grid gap-4 mb-4 score-top grid-cols-[1fr_100px_1fr] md:grid-cols-[1fr_160px_1fr]">
                        <div class="space-y-4 home-team-top">
                            <ScoreBar :score="game.home_score" :team="game.home_team" :side="'home'" />
                        </div>

                        <div class="grid text-center rounded bg-slate-800/40">
                            <Pretty />
                        </div>

                        <div class="space-y-4 away-team-top">
                            <ScoreBar :score="game.away_score" :team="game.away_team" :side="'away'" />
                        </div>
                    </div>

                    <div class="grid gap-4 mb-4 score-court grid-cols-[1fr_100px_1fr] md:grid-cols-[1fr_160px_1fr]">
                        <div class="sub-bar-home">
                            <div class="grid grid-cols-5 gap-2 h-auto min-h-0 text-3xl font-bold text-white players-on-court">
                                <PlayerSelectBlock v-for="player in data.homeStartingPlayers" :key="player.id" :player="player" :game="game" @click="removeHomePlayer(player)" />

                                <PlayerEmptyBlock v-for="player in missingHomePlayerNumber()" class="opacity-30 pointer-events-none" />
                            </div>

                            <hr class="my-8 opacity-20">

                            <div class="space-y-4 home-controls">
                                <h2 class="text-sm text-center text-white uppercase">Odaberi početnu petorku</h2>
                                <div class="grid grid-cols-5 auto-rows-min gap-2 grid-min-rows players-on-bench starting-players-on-bench">
                                    <PlayerSelectBlock v-for="player in game.home_players" :key="player.id" :player="player" :game="game" @click="addHomePlayer(player)"
                                        :class="{ hidden: helpers.pluck(data.homeStartingPlayers, 'id').includes(player.id) }" />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 text-sm text-center uppercase">
                            <button class="w-full btn btn-secondary" @click="startGame" v-if="game.status !== 'started' && game.status !== 'ended'"
                                :class="{ 'opacity-50': !canBeSaved(), 'pointer-events-none': !canBeSaved() }" :disabled="!canBeSaved()">
                                DALJE NA LIVE SCORE
                            </button>

                            <button class="w-full btn btn-primary" @click="save" :class="{ 'opacity-50': !canBeSaved(), 'pointer-events-none': !canBeSaved() }"
                                :disabled="!canBeSaved()">
                                SPREMI
                            </button>

                            <button class="block w-full btn btn-error" @click="backToPlayers">
                                NATRAG
                            </button>
                        </div>

                        <div class="sub-bar-away">
                            <div class="grid grid-cols-5 gap-2 h-auto min-h-0 text-3xl font-bold text-white players-on-court">
                                <PlayerSelectBlock v-for="player in data.awayStartingPlayers" :key="player.id" :player="player" :game="game" @click="removeAwayPlayer(player)" />

                                <PlayerEmptyBlock v-for="player in missingAwayPlayerNumber()" class="opacity-30 pointer-events-none" />
                            </div>

                            <hr class="my-8 opacity-20">

                            <div class="space-y-4 away-controls">
                                <h2 class="text-sm text-center text-white uppercase">Odaberi početnu petorku</h2>
                                <div class="grid grid-cols-5 auto-rows-min gap-2 grid-min-rows players-on-bench starting-players-on-bench">
                                    <PlayerSelectBlock v-for="player in game.away_players" :key="player.id" :player="player" :game="game" @click="addAwayPlayer(player)"
                                        :class="{ hidden: helpers.pluck(data.awayStartingPlayers, 'id').includes(player.id) }" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
