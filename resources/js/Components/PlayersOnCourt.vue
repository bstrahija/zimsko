<script setup>
import PlayerBlock from './PlayerBlock.vue';

defineProps({
    players: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <!-- <h1 class="mb-3 text-sm text-center text-white uppercase">Na Terenu</h1> -->
    <div class="grid grid-cols-5 gap-2 text-3xl font-bold text-white players-on-court min-h-20">
        <PlayerBlock v-for="player in players" :key="player.id" :player="player" />
    </div>
</template>
