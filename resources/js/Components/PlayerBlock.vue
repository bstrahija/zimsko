<script setup>
defineProps({
    player: {
        type: Object,
        required: true,
    },
    active: false,
});
</script>

<template>
    <button
        class="overflow-hidden relative h-full text-center text-white rounded border shadow-sm transition-all pointer-events-auto hover:opacity-90 hover:shadow-lg player-block aspect-square"
        :class="{ 'active': active }">
        <div>
            <div class="z-30 font-mono text-sm font-bold shadow-lg md:text-lg lg:text-xl xl:text-3xl">
                {{ player.number ? player.number : '-' }}

            </div>
            <small class="block relative z-20 font-medium text-center opacity-60 text-3xs lg:text-2xs xl:text-xs line-clamp-2">
                {{ player.name }}
            </small>
        </div>

        <div v-if="player?.data?.photo" class="absolute inset-0 z-10 opacity-20">
            <img :src="player.data.photo" alt="" class="object-cover w-full h-full">
        </div>
    </button>
</template>
