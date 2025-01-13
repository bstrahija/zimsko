<script setup>
import IconAssist from './Icons/IconAssist.vue';
import IconBlock from './Icons/IconBlock.vue';
import IconFlagrant from './Icons/IconFlagrant.vue';
import IconFoul from './Icons/IconFoul.vue';
import IconMiss from './Icons/IconMiss.vue';
import IconRebound from './Icons/IconRebound.vue';
import IconScore from './Icons/IconScore.vue';
import IconSteal from './Icons/IconSteal.vue';
import IconSubstitution from './Icons/IconSubstitution.vue';
import IconTechnical from './Icons/IconTechnical.vue';
import IconTurnover from './Icons/IconTurnover.vue';
import ScoreButton from './ScoreButton.vue';

const props = defineProps({
    game: {
        type: Object,
        required: true,
    },
    team: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="grid grid-cols-2 gap-2 score-button-group">
        <ScoreButton class="add-score" @click="$live.addScore(game, team)">
            <IconScore />
            Pogodak
        </ScoreButton>
        <ScoreButton class="add-miss" @click="$live.addMiss(game, team)">
            <IconMiss />
            Promašaj
        </ScoreButton>
        <!-- <ScoreButton class="add-assist" @click="$live.addAssist(game, team)">
            <IconAssist />
            Asistencija
        </ScoreButton> -->
        <ScoreButton class="add-rebound" @click="$live.addRebound(game, team)">
            <IconRebound />
            <span class="text-3xs md:text-2xs">Skok</span>
        </ScoreButton>
        <ScoreButton class="add-steal" @click="$live.addSteal(game, team)">
            <IconSteal />
            Ukradena
        </ScoreButton>
        <ScoreButton class="add-block" @click="$live.addBlock(game, team)">
            <IconBlock />
            Blokada
        </ScoreButton>
        <ScoreButton class="add-turnover" @click="$live.addTurnover(game, team)">
            <IconTurnover />
            Izgubljena
        </ScoreButton>
        <ScoreButton class="add-foul" @click="$live.addFoul(game, team)">
            <IconFoul />
            Prekršaj
        </ScoreButton>
        <ScoreButton class="add-technical" @click="$live.addFoul(game, team, 'tf')">
            <IconTechnical />
            Tehnička
        </ScoreButton>
        <!-- <ScoreButton class="add-flagrant" @click="addFoul('ff')">
            <IconFlagrant />
            Nesportska
        </ScoreButton> -->
        <ScoreButton class="col-span-2 add-substitution" @click="$live.addSubstitution(game, team)">
            <IconSubstitution />
            Izmjena
        </ScoreButton>
        <!-- <ScoreButton class="col-span-2 add-timeout" @click="addTimeout">
            <IconTimeout />
            Timeout
        </ScoreButton> -->
    </div>
</template>
