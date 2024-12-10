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
            <div class="modal-dialog max-w-[400px] w-full" style="min-width: 300px; max-width: 800px;">
                <div class="modal-content">


                    <div class="modal-body">
                        <div class="grid">
                            <div class="grid relative">
                                <button @click="close" class="absolute top-4 left-[48%] text-2xl">X</button>

                                <table
                                    class="overflow-hidden w-full text-sm text-gray-300 rounded-lg border shadow-lg bg-slate-800/60 border-cyan-400/30">
                                    <thead>
                                        <tr class="bg-slate-700/50">
                                            <th class="px-4 py-3 text-3xl font-bold text-left text-cyan-400 w-[40%]">
                                                {{ game.home_team.title }}
                                            </th>
                                            <th class="px-4 py-3 text-center w-[20%]"></th>
                                            <th class="px-4 py-3 text-3xl font-bold text-right text-cyan-400 w-[40%]">
                                                {{ game.away_team.title }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-lg">
                                        <tr
                                            class="transition-colors duration-200 border-slate-700/50 hover:bg-slate-700/30">
                                            <td class="px-4 py-6 text-3xl font-semibold">
                                                {{ game.home_team.stats.score }}
                                            </td>
                                            <td class="px-4 py-6 text-lg text-center text-cyan-300">Rezultat</td>
                                            <td class="px-4 py-6 text-3xl font-semibold text-right">
                                                {{ game.away_team.stats.score }}
                                            </td>
                                        </tr>
                                        <tr
                                            class="border-t transition-colors duration-200 border-slate-700/50 hover:bg-slate-700/30">
                                            <td class="px-4 py-4">
                                                <strong>{{ game.home_team.stats.three_points_made }}</strong> /
                                                <span class="text-gray-400">{{ game.home_team.stats.three_points
                                                    }}</span>
                                                <small class="mr-2 text-sm text-gray-400">
                                                    ({{ game.home_team.stats.three_points_percent }}%)
                                                </small>

                                            </td>
                                            <td class="px-4 py-4 text-center text-cyan-300">3PT</td>
                                            <td class="px-4 py-4 text-right">
                                                <strong>{{ game.away_team.stats.three_points_made }}</strong> /
                                                <span class="text-gray-400">{{ game.away_team.stats.three_points
                                                    }}</span>
                                                <small class="mr-2 text-sm text-gray-400">
                                                    ({{ game.away_team.stats.three_points_percent }}%)
                                                </small>
                                            </td>
                                        </tr>
                                        <tr
                                            class="border-t transition-colors duration-200 border-slate-700/50 hover:bg-slate-700/30">
                                            <td class="px-4 py-4">
                                                <strong>{{ game.home_team.stats.two_points_made }}</strong> /
                                                <span class="text-gray-400">{{ game.home_team.stats.two_points }}</span>
                                                <small class="mr-2 text-sm text-gray-400">
                                                    ({{ game.home_team.stats.two_points_percent }}%)
                                                </small>
                                            </td>
                                            <td class="px-4 py-4 text-center text-cyan-300">FG</td>
                                            <td class="px-4 py-4 text-right">
                                                <strong>{{ game.away_team.stats.two_points_made }}</strong> /
                                                <span class="text-gray-400">{{ game.away_team.stats.two_points }}</span>
                                                <small class="mr-2 text-sm text-gray-400">
                                                    ({{ game.away_team.stats.two_points_percent }}%)
                                                </small>
                                            </td>
                                        </tr>
                                        <tr
                                            class="border-t transition-colors duration-200 border-slate-700/50 hover:bg-slate-700/30">
                                            <td class="px-4 py-4">
                                                <strong>{{ game.home_team.stats.free_throws_made }}</strong> /
                                                <span class="text-gray-400">{{ game.home_team.stats.free_throws
                                                    }}</span>
                                                <small class="mr-2 text-sm text-gray-400">
                                                    ({{ game.home_team.stats.free_throws_percent }}%)
                                                </small>
                                            </td>
                                            <td class="px-4 py-4 text-center text-cyan-300">FT</td>
                                            <td class="px-4 py-4 text-right">
                                                <strong>{{ game.away_team.stats.free_throws_made }}</strong> /
                                                <span class="text-gray-400">{{ game.away_team.stats.free_throws
                                                    }}</span>
                                                <small class="mr-2 text-sm text-gray-400">
                                                    ({{ game.away_team.stats.free_throws_percent }}%)
                                                </small>
                                            </td>
                                        </tr>
                                        <tr
                                            class="border-t transition-colors duration-200 border-slate-700/50 hover:bg-slate-700/30">
                                            <td class="px-4 py-4">
                                                {{ game.home_team.stats.assists }}
                                            </td>
                                            <td class="px-4 py-4 text-center text-cyan-300">AST</td>
                                            <td class="px-4 py-4 text-right">
                                                {{ game.away_team.stats.assists }}
                                            </td>
                                        </tr>
                                        <tr
                                            class="border-t transition-colors duration-200 border-slate-700/50 hover:bg-slate-700/30">
                                            <td class="px-4 py-4">
                                                {{ game.home_team.stats.rebounds }}
                                                <small class="mr-2 text-sm text-gray-400">
                                                    (DEF:
                                                    {{ game.home_team.stats.defensive_rebounds }}
                                                    / OFF:
                                                    {{ game.home_team.stats.offensive_rebounds }})
                                                </small>
                                            </td>
                                            <td class="px-4 py-4 text-center text-cyan-300">REB</td>
                                            <td class="px-4 py-4 text-right">
                                                {{ game.away_team.stats.rebounds }}
                                                <small class="ml-2 text-sm text-gray-400">
                                                    (DEF:
                                                    {{ game.away_team.stats.defensive_rebounds }}
                                                    / OFF:
                                                    {{ game.away_team.stats.offensive_rebounds }})
                                                </small>
                                            </td>
                                        </tr>
                                        <tr
                                            class="border-t transition-colors duration-200 border-slate-700/50 hover:bg-slate-700/30">
                                            <td class="px-4 py-4">
                                                {{ game.home_team.stats.steals }}
                                            </td>
                                            <td class="px-4 py-4 text-center text-cyan-300">STL</td>
                                            <td class="px-4 py-4 text-right">
                                                {{ game.away_team.stats.steals }}
                                            </td>
                                        </tr>
                                        <tr
                                            class="border-t transition-colors duration-200 border-slate-700/50 hover:bg-slate-700/30">
                                            <td class="px-4 py-4">
                                                {{ game.home_team.stats.blocks }}
                                            </td>
                                            <td class="px-4 py-4 text-center text-cyan-300">BLK</td>
                                            <td class="px-4 py-4 text-right">
                                                {{ game.away_team.stats.blocks }}
                                            </td>
                                        </tr>
                                        <tr
                                            class="border-t transition-colors duration-200 border-slate-700/50 hover:bg-slate-700/30">
                                            <td class="px-4 py-4">
                                                {{ game.home_team.stats.turnovers }}
                                            </td>
                                            <td class="px-4 py-4 text-center text-cyan-300">TO</td>
                                            <td class="px-4 py-4 text-right">
                                                {{ game.away_team.stats.turnovers }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
