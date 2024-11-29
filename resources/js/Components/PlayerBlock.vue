<script setup>
defineProps({
    player: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <button class="relative justify-center items-center h-full text-center rounded shadow-sm transition-all pointer-events-auto hover:opacity-80 hover:shadow-lg">
        <p class="text-2xl font-bold text-white">{{ player.number }}</p>
        <small class="px-1 font-medium text-slate-100 text-2xs">{{ player.name }}</small>

        <small class="flex overflow-hidden absolute top-2 left-2 justify-center items-center p-1 w-5 bg-green-600 rounded-full opacity-70 text-2xs aspect-square">{{ player.stats.points }}</small>
        <small class="flex overflow-hidden absolute top-2 right-2 justify-center items-center p-1 w-5 bg-red-500 rounded-full opacity-70 text-2xs aspect-square">{{ player.stats.fouls }}</small>
    </button>
</template>
