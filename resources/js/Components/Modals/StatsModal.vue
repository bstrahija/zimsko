<script setup>
import { reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import PlayerBlock from '../PlayerBlock.vue';
import { $vfm } from 'vue-final-modal';
import CloseButton from './CloseButton.vue';
import TeamStats from '../Stats/TeamStats.vue';
import PlayerStats from '../Stats/PlayerStats.vue';

const props = defineProps({
    game: {
        type: Object,
        required: true,
    },
});

const { game } = toRefs(props);

const data = reactive({
    statType: 'teams',
    statTypes: [
        { label: 'Ekipe', value: 'teams' },
        { label: 'Poeni', value: 'score' },
        { label: 'Trice', value: 'three_points' },
        { label: 'Asistencije', value: 'assists' },
        { label: 'Ukradene', value: 'steals' },
        { label: 'Skokovi', value: 'rebounds' },
        { label: 'Blokade', value: 'blocks' },
        { label: 'Izgubljene', value: 'turnovers' },
        { label: 'Prekršaji', value: 'fouls' },
        { label: 'Efikasnost', value: 'efficiency' },
    ],
});

const setType = (type) => {
    data.statType = type;
};
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog max-w-[800px] w-full" style="min-width: 300px; max-width: 1200px;">
                <div class="modal-content">


                    <div class="modal-body">
                        <div class="grid">
                            <div class="grid relative">
                                <CloseButton @click="close" />

                                <div class="grid grid-cols-12">
                                    <div class="col-span-2 bg-gradient-to-br bg-slate-800 from-slate-800 to-slate-900">
                                        <ul class="p-2 space-y-2">
                                            <li class="relative" v-for="(statType, i) in data.statTypes">
                                                <button @click="setType(statType.value)"
                                                    class="block p-3 w-full text-sm font-medium text-white rounded-md transition-all duration-200 hover:bg-slate-700/50 hover:shadow-md"
                                                    :class="{ 'bg-slate-700/50 shadow-md': data.statType === statType.value }">
                                                    {{ statType.label }}
                                                </button>
                                                <div v-if="i !== 10" class="my-1 h-px bg-gradient-to-r from-transparent to-transparent opacity-30 via-slate-600"></div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-span-10">
                                        <TeamStats :game="game" v-if="data.statType === 'teams'" />
                                        <PlayerStats :players="game.home_players.concat(game.away_players)" :game="game" :type="data.statType" v-else />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </vue-final-modal>
</template>

<style scoped>
.modal-backdrop {
    opacity: 0.9;
}
</style>
