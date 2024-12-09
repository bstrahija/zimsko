<script setup>
import PlayerBlock from './PlayerBlock.vue';

defineProps({
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
</script>

<template>
    <div class="grid grid-cols-2 auto-rows-min gap-2 grid-min-rows players-on-bench">
        <PlayerBlock v-for="player in players" :key="player.id" :player="player"
            @click="$live.addSubstitution(game, team, player, null)" />
    </div>
</template>
