<script setup>
defineProps({
    live: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="flex justify-center items-center p-2 h-full text-center rounded quarter-indicator">
        <div class="">
            <div class="text-xs text-fuchsia-400">ČETVRTINA</div>
            <div class="text-3xl font-bold text-fuchsia-300">{{ live.quarter }}</div>
        </div>
    </div>
</template>
