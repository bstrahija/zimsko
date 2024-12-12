<script setup>
import { toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import PlayerBlock from './PlayerBlock.vue';

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
});

const { game, team, players } = toRefs(props);
</script>

<template>
    <!-- <h1 class="mb-3 text-sm text-center text-white uppercase">Na Terenu</h1> -->
    <div class="grid grid-cols-5 gap-2 text-3xl font-bold text-white players-on-court min-h-20">
        <PlayerBlock v-for="player in players" :key="player.id" :player="player" @click="$live.addScore(game, team, player)/*$live.addSubstitution(game, team, null, player)*/" />
    </div>
</template>
