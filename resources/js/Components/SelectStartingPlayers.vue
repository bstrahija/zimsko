<script setup>
import { defineProps, reactive, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import ScoreBar from './ScoreBar.vue';
import PlayerEmptyBlock from './PlayerEmptyBlock.vue';
import PlayerSelectBlock from './PlayerSelectBlock.vue';
import Pretty from './Pretty.vue';

const props = defineProps({
    game: Object,
});

const { game } = toRefs(props);

let data = reactive({
    gameId: game.value.game_id,
    homeStartingPlayers: [],
    awayStartingPlayers: [],
});

const missingHomePlayerNumber = () => {
    return 5 - data.homeStartingPlayers.length;
}

const missingAwayPlayerNumber = () => {
    return 5 - data.awayStartingPlayers.length;
}

const removeHomePlayer = (player) => {
    data.homeStartingPlayers = data.homeStartingPlayers.filter(p => p.id !== player.id);
}

const removeAwayPlayer = (player) => {
    data.awayStartingPlayers = data.awayStartingPlayers.filter(p => p.id !== player.id);
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

const canBeSaved = () => {
    return data.homeStartingPlayers.length === 5 && data.awayStartingPlayers.length === 5;
}

const startGame = async () => {
    if (canBeSaved()) {
        if (confirm('Da li ste sigurni da zelite zapoceti utakmicu?')) {
            await router.post('/live/' + data.gameId + '/start-game', data);
        }
    }
}
</script>

<template>
    <div class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] h-full grid-bg">
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

        <div class="grid gap-12 mb-4 score-court" style="grid-template-columns: 1fr 8% 1fr">
            <div class="grid sub-bar-home">
                <div class="grid grid-cols-5 gap-2 text-3xl font-bold text-white players-on-court min-h-20">
                    <PlayerSelectBlock v-for="player in data.homeStartingPlayers" :key="player.id" :player="player" @click="removeHomePlayer(player)" />

                    <PlayerEmptyBlock v-for="player in missingHomePlayerNumber()" class="opacity-50" />
                </div>
            </div>

            <div class="grid justify-center items-center text-sm text-center uppercase">
                <p class="text-sm text-white">ODABERITE POČETNE PETORKE</p>
                <button class="btn btn-secondary" @click="startGame" v-if="game.status !== 'started' && game.status !== 'ended'"
                    :class="{ 'opacity-50': !canBeSaved(), 'pointer-events-none': !canBeSaved() }" :disabled="!canBeSaved()">
                    Započni utakmicu
                </button>
            </div>

            <div class="grid sub-bar-away">
                <div class="grid grid-cols-5 gap-2 text-3xl font-bold text-white players-on-court min-h-20">
                    <PlayerSelectBlock v-for="player in data.awayStartingPlayers" :key="player.id" :player="player" @click="removeAwayPlayer(player)" />

                    <PlayerEmptyBlock v-for="player in missingAwayPlayerNumber()" class="opacity-50" />
                </div>
            </div>
        </div>

        <div class="grid gap-12 mt-8 score-controls" style="grid-template-columns: 1fr 8% 1fr">
            <div class="grid gap-4 home-controls">
                <div class="grid grid-cols-4 auto-rows-min gap-2 grid-min-rows players-on-bench starting-players-on-bench">
                    <PlayerSelectBlock v-for="player in game.home_players" :key="player.id" :player="player" @click="addHomePlayer(player)"
                        :class="{ hidden: data.homeStartingPlayers.includes(player) }" />
                </div>
            </div>

            <div></div>

            <div class="grid gap-4 away-controls">
                <div class="grid grid-cols-4 auto-rows-min gap-2 grid-min-rows players-on-bench starting-players-on-bench">
                    <PlayerSelectBlock v-for="player in game.away_players" :key="player.id" :player="player" @click="addAwayPlayer(player)"
                        :class="{ hidden: data.awayStartingPlayers.includes(player) }" />
                </div>
            </div>
        </div>
    </div>
</template>
