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
                        <h3 class="mb-3 text-2xl font-bold text-center">Odaberi igrača (pogodak)</h3>
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

                            <div class="grid grid-cols-3 text-center max-w-[360px] mt-4 mb-6 mx-auto">
                                <button @click="setScore(2)" :class="{ 'opacity-50': data.score !== 2 }"
                                    class="overflow-hidden px-4 py-2 m-1 text-white bg-blue-500 rounded-md shadow-md transition-colors duration-200 aspect-square hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">2
                                    poena</button>
                                <button @click="setScore(3)" :class="{ 'opacity-50': data.score !== 3 }"
                                    class="overflow-hidden px-4 py-2 m-1 text-white bg-blue-500 rounded-md shadow-md transition-colors duration-200 aspect-square hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">Trica</button>
                                <button @click="setScore(1)" :class="{ 'opacity-50': data.score !== 1 }"
                                    class="overflow-hidden px-4 py-2 m-1 text-white bg-blue-500 rounded-md shadow-md transition-colors duration-200 aspect-square hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">Slobodno
                                    Bacanje</button>
                            </div>
                        </div>

                        <div v-if="data.score > 1" class="mt-8">
                            <h3 class="mb-3 text-2xl font-bold text-center">Asistencija</h3>

                            <div class="grid mb-12">
                                <div class="text-center">
                                    <button @click="selectAssistPlayer(player)" v-for="player in players"
                                        :key="player.id"
                                        :class="{ 'bg-emerald-600': isActiveAssist(player), 'bg-slate-500': !isActiveAssist(player), hidden: isActive(player) }"
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
