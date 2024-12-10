<script setup>
import { reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import PlayerBlock from '../PlayerBlock.vue';
import { $vfm } from 'vue-final-modal';

const props = defineProps({
    game: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="mb-3 text-2xl font-bold text-center">Statistika</h3>
                        <button @click="close" class="absolute top-4 right-4 text-2xl">X</button>
                    </div>

                    <div class="modal-body">
                        <div class="grid">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- <div v-for="team in [game.home_team, game.away_team]" :key="team.id"
                                    class="p-4 bg-gray-100 rounded-lg">
                                    <h4 class="mb-2 text-lg font-semibold">{{ team.title }}</h4>
                                    <ul class="space-y-1">
                                        <li>Points: {{ team.stats.points }}</li>
                                        <li>Three Pointers: {{ team.stats.three_pointers }}</li>
                                        <li>Free Throws: {{ team.stats.free_throws }}</li>
                                        <li>Steals: {{ team.stats.steals }}</li>
                                        <li>Rebounds: {{ team.stats.rebounds }}</li>
                                        <li>Turnovers: {{ team.stats.turnovers }}</li>
                                    </ul>
                                </div> -->
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
