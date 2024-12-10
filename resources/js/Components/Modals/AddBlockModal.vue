<script setup>
import { reactive, ref, toRefs } from 'vue';
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
    opponentPlayers: {
        type: Array,
        required: true,
    },
});

const { game } = toRefs(props);

const data = reactive({
    selectedPlayer: null,
    selectedBlockedPlayer: null,
    gameId: null,
});

const save = async function () {
    data.gameId = game.value.game_id;
    await router.post('/live/' + data.gameId + '/block', data);
    $vfm.hideAll();
};

function canBeSaved() {
    return data.selectedPlayer;
}

function selectPlayer(player) {
    data.selectedPlayer = player;
    data.selectedBlockedPlayer = null;
}

function selectBlockedPlayer(player) {
    data.selectedBlockedPlayer = player;
}

function isActive(player) {
    return player.id === data.selectedPlayer?.id;
}

function isActiveBlocked(player) {
    return player.id === data.selectedBlockedPlayer?.id;
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="mb-3 text-2xl font-bold text-center">Odaberi igrača (blokada)</h3>
                        <button @click="close" class="absolute top-4 right-4 text-2xl">X</button>
                    </div>

                    <div class="modal-body">
                        <div class="grid">
                            <div class="text-center">
                                <button @click="selectPlayer(player)" v-for="player in players" :key="player.id"
                                    :class="{ 'bg-emerald-600': isActive(player), 'bg-slate-500': !isActive(player) }"
                                    class="px-4 py-2 m-1 text-white rounded-md shadow-md transition-colors duration-200 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
                                    <p class="text-2xl font-bold">{{ player.number }}</p>
                                    {{ player.name }}
                                </button>
                            </div>
                        </div>

                        <div v-if="data.selectedPlayer" class="mt-8">
                            <h3 class="mb-3 text-2xl font-bold text-center">Blokirao</h3>

                            <div class="grid mb-12">
                                <div class="text-center">
                                    <button @click="selectBlockedPlayer(player)" v-for="player in opponentPlayers"
                                        :key="player.id"
                                        :class="{ 'bg-emerald-600': isActiveBlocked(player), 'bg-slate-500': !isActiveBlocked(player), hidden: isActive(player) }"
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

<style scoped>
.modal-backdrop {
    opacity: 0.9;
}
</style>
