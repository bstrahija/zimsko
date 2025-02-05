<script setup>
import { onMounted, reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import PlayerBlock from '../PlayerBlock.vue';
import PlayerSelectBlock from '../PlayerSelectBlock.vue';
import { $vfm } from 'vue-final-modal';

const props = defineProps({
    game: {
        type: Object,
        required: true,
    },
    team: {
        type: Object,
        required: true,
    },
    players: {
        type: Array,
        required: true,
    },
    playersOnBench: {
        type: Array,
        required: true,
    },
    playerIn: {
        type: Object,
        required: false,
    },
    playerOut: {
        type: Object,
        required: false,
    },
});

const { game, players, playerIn, playerOut, playersOnBench } = toRefs(props);

const data = reactive({
    selectedPlayersOut: [],
    selectedPlayersIn: [],
    playerFouledOut: null,
    gameId: null,
});

onMounted(() => {
    // console.log("===");
    // if (playerIn && playerIn.value) data.selectedPlayersIn.push(playerIn.value);
    // if (playerOut && playerOut.value) data.selectedPlayersOut.push(playerOut.value);

    // let playersOnCourt = players.value.filter(player => !props.playersOnBench.some(player2 => player2.id === player.id));

    // console.log('Players on court', playersOnCourt.length);

    // // Check if any player fouled out
    // playersOnCourt.forEach(player => {
    //     if (player.stats.fouls >= 5) {
    //         data.playerFouledOut = player;

    //         console.log('Bench', props.playersOnBench);
    //         console.log('Fouled out', data.playerFouledOut);
    //         console.log('Player', player);
    //         console.log(props.playersOnBench.includes(data.playerFouledOut));




    //         // Always to "Out" list
    //         if (data.playerFouledOut) {
    //             // data.selectedPlayersOut.push(data.playerFouledOut);
    //         }
    //     }
    // });
});

function selectPlayerOut(player) {
    if (data.selectedPlayersOut.includes(player)) {
        data.selectedPlayersOut.splice(data.selectedPlayersOut.indexOf(player), 1);
    } else {
        data.selectedPlayersOut.push(player);
    }
}

function selectPlayerIn(player) {
    if (data.selectedPlayersIn.includes(player)) {
        data.selectedPlayersIn.splice(data.selectedPlayersIn.indexOf(player), 1);
    } else {
        data.selectedPlayersIn.push(player);
    }
}

function isActiveOut(player) {
    return data.selectedPlayersOut.includes(player);
}

function isActiveIn(player) {
    return data.selectedPlayersIn.includes(player);
}

const canBeSaved = function () {
    console.log(data.selectedPlayersOut.length + ' :: ' + data.selectedPlayersIn.length);
    return (data.selectedPlayersOut.length > 0 && data.selectedPlayersIn.length > 0)
        && (data.selectedPlayersOut.length === data.selectedPlayersIn.length);
}

function save() {
    data.gameId = game.value.id;
    data.action = 'substitution';
    router.put('/live/' + data.gameId + '/score', data);

    $vfm.hideAll();
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>IZMJENA</h3>
                        <button @click="close" class="close">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-8 py-6 modal-body">
                        <div class="grid">
                            <div v-if="data.playerFouledOut"
                                class="flex text-xs uppercase justify-center items-center px-2 py-1 mx-auto mb-4 text-red-300 rounded-md border border-red-700 shadow-sm bg-red-900/50 max-w-[800px]">
                                <svg class="mr-2 w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636L5.636 18.364M5.636 5.636l12.728 12.728"></path>
                                </svg>
                                <span>{{ data.playerFouledOut.name }} ima 5 prekršaja.</span>
                            </div>

                            <!-- <p><small>IN: {{ playerIn }}</small></p>
                            <p><small>OUT: {{ playerOut }}</small></p>
                            ---
                            <p><small>IN: {{ data.selectedPlayersIn }}</small></p>
                            <p><small>OUT: {{ data.selectedPlayersOut }}</small></p> -->

                            <div class="grid gap-6 grid-cols-[1fr_120px_1fr]">
                                <div class="text-center">
                                    <h3 class="mb-3 text-sm text-center uppercase">IZLAZE</h3>
                                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                        <PlayerSelectBlock :player="player" :game="game" :active="isActiveOut(player)" v-for="player in players" :key="'playersc-' + player.id"
                                            @click="selectPlayerOut(player)" />
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <button :disabled="!canBeSaved()" :class="{ 'opacity-50': !canBeSaved(), 'pointer-events-none': !canBeSaved() }" @click="save"
                                        class="flex justify-center items-center py-5 space-x-2 w-full text-sm transition-transform duration-300 btn btn-secondary hover:scale-105">
                                        IZMIJENI
                                    </button>
                                </div>

                                <div>
                                    <h3 class="mb-3 text-sm text-center uppercase">ULAZE</h3>
                                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                        <PlayerSelectBlock :player="player" :game="game" :active="isActiveIn(player)" v-for="player in playersOnBench"
                                            :key="'playeras-' + player.id" @click="selectPlayerIn(player)" :class="{ hidden: player.id === data.selectedPlayer?.id }" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </vue-final-modal>
</template>
