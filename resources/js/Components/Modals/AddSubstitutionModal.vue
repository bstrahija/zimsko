<script setup>
import { onMounted, reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import PlayerBlock from '../PlayerBlock.vue';
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

const { game, playerIn, playerOut } = toRefs(props);

const data = reactive({
    selectedPlayersOut: [],
    selectedPlayersIn: [],
    gameId: null,
});

onMounted(() => {
    console.log("===");
    if (playerIn && playerIn.value) data.selectedPlayersIn.push(playerIn.value);
    if (playerOut && playerOut.value) data.selectedPlayersOut.push(playerOut.value);
    //  console.log("IN: ", );
    // if (playerIn && playerIn.value) console.log("IN: ", playerIn.id.value);
    // if (playerOut && playerIn.value) console.log("OUT: ", playerOut.id.value);
    // if (playerOut) data.selectedPlayersOut.push(playerOut.value);
    // if (playerIn) data.selectedPlayersIn.push(playerIn.value);
    // console.log(data.selectedPlayersOut);
    // console.log(data.selectedPlayersIn);
    console.log("===");
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

function canBeSaved() {
    console.log(data.selectedPlayersIn.length);
    console.log(data.selectedPlayersOut.length);

    return (data.selectedPlayersOut.length > 0 && data.selectedPlayersIn.length > 0)
        && (data.selectedPlayersOut.length === data.selectedPlayersIn.length);
}

async function save() {
    data.gameId = game.value.game_id;
    await router.post('/live/' + data.gameId + '/substitution', data);

    $vfm.hideAll();
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="mb-3 text-2xl font-bold text-center">Odaberi igrače (izlaze)</h3>
                        <button @click="close" class="absolute top-4 right-4 text-2xl">X</button>
                    </div>

                    <div class="modal-body">
                        <div class="grid">
                            <!-- <p><small>IN: {{ playerIn }}</small></p>
                            <p><small>OUT: {{ playerOut }}</small></p>
                            ---
                            <p><small>IN: {{ data.selectedPlayersIn }}</small></p>
                            <p><small>OUT: {{ data.selectedPlayersOut }}</small></p> -->

                            <div class="text-center">
                                <button @click="selectPlayerOut(player)" v-for="player in players" :key="player.id"
                                    :class="{ 'bg-emerald-600': isActiveOut(player), 'bg-slate-500': !isActiveOut(player) }"
                                    class="px-4 py-2 m-1 text-white rounded-md shadow-md transition-colors duration-200 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
                                    <p class="text-2xl font-bold">{{ player.number }}</p>
                                    {{ player.name }}
                                </button>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="mb-3 text-2xl font-bold text-center">Ulaze</h3>

                            <div class="grid mb-12">
                                <div class="text-center">
                                    <button @click="selectPlayerIn(player)" v-for="player in playersOnBench"
                                        :key="player.id"
                                        :class="{ 'bg-emerald-600': isActiveIn(player), 'bg-slate-500': !isActiveIn(player) }"
                                        class="px-4 py-2 m-1 text-white rounded-md shadow-md transition-colors duration-200 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
                                        <p class="text-2xl font-bold">{{ player.number }}</p>
                                        {{ player.name }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center p-6">
                            <button :disabled="!canBeSaved()"
                                :class="{ 'opacity-50': !canBeSaved(), 'pointer-events-none': !canBeSaved() }"
                                @click="save" class="btn btn-primary">Spremi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </vue-final-modal>
</template>
