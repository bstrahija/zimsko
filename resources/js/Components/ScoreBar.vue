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
    <div class="flex flex-col justify-between items-center p-4 rounded-lg border sm:flex-row score-bar" :class="{ 'flex-row-reverse': side === 'away' }">
        <div class="flex col-span-3 justify-center items-center lg:col-span-3">
            <img :src="team.logo" alt="" class="rounded-full size-10 sm:size-12 md:size-[60px] lg:size-20 aspect-square" />
        </div>

        <div class="flex col-span-12 justify-center items-center mt-2 text-lg text-center lg:text-2xl md:col-span-8 font-oswald team">
            {{ team.title }}
        </div>

        <div class="flex col-span-2 justify-center items-center text-3xl font-bold lg:text-6xl score font-oswald">
            {{ score }}
        </div>
    </div>
</template>
