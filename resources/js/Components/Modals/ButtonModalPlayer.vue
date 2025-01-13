<script setup>
let props = defineProps({
    player: {
        type: Object,
        required: true,
    },
    active: false,
});
</script>

<template>
    <button :class="{ 'bg-gradient-to-br from-emerald-500 to-teal-600': active, 'bg-gradient-to-br from-slate-600 to-slate-700': !active }"
        class="grid w-full items-center grid-cols-[50px_1fr] px-4 py-2 m-1 text-white rounded-lg shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-emerald-400/50 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-opacity-50 border border-emerald-400/50">
        <p class="text-3xl font-bold" :class="{ 'text-emerald-200': active, 'text-slate-200': !active }">{{ player.number }}</p>
        <p class="text-lg font-medium">{{ player.name }}</p>
    </button>
</template>
