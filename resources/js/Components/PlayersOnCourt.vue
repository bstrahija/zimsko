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
    <div class="grid grid-cols-5 gap-2 text-3xl font-bold text-white players-on-court min-h-20">
        <PlayerBlock v-for="player in players" :key="player.id" :player="player" class="bg-emerald-600" />
    </div>
</template>
