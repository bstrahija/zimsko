<script setup>
import { reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import ButtonModalAction from './ButtonModalAction.vue';
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
    opponentPlayers: {
        type: Array,
        required: true,
    },
});

const { game } = toRefs(props);

const data = reactive({
    selectedPlayer: null,
    selectedOtherPlayer: null,
    gameId: null,
});

const save = async function () {
    data.gameId = game.value.id;
    await router.post('/live/' + data.gameId + '/block', data);
    $vfm.hideAll();
};

function canBeSaved() {
    return data.selectedPlayer;
}

function selectPlayer(player) {
    data.selectedPlayer = player;
    data.selectedOtherPlayer = null;
}

function selectBlockedPlayer(player) {
    data.selectedOtherPlayer = player;
}

function isActive(player) {
    return player.id === data.selectedPlayer?.id;
}

function isActiveBlocked(player) {
    return player.id === data.selectedOtherPlayer?.id;
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>BLOKADA</h3>
                        <button @click="close" class="close">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-8 py-6 modal-body">
                        <div class="grid gap-6 grid-cols-[1fr_120px_1fr]">
                            <div class="text-center">
                                <h3 class="mb-3 text-sm text-center uppercase">Blokira</h3>
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                    <PlayerSelectBlock :player="player" :active="isActive(player)" v-for="player in players" :key="'playersc-' + player.id"
                                        @click="selectPlayer(player)" />
                                </div>
                            </div>

                            <div class="mt-8">
                                <button :disabled="!canBeSaved()" :class="{ 'opacity-50': !canBeSaved(), 'pointer-events-none': !canBeSaved() }" @click="save"
                                    class="flex justify-center items-center py-5 space-x-2 w-full text-sm transition-transform duration-300 btn btn-secondary hover:scale-105">
                                    SPREMI
                                </button>
                            </div>

                            <div class="text-center">
                                <h3 class="mb-3 text-sm text-center uppercase">BLOKIRAN</h3>
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                    <PlayerSelectBlock :player="player" :active="isActiveBlocked(player)" v-for="player in opponentPlayers" :key="'playersc-' + player.id"
                                        @click="selectBlockedPlayer(player)" />
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
