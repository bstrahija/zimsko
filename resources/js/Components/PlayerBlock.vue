<script setup>
import { inject } from 'vue';
const helpers = inject('helpers');

defineProps({
    game: {
        type: Object,
        required: true,
    },
    player: {
        type: Object,
        required: true,
    },
    active: false,
});
</script>

<template>
    <button
        class="overflow-hidden relative h-full text-center text-white rounded border shadow-sm transition-all pointer-events-auto bg-black/90 hover:opacity-90 hover:shadow-lg player-block aspect-square"
        :class="{ 'active': active }">
        <div>
            <div
                class="flex absolute top-1 left-1 z-40 justify-center items-center w-4 h-4 font-bold text-white rounded-full opacity-70 text-3xs bg-green-600/80 player-stat-indicator">
                {{ helpers.getPlayerStat(game, player, 'score') }}
            </div>

            <div
                class="flex absolute top-1 right-1 z-40 justify-center items-center w-4 h-4 font-bold text-white rounded-full opacity-70 text-3xs bg-red-600/80 player-stat-indicator">
                {{ helpers.getPlayerStat(game, player, 'fouls') }}
            </div>

            <div class="z-30 font-mono text-sm font-bold shadow-lg md:text-lg lg:text-xl xl:text-3xl">
                {{ player.number ? player.number : '-' }}
            </div>

            <small class="block relative z-20 font-medium text-center opacity-60 text-3xs lg:text-2xs xl:text-xs line-clamp-2">
                {{ player.name }}
            </small>
        </div>

        <div v-if="player?.photo" class="absolute inset-0 z-10 opacity-20">
            <img :src="player.photo" alt="" class="object-cover w-full h-full">
        </div>
    </button>
</template>
