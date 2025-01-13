<script setup>
let props = defineProps({
    active: false,
});
</script>

<template>
    <button :class="{ 'opacity-50': !active }"
        class="overflow-hidden px-4 py-2 w-full text-white bg-gradient-to-r from-blue-400 to-blue-600 rounded-md border border-blue-300 shadow-md transition-all duration-200 hover:from-blue-500 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 hover:shadow-lg hover:shadow-blue-500/50">
        <slot></slot>
    </button>
</template>
