<script setup>
defineProps({
    log: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="p-3 rounded-sm shadow bg-slate-50">
        <h3 class="pb-2 mb-2 uppercase border-b border-gray-200 text-medium font-oswald">{{ log.quarter }}. četvrtina</h3>

        <p class="text-sm">{{ log.message }}</p>
    </div>
</template>
