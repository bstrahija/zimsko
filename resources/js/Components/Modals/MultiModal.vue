<script setup>
import { onMounted, reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import ButtonModalAction from './ButtonModalAction.vue';
import PlayerBlock from '../PlayerBlock.vue';
import PlayerSelectBlock from '../PlayerSelectBlock.vue';
import { $vfm } from 'vue-final-modal';
import PlayersOnCourt from '../PlayersOnCourt.vue';
import IconAssist from '../Icons/IconAssist.vue';
import IconBlock from '../Icons/IconBlock.vue';
import IconFlagrant from '../Icons/IconFlagrant.vue';
import IconFoul from '../Icons/IconFoul.vue';
import IconMiss from '../Icons/IconMiss.vue';
import IconRebound from '../Icons/IconRebound.vue';
import IconScore from '../Icons/IconScore.vue';
import IconSteal from '../Icons/IconSteal.vue';
import IconSubstitution from '../Icons/IconSubstitution.vue';
import IconTechnical from '../Icons/IconTechnical.vue';
import IconTurnover from '../Icons/IconTurnover.vue';
import ScoreButton from '../ScoreButton.vue';

const props = defineProps({
    player: {
        type: Object,
        required: true,
    },
    team: {
        type: Object,
        required: true,
    },
    playersOnCourt: {
        type: Array,
        required: true,
    },
    playersOnBench: {
        type: Array,
        required: true,
    },
    opponentPlayers: {
        type: Array,
        required: true,
    },
    opponentPlayersOnCourt: {
        type: Array,
        required: true,
    },
    game: {
        type: Object,
        required: true,
    },
});

const { game, player } = toRefs(props);

const data = reactive({
    action: 'score',
    type: 2,
    selectedPlayer: props.player,
    selectedOtherPlayer: null,
});

function setAction(action, type) {
    data.action = action
    data.type = type
    data.selectedOtherPlayer = null
}

function setType(type) {
    data.type = type
}

const save = async function () {
    data.gameId = game.value.id;
    await router.post('/live/' + data.gameId + '/multi', data);
    $vfm.hideAll();
    // data.gameId = game.value.id;
    // await router.post('/live/' + data.gameId + '/foul', data);

    // $vfm.hideAll();
};

function canBeSaved() {
    if (data.action === 'score' || (data.action === 'miss')) {
        return props.player && (data.type === 1 || data.type === 2 || data.type === 3)
    } else if (data.action === 'rebound') {
        return props.player && (data.type === 'def' || data.type === 'off')
    } else if (data.action === 'foul') {
        return props.player && (data.type === 'pf' || data.type === 'ff' || data.type === 'tf')
    } else if (data.action === 'substitution') {
        return props.player && data.selectedOtherPlayer && true
    } else {
        return props.player && true
    }
}

function selectOtherPlayer(player) {
    data.selectedOtherPlayer = player;
}

function isActiveOther(player) {
    return player.id === data.selectedOtherPlayer?.id;
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>
                            #{{ player.number }} -
                            {{ player.name }}
                        </h3>
                        <button @click="close" class="close">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-8 py-6 modal-body">
                        <div class="grid gap-6 grid-cols-[1fr_100px_1fr]">
                            <div class="pt-8 text-center home-controls">
                                <div class="grid grid-cols-2 gap-4">
                                    <ScoreButton class="add-score" @click="setAction('score', 2)" :active="data.action === 'score'">
                                        <IconScore />
                                        Pogodak
                                    </ScoreButton>

                                    <ScoreButton class="add-miss" @click="setAction('miss', 2)" :active="data.action === 'miss'">
                                        <IconMiss />
                                        Promašaj
                                    </ScoreButton>

                                    <ScoreButton class="add-rebound" @click="setAction('rebound', 'def')" :active="data.action === 'rebound'">
                                        <IconRebound />
                                        Skok
                                    </ScoreButton>

                                    <ScoreButton class="add-steal" @click="setAction('steal')" :active="data.action === 'steal'">
                                        <IconSteal />
                                        Ukradena
                                    </ScoreButton>

                                    <ScoreButton class="add-block" @click="setAction('block')" :active="data.action === 'block'">
                                        <IconBlock />
                                        Blokada
                                    </ScoreButton>

                                    <ScoreButton class="add-turnover" @click="setAction('turnover')" :active="data.action === 'turnover'">
                                        <IconTurnover />
                                        Izgubljena
                                    </ScoreButton>

                                    <ScoreButton class="add-foul" @click="setAction('foul', 'pf')" :active="data.action === 'foul' && data.type !== 'tf'">
                                        <IconFoul />
                                        Prekršaj
                                    </ScoreButton>

                                    <ScoreButton class="add-turnover" @click="setAction('foul', 'tf')" :active="data.action === 'foul' && data.type === 'tf'">
                                        <IconTurnover />
                                        Tehnička
                                    </ScoreButton>

                                    <ScoreButton class="col-span-2 add-substitution" @click="setAction('substitution')" :active="data.action === 'substitution'">
                                        <IconSubstitution />
                                        Izmjena
                                    </ScoreButton>
                                </div>
                            </div>

                            <div class="pt-8 mb-6 space-y-3 text-center">
                                <div class="mb-6 space-y-3 text-center" v-if="data.action === 'score' || data.action === 'miss'">
                                    <ButtonModalAction :active="data.type === 1" @click="setType(1)">1</ButtonModalAction>
                                    <ButtonModalAction :active="data.type === 2" @click="setType(2)">2</ButtonModalAction>
                                    <ButtonModalAction :active="data.type === 3" @click="setType(3)">3</ButtonModalAction>
                                    <hr class="opacity-20">
                                </div>

                                <div class="mb-6 space-y-3 text-center" v-if="data.action === 'rebound'">
                                    <ButtonModalAction :active="data.type === 'def'" @click="setType('def')">Defenzivni</ButtonModalAction>
                                    <ButtonModalAction :active="data.type === 'off'" @click="setType('off')">Ofenzivni</ButtonModalAction>
                                    <hr class="opacity-20">
                                </div>

                                <div class="mb-6 space-y-3 text-center" v-if="data.action === 'foul'">
                                    <ButtonModalAction :active="data.type === 'pf'" @click="setType('pf')">Osobna</ButtonModalAction>
                                    <ButtonModalAction :active="data.type === 'tf'" @click="setType('tf')">Tehnička</ButtonModalAction>
                                    <ButtonModalAction :active="data.type === 'ff'" @click="setType('ff')">Nesportska</ButtonModalAction>
                                    <hr class="opacity-20">
                                </div>

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

                            <div>
                                <div v-if="data.action === 'score'">
                                    <h3 class="mb-3 text-sm text-center uppercase">Asistira</h3>
                                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                        <PlayerSelectBlock :player="player" :active="isActiveOther(player)" v-for="player in playersOnCourt" :key="'playeron-' + player.id"
                                            @click="selectOtherPlayer(player)" :class="{ hidden: player.id == data.selectedPlayer?.id }" />
                                    </div>
                                </div>

                                <div v-if="data.action === 'steal' || data.action === 'block' || (data.action === 'foul' && data.type !== 'tf')">
                                    <h3 class="mb-3 text-sm text-center uppercase" v-if="data.action === 'steal'">Ukradena od</h3>
                                    <h3 class="mb-3 text-sm text-center uppercase" v-if="data.action === 'block'">Blokiran</h3>
                                    <h3 class="mb-3 text-sm text-center uppercase" v-if="data.action === 'foul'">Prekršaj na</h3>
                                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                        <PlayerSelectBlock :player="player" :active="isActiveOther(player)" v-for="player in opponentPlayersOnCourt" :key="'playerop-' + player.id"
                                            @click="selectOtherPlayer(player)" :class="{ hidden: player.id === data.selectedPlayer?.id }" />
                                    </div>
                                </div>

                                <div v-if="data.action === 'substitution'">
                                    <h3 class="mb-3 text-sm text-center uppercase">Ulazi</h3>
                                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                                        <PlayerSelectBlock :player="player" :active="isActiveOther(player)" v-for="player in playersOnBench" :key="'playerbc-' + player.id"
                                            @click="selectOtherPlayer(player)" :class="{ hidden: player.id === data.selectedPlayer?.id }" />
                                    </div>
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
