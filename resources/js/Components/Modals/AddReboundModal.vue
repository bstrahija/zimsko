<script setup>
import { reactive, ref, toRefs } from 'vue';
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
    game: {
        type: Object,
        required: true,
    },
});

const { game } = toRefs(props);

const data = reactive({
    selectedPlayer: null,
    gameId: null,
    type: 'def',
});

const save = function () {
    data.action = 'rebound';
    data.gameId = game.value.id;
    router.put('/live/' + data.gameId + '/score', data);

    $vfm.hideAll();
};

function canBeSaved() {
    return data.selectedPlayer && data.type;
}

function selectPlayer(player) {
    data.selectedPlayer = player;
}
function isActive(player) {
    return player.id === data.selectedPlayer?.id;
}

function setType(type) {
    data.type = type;
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Skok</h3>
                        <button @click="close" class="close">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-8 py-6 modal-body">
                        <div class="grid gap-6 items-start grid-cols-[1fr_140px]">
                            <div class="space-y-3">
                                <h3 class="text-sm text-center uppercase">PROMAŠUJE</h3>
                                <div class="grid grid-cols-2 gap-4 items-start sm:grid-cols-3 lg:grid-cols-4">
                                    <PlayerSelectBlock :player="player" :game="game" v-for="player in players" @click="selectPlayer(player)" :active="isActive(player)" />
                                </div>
                            </div>

                            <div class="space-y-3 text-center">
                                <h3 class="text-sm text-center uppercase">SKOK</h3>
                                <ButtonModalAction :active="data.type === 'def'" @click="setType('def')">Defenzivni</ButtonModalAction>
                                <ButtonModalAction :active="data.type === 'off'" @click="setType('off')">Ofenzivni</ButtonModalAction>

                                <div class="w-full">
                                    <hr class="mb-6 opacity-20">

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
