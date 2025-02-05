<script setup>
import { onMounted, reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import ButtonModalAction from './ButtonModalAction.vue';
import PlayerBlock from '../PlayerBlock.vue';
import PlayerSelectBlock from '../PlayerSelectBlock.vue';
import { $vfm } from 'vue-final-modal';

const props = defineProps({
    team: {
        type: Object,
        required: true,
    },
    players: {
        type: Array,
        required: true,
    },
    opponentPlayers: {
        type: Array,
        required: true,
    },
    game: {
        type: Object,
        required: true,
    },
    type: {
        type: String,
        required: false,
    },
});

const { game, type } = toRefs(props);

const data = reactive({
    selectedPlayer: null,
    selectedOtherPlayer: null,
    teamId: props.team.id,
    type: 'pf',
});

onMounted(() => {
    if (type.value) {
        data.type = type.value;
    }
})

const save = function () {
    data.action = 'foul';
    data.gameId = game.value.id;
    router.put('/live/' + data.gameId + '/score', data);

    $vfm.hideAll();
};

function canBeSaved() {
    if (data.type === 'tf') {
        return true;
    }

    return data.selectedPlayer && data.type;
}

function selectPlayer(player) {
    data.selectedPlayer = player;
}

function selectFouledPlayer(player) {
    data.selectedOtherPlayer = player;
}

function isActive(player) {
    return player.id === data.selectedPlayer?.id;
}

function isActiveFouled(player) {
    return player.id === data.selectedOtherPlayer?.id;
}

function setType(type) {
    data.type = type;
    if (type === 'tf') data.selectedOtherPlayer = null;
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>PREKRŠAJ</h3>
                        <button @click="close" class="close">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-8 py-6 modal-body">
                        <div class="grid gap-6 grid-cols-[1fr_100px_1fr]" :class="{ 'grid-cols-[1fr_120px]': data.type === 'tf' }">
                            <div class="text-center">
                                <h3 class="mb-3 text-sm text-center uppercase">PREKRŠAJ OD</h3>
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                    <PlayerSelectBlock :player="player" :game="game" :active="isActive(player)" v-for="player in players" :key="'playersc-' + player.id"
                                        @click="selectPlayer(player)" />
                                </div>
                            </div>

                            <div class="mb-6 space-y-3 text-center">
                                <h3 class="text-sm text-center uppercase">TIP</h3>
                                <ButtonModalAction :active="data.type === 'pf'" @click="setType('pf')">Osobna</ButtonModalAction>
                                <ButtonModalAction :active="data.type === 'tf'" @click="setType('tf')">Tehnička</ButtonModalAction>
                                <ButtonModalAction :active="data.type === 'ff'" @click="setType('ff')">Nesportska</ButtonModalAction>
                                <hr class="opacity-20">
                                <button :disabled="!canBeSaved()" :class="{ 'opacity-50': !canBeSaved(), 'pointer-events-none': !canBeSaved() }" @click="save"
                                    class="flex justify-center items-center py-5 space-x-2 w-full text-sm transition-transform duration-300 btn btn-secondary hover:scale-105">
                                    <span>Spremi</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <div v-if="data.type !== 'tf'">
                                <h3 class="mb-3 text-sm text-center uppercase">Prekršaj na</h3>
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                    <PlayerSelectBlock :player="player" :game="game" :active="isActiveFouled(player)" v-for="player in opponentPlayers"
                                        :key="'playeras-' + player.id" @click="selectFouledPlayer(player)" :class="{ hidden: player.id === data.selectedPlayer?.id }" />
                                </div>
                            </div>
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
