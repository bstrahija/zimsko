<script setup>
defineProps({
    player: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <button
        class="relative justify-center items-center h-full text-center text-white rounded border shadow-sm transition-all pointer-events-auto hover:opacity-90 hover:shadow-lg player-block aspect-square">
        <p class="text-2xl font-bold">{{ player.number }}</p>
        <small
            class="absolute bottom-2 left-1/2 font-medium text-center opacity-60 transform -translate-x-1/2 text-2xs line-clamp-2">
            {{ player.name }}
        </small>

        <small
            class="flex overflow-hidden absolute top-2 left-2 justify-center items-center p-1 w-5 rounded-full opacity-70 text-2xs aspect-square points"
            title="Poeni">{{ player.stats.points }}</small>
        <small
            class="flex overflow-hidden absolute top-2 right-2 justify-center items-center p-1 w-5 rounded-full opacity-70 text-2xs aspect-square fouls"
            title="Prekršaji">{{ player.stats.fouls }}</small>
    </button>
</template>
