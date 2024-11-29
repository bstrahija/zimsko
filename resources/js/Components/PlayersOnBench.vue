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
    <div class="grid grid-cols-2 gap-2">
        <PlayerBlock v-for="player in players" :key="player.id" :player="player" class="bg-slate-400" />
    </div>
</template>
