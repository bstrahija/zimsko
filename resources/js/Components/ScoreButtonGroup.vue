<script setup>
import AddAssistModal from './Modals/AddAssistModal.vue';
import AddBlockModal from './Modals/AddBlockModal.vue';
import AddFoulModal from './Modals/AddFoulModal.vue';
import AddMissModal from './Modals/AddMissModal.vue';
import AddReboundModal from './Modals/AddReboundModal.vue';
import AddScoreModal from './Modals/AddScoreModal.vue';
import AddStealModal from './Modals/AddStealModal.vue';
import AddSubstitutionModal from './Modals/AddSubstitutionModal.vue';
import AddTimeoutModal from './Modals/AddTimeoutModal.vue';
import AddTurnoverModal from './Modals/AddTurnoverModal.vue';
import IconAssist from './Icons/IconAssist.vue';
import IconBlock from './Icons/IconBlock.vue';
import IconFlagrant from './Icons/IconFlagrant.vue';
import IconFoul from './Icons/IconFoul.vue';
import IconMiss from './Icons/IconMiss.vue';
import IconRebound from './Icons/IconRebound.vue';
import IconScore from './Icons/IconScore.vue';
import IconSubstitution from './Icons/IconSubstitution.vue';
import IconTechnical from './Icons/IconTechnical.vue';
import IconTimeout from './Icons/IconTimeout.vue';
import IconTurnover from './Icons/IconTurnover.vue';
import ScoreButton from './ScoreButton.vue';
import { $vfm } from 'vue-final-modal';
import { toRefs, ref } from 'vue';

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
    playersOnCourt: {
        type: Array,
        required: true,
    },
    opponents: {
        type: Array,
        required: true,
    },
});

const { game, team, players, playersOnCourt, opponents } = toRefs(props);

function addScore(e) {
    $vfm.show({ component: AddScoreModal, bind: { game: game.value, team: team.value, players: players.value, playersOnCourt: playersOnCourt.value, opponents: opponents.value } });
    e.preventDefault();
}

function addMiss(e) {
    $vfm.show({ component: AddMissModal, bind: { game: game.value, team: team.value, players: players.value, playersOnCourt: playersOnCourt.value } });
    e.preventDefault();
}

function addAssist(e) {
    $vfm.show({ component: AddAssistModal, bind: { game: game.value, team: team.value, players: players.value, playersOnCourt: playersOnCourt.value } });
    e.preventDefault();
}

function addFoul(e) {
    $vfm.show({ component: AddFoulModal, bind: { game: game.value, team: team.value, players: players.value, playersOnCourt: playersOnCourt.value, opponents } });
    e.preventDefault();
}

function addBlock(e) {
    $vfm.show({ component: AddBlockModal, bind: { game: game.value, team: team.value, players: players.value, playersOnCourt: playersOnCourt.value } });
    e.preventDefault();
}

function addRebound(e) {
    $vfm.show({ component: AddReboundModal, bind: { game: game.value, team: team.value, players: players.value, playersOnCourt: playersOnCourt.value } });
    e.preventDefault();
}

function addSteal(e) {
    $vfm.show({ component: AddStealModal, bind: { game: game.value, team: team.value, players: players.value, playersOnCourt: playersOnCourt.value } });
    e.preventDefault();
}

function addTimeout(e) {
    $vfm.show({ component: AddTimeoutModal, bind: { game: game.value, team: team.value, players: players.value, playersOnCourt: playersOnCourt.value } });
    e.preventDefault();
}

function addTurnover(e) {
    $vfm.show({ component: AddTurnoverModal, bind: { game: game.value, team: team.value, players: players.value, playersOnCourt: playersOnCourt.value } });
    e.preventDefault();
}
</script>

<template>
    <div class="grid grid-cols-2 gap-2 score-button-group">
        <ScoreButton class="add-score" @click="addScore">
            <IconScore />
            Pogodak
        </ScoreButton>
        <ScoreButton class="add-miss" @click="addMiss">
            <IconMiss />
            Promašaj
        </ScoreButton>
        <!-- <ScoreButton class="add-assist" @click="addAssist">
            <IconAssist />
            Asistencija
        </ScoreButton> -->
        <ScoreButton class="add-rebound" @click="addRebound">
            <IconRebound />
            Skok
        </ScoreButton>
        <ScoreButton class="add-steal" @click="addAssist">
            <IconAssist />
            Ukradena
        </ScoreButton>
        <ScoreButton class="add-block" @click="addBlock">
            <IconBlock />
            Blokada
        </ScoreButton>
        <ScoreButton class="add-turnover" @click="addTurnover">
            <IconTurnover />
            Izgubljena
        </ScoreButton>
        <ScoreButton class="add-foul" @click="addFoul">
            <IconFoul />
            Prekršaj
        </ScoreButton>
        <ScoreButton class="add-technical" @click="addFoul('tf')">
            <IconTechnical />
            Tehnička
        </ScoreButton>
        <!-- <ScoreButton class="add-flagrant" @click="addFoul('ff')">
            <IconFlagrant />
            Nesportska
        </ScoreButton> -->
        <ScoreButton class="col-span-2 add-substitution">
            <IconSubstitution />
            Izmjena
        </ScoreButton>
        <ScoreButton class="col-span-2 add-timeout" @click="addTimeout">
            <IconTimeout />
            Timeout
        </ScoreButton>
    </div>
</template>
