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
            <div class="text-xs text-fuchsia-400 uppercase">
                {{ (game.period <= 4) ? 'Četvrtina' : 'Produžetak' }} </div>
                    <div class="text-3xl font-bold text-fuchsia-300">
                        {{ game.period <= 4 ? game.period : game.period - 4 }} </div>
                    </div>
            </div>
</template>
