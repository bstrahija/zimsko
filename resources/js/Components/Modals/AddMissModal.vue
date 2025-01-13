<script setup>
import { reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import ButtonModalAction from './ButtonModalAction.vue';
import ButtonModalPlayer from './ButtonModalPlayer.vue';
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
    score: 2,
    gameId: null,
});

const save = async function () {
    data.gameId = game.value.game_id;
    await router.post('/live/' + data.gameId + '/miss', data);

    $vfm.hideAll();
};

function canBeSaved() {
    return data.selectedPlayer && data.score;
}

function selectPlayer(player) {
    data.selectedPlayer = player;
}
function isActive(player) {
    return player.id === data.selectedPlayer?.id;
}

function setScore(score) {
    data.score = score;
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="mb-3 text-2xl font-bold text-center">Odaberi igrača (promašaj)</h3>
                        <button @click="close" class="absolute top-4 right-4 text-2xl">X</button>
                    </div>

                    <div class="px-8 modal-body">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="grid grid-cols-3 gap-4">
                                <PlayerSelectBlock :player="player" v-for="player in players" @click="selectPlayer(player)" :active="isActive(player)" />
                            </div>

                            <div class="mb-6 space-y-6 text-center gt-8">
                                <ButtonModalAction :active="data.score === 2" @click="setScore(2)">2 Poena</ButtonModalAction>
                                <ButtonModalAction :active="data.score === 3" @click="setScore(3)">3 Poena</ButtonModalAction>
                                <ButtonModalAction :active="data.score === 1" @click="setScore(1)">Slobodno Bacanje</ButtonModalAction>
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
