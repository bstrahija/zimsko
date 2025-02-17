<script setup>
import { inject, onMounted, reactive, toRefs, watch } from 'vue';
import Layout from './Layout.vue';
import ScoreBar from '../Components/ScoreBar.vue';
import PlayerSelectBlock from '../Components/PlayerSelectBlock.vue';
import PlayerEmptyBlock from '../Components/PlayerEmptyBlock.vue';
import Pretty from '../Components/Pretty.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import LiveTopBar from '../Components/LiveTopBar.vue';
import PlayerNumbersModal from '../Components/Modals/PlayerNumbersModal.vue';
import { $vfm } from 'vue-final-modal';

const helpers = inject('helpers');

let props = defineProps({
    game: Object,
});

let { game } = toRefs(props);

let data = reactive({
    saving: false,
    homePlayers: props.game.home_players,
    awayPlayers: props.game.away_players,
    gameId: props.game.id,
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
    router.visit('/live/' + props.game.id + '/edit');
}

function canBeSaved() {
    if (data.homePlayers.length < 5 || data.awayPlayers.length < 5) {
        return false
    }

    return true
}

function editNumbers() {
    $vfm.show({ component: PlayerNumbersModal, bind: { game: props.game } });
}

const save = async function () {
    data.saving = true
    await router.put('/live/' + props.game.id + '/players', {
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

            <div class="w-full space-y-2 max-w-[1920px] transition-all" :class="{ 'opacity-90': data.saving }">
                <div class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] h-full grid-bg">
                    <!-- <p><small>
                            <pre>{{ data.homePlayers }}</pre>
                        </small></p> -->
                    <LiveTopBar :title="game.title" :backUrl="'/live/' + game.id" :game="game" />

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

                    <div class="grid gap-4 score-controls grid-cols-[1fr_100px_1fr] md:grid-cols-[1fr_160px_1fr]">
                        <div class="home-controls">
                            <div class="grid grid-cols-4 auto-rows-min gap-2 xl:grid-cols-5 grid-min-rows players-on-bench starting-players-on-bench">
                                <PlayerSelectBlock v-for="player in data.homePlayers" :key="'home-selected-' + player.id" :player="player" :game="game"
                                    @click="removeHomePlayer(player)" />
                            </div>
                        </div>

                        <div class="space-y-4">
                            <button class="w-full btn btn-secondary" @click="save" :class="{ 'opacity-50': !canBeSaved(), 'pointer-events-none': !canBeSaved() }"
                                :disabled="!canBeSaved()">
                                DALJE NA PETORKE
                            </button>

                            <button class="block w-full btn btn-primary" @click="editNumbers">
                                BROJEVI
                            </button>

                            <button class="block w-full btn btn-error" @click="backToDetails">
                                NATRAG
                            </button>
                        </div>

                        <div class="away-controls">
                            <div class="grid grid-cols-4 auto-rows-min gap-2 xl:grid-cols-5 grid-min-rows players-on-bench starting-players-on-bench">
                                <PlayerSelectBlock v-for="player in data.awayPlayers" :key="'away-selected-' + player.id" :player="player" :game="game"
                                    @click="removeAwayPlayer(player)" />
                            </div>
                        </div>
                    </div>

                    <hr class="mt-12 mb-8 opacity-20">

                    <div class="grid gap-4 mt-8 score-controls grid-cols-[1fr_100px_1fr] md:grid-cols-[1fr_160px_1fr]">
                        <div class="space-y-4 home-controls">
                            <h2 class="text-sm text-center text-white uppercase">
                                Dostupni igrači ({{ game.available_home_players.length - helpers.pluck(data.homePlayers, 'id').length }})
                            </h2>
                            <div class="grid grid-cols-4 auto-rows-min gap-2 xl:grid-cols-5 lg:grid-cols-5 grid-min-rows players-on-bench starting-players-on-bench">
                                <PlayerSelectBlock v-for="player in game.available_home_players" :key="'home-available-' + player.id" :player="player" :game="game"
                                    @click="addHomePlayer(player)" :class="{ hidden: helpers.pluck(data.homePlayers, 'id').includes(player.id) }" />
                            </div>
                        </div>

                        <div></div>

                        <div class="space-y-4 away-controls">
                            <h2 class="text-sm text-center text-white uppercase">
                                Dostupni igrači ({{ game.available_away_players.length - helpers.pluck(data.awayPlayers, 'id').length }})
                            </h2>
                            <div class="grid grid-cols-4 auto-rows-min gap-2 xl:grid-cols-5 grid-min-rows players-on-bench starting-players-on-bench">
                                <PlayerSelectBlock v-for="player in game.available_away_players" :key="'away-available-' + player.id" :player="player" :game="game"
                                    @click="addAwayPlayer(player)" :class="{ hidden: helpers.pluck(data.awayPlayers, 'id').includes(player.id) }" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
