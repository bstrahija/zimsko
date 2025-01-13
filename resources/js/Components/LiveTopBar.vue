<script setup>
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    backUrl: String,
    title: { type: String, required: true },
    game: Object,
    closeUrl: String,
});
</script>

<template>
    <h1 class="relative px-3 py-2 -mt-6 -mr-6 mb-4 -ml-6 text-xs text-center uppercase text-white/80 bg-cyan-400/15">
        <Link :href="closeUrl ?? '/live'" class="absolute right-3 top-1/2 text-red-500 transition-transform -translate-y-1/2 hover:text-cyan-300 hover:rotate-90">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
        </Link>

        <Link v-if="backUrl" :href="backUrl" class="absolute left-3 top-1/2 text-cyan-400 transition-transform -translate-y-1/2 hover:text-cyan-300 group">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:animate-pulse" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                clip-rule="evenodd" />
        </svg>
        </Link>

        {{ title }}

        <span v-if="game" class="px-2 py-[3px] ml-2 font-medium rounded-full opacity-80 text-2xs" :class="{
            'bg-slate-600 text-slate-100': game.status === 'completed',
            'bg-green-500 text-green-100 animate-pulse': game.status === 'in_progress',
            'bg-orange-600 text-yellow-100': game.status === 'draft',
            'bg-blue-500 text-blue-100': game.status === 'scheduled'
        }">
            {{ game.status.replace(/_/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}
        </span>
    </h1>
</template>
