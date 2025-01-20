<script setup>
import { toRefs } from 'vue';
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
    <div class="grid grid-cols-2 gap-2 text-3xl font-bold text-white sm:grid-cols-3 lg:grid-cols-5 players-on-court min-h-10">
        <PlayerBlock v-for="player in players" :key="player.id" :player="player" @click="$live.multiModal(game, team, player)" />
    </div>
</template>
