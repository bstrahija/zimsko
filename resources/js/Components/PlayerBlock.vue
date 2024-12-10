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
        class="flex relative justify-center items-start pt-6 h-full text-center text-white rounded border shadow-sm transition-all pointer-events-auto min-h-40 hover:opacity-90 hover:shadow-lg player-block">
        <div class="text-xl font-bold">
            {{ player.number }}

            <div v-if="player?.data?.photo" class="overflow-hidden mt-2 w-8 rounded-full opacity-60 aspect-square">
                <img :src="player.data.photo" alt="">
            </div>
        </div>

        <small
            class="absolute bottom-2 left-1/2 font-medium text-center opacity-60 transform -translate-x-1/2 text-2xs line-clamp-2">
            {{ player.name }}
        </small>

        <small
            class="flex overflow-hidden absolute top-2 left-2 justify-center items-center p-1 w-5 rounded-full opacity-70 text-2xs aspect-square points"
            title="Poeni" v-if="player.stats">{{ player?.stats?.points }}</small>
        <small
            class="flex overflow-hidden absolute top-2 right-2 justify-center items-center p-1 w-5 rounded-full opacity-70 text-2xs aspect-square fouls"
            title="Prekršaji" v-if="player.stats">{{ player?.stats?.fouls }}</small>
    </button>
</template>
