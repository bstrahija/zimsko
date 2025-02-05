<script setup>
import { reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
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
});

const save = function () {
    data.action = 'turnover';
    data.gameId = game.value.id;
    router.put('/live/' + data.gameId + '/score', data);

    $vfm.hideAll();
};

function canBeSaved() {
    return data.selectedPlayer;
}

function selectPlayer(player) {
    data.selectedPlayer = player;
}
function isActive(player) {
    return player.id === data.selectedPlayer?.id;
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>IZGUBLJENA LOPTA</h3>
                        <button @click="close" class="close">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-8 py-6 modal-body">
                        <div class="grid gap-6 grid-cols-[1fr_120px]">
                            <div class="text-center">
                                <h3 class="mb-3 text-sm text-center uppercase">IZUBIO LOPTU</h3>
                                <div class="grid grid-cols-2 gap-4 items-start sm:grid-cols-3 lg:grid-cols-4">
                                    <PlayerSelectBlock :player="player" :game="game" :active="isActive(player)" v-for="player in players" :key="'playersc-' + player.id"
                                        @click="selectPlayer(player)" />
                                </div>
                            </div>

                            <div class="mt-8">
                                <button :disabled="!canBeSaved()" :class="{ 'opacity-50': !canBeSaved(), 'pointer-events-none': !canBeSaved() }" @click="save"
                                    class="flex justify-center items-center py-5 space-x-2 w-full text-sm transition-transform duration-300 btn btn-secondary hover:scale-105">
                                    SPREMI
                                </button>
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
