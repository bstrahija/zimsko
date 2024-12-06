<script setup>
import { reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import PlayerBlock from '../PlayerBlock.vue';
import { $vfm } from 'vue-final-modal';

const props = defineProps({
    team: {
        type: Object,
        required: true,
    },
    playersOnCourt: {
        type: Array,
        required: true,
    },
    opponents: {
        type: Array,
        required: true,
    },
    game: {
        type: Object,
        required: true,
    },
});

const { game } = toRefs(props);

const data = reactive({
    selectedPlayer: null,
    selectedFouledPlayer: null,
    type: 'pf',
});

const save = async function () {
    data.gameId = game.value.id;

    let test = await router.post('/live/' + data.gameId + '/foul', data);

    console.log('RES: ', test);

    $vfm.hideAll();
};

function canBeSaved() {
    return data.selectedPlayer && data.type;
}

function selectPlayer(player) {
    data.selectedPlayer = player;
}

function selectFouledPlayer(player) {
    data.selectedFouledPlayer = player;
}

function isActive(player) {
    return player.id === data.selectedPlayer?.id;
}

function isActiveFouled(player) {
    return player.id === data.selectedFouledPlayer?.id;
}

function isActiveAssist(player) {
    return player.id === data.selectedAssistPlayer?.id;
}

function setType(type) {
    data.type = type;
}

function isFouledAssist(player) {
    return player.id === data.selectedAssistPlayer?.id;
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="mb-3 text-2xl font-bold text-center">Odaberi igrača (prekršaj)</h3>
                        <button @click="close" class="absolute top-4 right-4 text-2xl">X</button>
                    </div>

                    <div class="modal-body">
                        <div class="grid">
                            <div class="text-center">
                                <button @click="selectPlayer(player)" v-for="player in playersOnCourt" :key="player.id" :class="{ 'bg-emerald-600': isActive(player), 'bg-slate-500': !isActive(player) }" class="px-4 py-2 m-1 text-white rounded-md shadow-md transition-colors duration-200 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
                                    <p class="text-2xl font-bold">{{ player.number }}</p>
                                    {{ player.name }}
                                </button>
                            </div>

                            <div class="grid grid-cols-3 text-center max-w-[360px] mt-4 mb-6 mx-auto">
                                <button @click="setType('pf')" :class="{ 'opacity-50': data.type !== 'pf' }" class="overflow-hidden px-4 py-2 m-1 text-white bg-blue-500 rounded-md shadow-md transition-colors duration-200 aspect-square hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">Osobna</button>
                                <button @click="setType('tf')" :class="{ 'opacity-50': data.type !== 'tf' }" class="overflow-hidden px-4 py-2 m-1 text-white bg-blue-500 rounded-md shadow-md transition-colors duration-200 aspect-square hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">Tehnička</button>
                                <button @click="setType('ff')" :class="{ 'opacity-50': data.type !== 'ff' }" class="overflow-hidden px-4 py-2 m-1 text-white bg-blue-500 rounded-md shadow-md transition-colors duration-200 aspect-square hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">Nesportska</button>
                            </div>
                        </div>

                        <div v-if="data.selectedPlayer && data.type !== 'tf' && opponents" class="mt-8">
                            <h3 class="mb-3 text-2xl font-bold text-center">Na</h3>

                            <div class="grid mb-12">
                                <div class="text-center">
                                    <button v-for="player in opponents">
                                        <p>
                                            <small>
                                                <pre>{{ player }}</pre>
                                            </small>
                                        </p>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center p-6">
                            <button :disabled="!canBeSaved()" :class="{ 'opacity-50': !canBeSaved(), 'pointer-events-none': !canBeSaved() }" @click="save" class="btn btn-primary">Spremi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </vue-final-modal>
</template>

<style scoped>
.modal-backdrop {
    opacity: 0.9;
}
</style>
