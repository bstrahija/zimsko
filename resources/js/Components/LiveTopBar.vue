<script setup>
import { ref, toRefs } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';

const showDropdown = ref(false);

const props = defineProps({
    backUrl: String,
    title: { type: String, required: true },
    game: Object,
    closeUrl: String,
});

const toggleDropdown = function () {
    showDropdown.value = !showDropdown.value;

}

const resetGame = async function () {
    if (confirm("Jeste li sigurni? Izgubit će te svu statistiku!")) {
        router.post('/live/' + props.game.id + '/reset-game');
    }
}
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

        <div v-if="game" class="inline-block relative">
            <a @click="toggleDropdown" href="#" class="inline-block px-2 py-[3px] ml-2 font-medium rounded-full text-2xs" :class="{
                'bg-slate-600 text-slate-100': game.status === 'completed',
                'bg-green-500 text-green-100 animate-pulse': game.status === 'in_progress',
                'bg-orange-600 text-yellow-100': game.status === 'draft',
                'bg-blue-500 text-blue-100': game.status === 'scheduled'
            }">
                {{ game.status.replace(/_/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}
            </a>

            <div class="overflow-hidden absolute left-0 top-full z-50 mt-1 w-48 rounded-md shadow-lg bg-slate-800/90" v-if="showDropdown">
                <div class="py-1">
                    <a href="#" @click="resetGame" class="block px-4 py-2 text-sm text-rose-400 hover:bg-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block mr-1 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>

                        Reset game
                    </a>
                </div>
            </div>
        </div>
    </h1>
</template>
