<script setup>
import LogItem from './LogItem.vue';

defineProps({
    log: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div class="overflow-y-scroll space-y-3 h-[100svh]">
        <h2 class="text-xl font-bold uppercase text-secondary font-oswald">TIJEK UTAKMICE</h2>
        <LogItem v-for="item in log" :key="item.id" :log="item" />
    </div>
</template>
