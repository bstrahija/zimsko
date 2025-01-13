<script setup>
import { onMounted, reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import ButtonModalAction from './ButtonModalAction.vue';
import ButtonModalPlayer from './ButtonModalPlayer.vue';
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
    player: {
        type: Object,
        required: false,
    }
});

const { game, player } = toRefs(props);

const data = reactive({
    selectedPlayer: null,
    selectedAssistPlayer: null,
    score: 2,
    gameId: null,
});

onMounted(() => {
    if (player.value) {
        data.selectedPlayer = player.value;
    }
});

const save = async function () {
    data.gameId = game.value.game_id;
    await router.post('/live/' + data.gameId + '/score', data);
    $vfm.hideAll();
};

function canBeSaved() {
    return data.selectedPlayer && data.score;
}

function selectPlayer(player) {
    data.selectedPlayer = player;
    data.selectedAssistPlayer = null;
}

function selectAssistPlayer(player) {
    data.selectedAssistPlayer = player;
}

function isActive(player) {
    return player.id === data.selectedPlayer?.id;
}

function isActiveAssist(player) {
    return player.id === data.selectedAssistPlayer?.id;
}

function setScore(score) {
    data.score = score;

    if (score === 1) {
        data.selectedAssistPlayer = null;
    }
}

function checkScore() {
    if (data.score > 3) {
        data.score = 3;
    }

    if (data.score < 1) {
        data.score = 1;
    }
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>POGODAK</h3>
                        <button @click="close" class="close">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-8 py-6 modal-body">
                        <div class="grid gap-6 grid-cols-[1fr_100px_1fr]" :class="{ 'grid-cols-[1fr_120px]': data.score === 1 }">
                            <div class="text-center">
                                <h3 class="mb-3 text-sm text-center uppercase">Pogađa</h3>
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                    <PlayerSelectBlock :player="player" :active="isActive(player)" v-for="player in players" :key="'playersc-' + player.id"
                                        @click="selectPlayer(player)" />
                                </div>
                            </div>

                            <div class="mb-6 space-y-3 text-center">
                                <h3 class="text-sm text-center uppercase">Poena</h3>
                                <ButtonModalAction :active="data.score === 2" @click="setScore(2)">2</ButtonModalAction>
                                <ButtonModalAction :active="data.score === 3" @click="setScore(3)">3</ButtonModalAction>
                                <ButtonModalAction :active="data.score === 1" @click="setScore(1)">1</ButtonModalAction>
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

                            <div v-if="data.score > 1">
                                <h3 class="mb-3 text-sm text-center uppercase">Asistira</h3>
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                    <PlayerSelectBlock :player="player" :active="isActiveAssist(player)" v-for="player in players" :key="'playeras-' + player.id"
                                        @click="selectAssistPlayer(player)" :class="{ hidden: player.id === data.selectedPlayer?.id }" />
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
