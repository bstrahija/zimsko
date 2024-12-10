<script setup>
defineProps({
    team: {
        type: Object,
        required: true,
    },
    score: {
        type: Number,
        required: false,
    },
    side: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div class="grid grid-cols-12 p-4 rounded-lg border score-bar">
        <div v-if="side === 'home'" class="flex col-span-3 justify-center items-center"><img :src="team.logo" alt=""
                class="w-20 h-20 rounded-full" /></div>
        <div v-if="side === 'away'"
            class="flex col-span-2 justify-center items-center text-6xl font-bold score font-oswald">{{ score }}</div>
        <div class="flex col-span-7 justify-center items-center mt-2 text-2xl text-center font-oswald team">{{
            team.title }}</div>
        <div v-if="side === 'home'"
            class="flex col-span-2 justify-center items-center text-6xl font-bold score font-oswald">{{ score }}</div>
        <div v-if="side === 'away'" class="flex col-span-3 justify-center items-center"><img :src="team.logo" alt=""
                class="w-20 h-20 rounded-full" /></div>
    </div>
</template>
