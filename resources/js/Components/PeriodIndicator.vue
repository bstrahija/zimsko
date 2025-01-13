<script setup>
defineProps({
    game: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="flex justify-center items-center p-2 h-full text-center rounded period-indicator">
        <div class="">
            <div class="text-fuchsia-400 uppercase text-2xs lg:text-xs">
                {{ (game.period <= 4) ? 'Četvrtina' : 'Produžetak' }} </div>
                    <div class="font-bold text-fuchsia-300 text-md md:text-lg lg:text-2xl">
                        {{ game.period <= 4 ? game.period : game.period - 4 }} </div>
                    </div>
            </div>
</template>
