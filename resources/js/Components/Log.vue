<script setup>
import LogItem from './LogItem.vue';

defineProps({
    log: {
        type: Array,
        required: true,
    },
    game: {
        type: Object,
        required: true,
    },
    live: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="pr-2 space-y-3">
        <LogItem v-for="item in log" :key="item.id" :log="item" :game="game" :live="live" />
    </div>
</template>
