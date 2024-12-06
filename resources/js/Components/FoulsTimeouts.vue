<script setup>
import LogItem from './LogItem.vue';

defineProps({
    team: {
        type: Object,
        required: true,
    },
    side: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="grid grid-cols-3 gap-4">
        <div class="px-2 py-2 space-y-1 text-center rounded foul-timeout-btn">
            <div class="text-xs">PREKRŠAJI</div>
            <div class="text-2xl font-bold">{{ team.stats.fouls }}</div>
        </div>
        <div class="px-2 py-2 space-y-1 text-center rounded foul-timeout-btn">
            <div class="text-xs">TIMEOUT</div>
            <div class="text-2xl font-bold">{{ team.stats.timeouts }}</div>
        </div>
        <div class="px-2 py-2 space-y-1 text-center rounded foul-timeout-btn">
            <div class="text-xs">BONUS</div>
            <div class="text-2xl font-bold text-pink-500" v-if="team.stats.fouls >= 5">✓</div>
            <div class="text-2xl font-bold" v-else>-</div>
        </div>
    </div>
</template>
