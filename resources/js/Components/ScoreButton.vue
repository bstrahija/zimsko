<script setup>
let props = defineProps({
    active: false,
});
</script>

<template>
    <a href="#" :class="{ 'active': active }"
        class="flex gap-1 justify-center items-center py-3 text-center text-white uppercase rounded transition-opacity lg:py-4 xl:py-5 text-2xs sm:text-3xs md:text-2xs score-button">
        <slot />
    </a>


</template>

<style scoped>
.active {
    transition: all;
    box-shadow: 0 8px 12px -2px rgb(6 182 212 / 0.4), 0 3px 5px -3px rgb(6 182 212 / 0.4) !important;
    transform: scale(1.05) !important;
}
</style>
