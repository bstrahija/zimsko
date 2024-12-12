<script setup>
import { toRefs } from 'vue';

const props = defineProps({
    players: {
        type: Array,
        required: true
    },
    type: {
        type: String,
        required: true,
        default: 'points',
    }
});

const { players, type } = toRefs(props);

let playerCount = 12;

const getSortedPlayers = () => {
    if (type.value === 'score') {
        return players.value.sort((a, b) => {
            return (b.stats?.score || 0) - (a.stats?.score || 0);
        }).slice(0, playerCount);
    }

    if (type.value === 'three_points') {
        return players.value
            .filter(player => player.stats?.three_points > 0)
            .sort((a, b) => {
                return (b.stats?.three_points_made || 0) - (a.stats?.three_points_made || 0);
            })
            .slice(0, playerCount);
    }

    if (type.value === 'assists') {
        return players.value.sort((a, b) => {
            return (b.stats?.assists || 0) - (a.stats?.assists || 0);
        }).slice(0, playerCount);
    }

    if (type.value === 'steals') {
        return players.value.sort((a, b) => {
            return (b.stats?.steals || 0) - (a.stats?.steals || 0);
        }).slice(0, playerCount);
    }

    if (type.value === 'rebounds') {
        return players.value.sort((a, b) => {
            return (b.stats?.rebounds || 0) - (a.stats?.rebounds || 0);
        }).slice(0, playerCount);
    }

    if (type.value === 'blocks') {
        return players.value.sort((a, b) => {
            return (b.stats?.blocks || 0) - (a.stats?.blocks || 0);
        }).slice(0, playerCount);
    }

    if (type.value === 'turnovers') {
        return players.value.sort((a, b) => {
            return (b.stats?.turnovers || 0) - (a.stats?.turnovers || 0);
        }).slice(0, playerCount);
    }

    if (type.value === 'fouls') {
        return players.value.sort((a, b) => {
            return (b.stats?.fouls || 0) - (a.stats?.fouls || 0);
        }).slice(0, playerCount);
    }

    if (type.value === 'efficiency') {
        return players.value.sort((a, b) => {
            return (b.stats?.efficiency || 0) - (a.stats?.efficiency || 0);
        }).slice(0, playerCount);
    }


    return players.value.slice(0, 12);
};
</script>

<template>
    <div>
        <table class="overflow-hidden w-full text-sm text-gray-300 rounded-lg border shadow-lg bg-slate-800/60 border-cyan-400/30">
            <thead>
                <tr class="bg-slate-700/50">
                    <th class="px-4 py-3 text-xl font-bold text-left text-cyan-400 w-[1%]">#</th>
                    <th class="px-4 py-3 text-xl font-bold text-left text-cyan-400 w-[70%]">Igrač</th>

                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'score'">Q1</th>
                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'score'">Q2</th>
                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'score'">Q3</th>
                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'score'">Q4</th>
                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'score'">Poena</th>
                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'score'">Postotak</th>

                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'rebounds'">Skokovi</th>
                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'rebounds'">Obrana</th>
                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'rebounds'">Napad</th>

                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'three_points'">Trice</th>
                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'three_points'">%</th>

                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'assists'">Asistencije</th>

                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'steals'">Ukradene</th>

                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'blocks'">Blokade</th>

                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'turnovers'">Izgubljene</th>

                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'fouls'">Tehničke</th>
                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'fouls'">Prekršaji</th>

                    <th class="px-4 py-3 text-xl font-bold text-right text-cyan-400 w-[29%]" v-if="type === 'efficiency'">Efikasnost</th>
                </tr>
            </thead>
            <tbody class="text-[14px]">
                <tr v-for="player in getSortedPlayers()" :key="player.id" class="border-t transition-colors duration-200 border-slate-700/50 hover:bg-slate-700/30">
                    <td class="px-4 py-4 w-1" width="1%">{{ player.number }}</td>
                    <td class="px-4 py-4">
                        <div class="flex gap-3 items-center">
                            <div v-if="player?.data?.photo" class="overflow-hidden mt-2 w-8 rounded-full opacity-60 aspect-square">
                                <img :src="player.data.photo" alt="">
                            </div>
                            <div v-else>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-8 h-8 opacity-50">
                                    <circle cx="12" cy="12" r="10" stroke="orange" stroke-width="2" fill="none" />
                                    <path d="M2 12a10 10 0 0 1 20 0" stroke="orange" />
                                    <path d="M12 2a10 10 0 0 0 0 20" stroke="orange" />
                                    <path d="M12 2c-3.333 4-3.333 10 0 12" stroke="orange" />
                                    <path d="M12 22c3.333-4 3.333-10 0-12" stroke="orange" />
                                </svg>
                            </div>
                            {{ player.name }}
                        </div>
                    </td>

                    <td class="px-4 py-4 text-sm font-bold text-right" v-if="type === 'score'">{{ player.stats.score_p1 || '-' }}</td>
                    <td class="px-4 py-4 text-sm font-bold text-right" v-if="type === 'score'">{{ player.stats.score_p2 || '-' }}</td>
                    <td class="px-4 py-4 text-sm font-bold text-right" v-if="type === 'score'">{{ player.stats.score_p3 || '-' }}</td>
                    <td class="px-4 py-4 text-sm font-bold text-right" v-if="type === 'score'">{{ player.stats.score_p4 || '-' }}</td>
                    <td class="px-4 py-4 text-lg font-bold text-right" v-if="type === 'score'">{{ player.stats.score || '-' }}</td>
                    <td class="px-4 py-4 text-sm text-lg text-right" v-if="type === 'score'">{{ player.stats.field_goals_percent }}%</td>

                    <td class="px-4 py-4 text-lg font-bold text-right" v-if="type === 'rebounds'">{{ player.stats.rebounds || '-' }}</td>
                    <td class="px-4 py-4 text-sm text-lg text-right" v-if="type === 'rebounds'">{{ player.stats.offensive_rebounds || '-' }}</td>
                    <td class="px-4 py-4 text-sm text-lg text-right" v-if="type === 'rebounds'">{{ player.stats.defensive_rebounds || '-' }}</td>

                    <td class="px-4 py-4 text-lg font-bold text-right" v-if="type === 'three_points'">{{ player.stats.three_points_made }}/{{ player.stats.three_points }}</td>
                    <td class="px-4 py-4 text-sm text-lg text-right" v-if="type === 'three_points'">{{ player.stats.three_points_percent }}%</td>

                    <td class="px-4 py-4 text-lg font-bold text-right" v-if="type === 'assists'">{{ player.stats.assists || '-' }}</td>

                    <td class="px-4 py-4 text-lg font-bold text-right" v-if="type === 'steals'">{{ player.stats.steals || '-' }}</td>

                    <td class="px-4 py-4 text-lg font-bold text-right" v-if="type === 'fouls'">{{ player.stats.technical_fouls || '-' }}</td>
                    <td class="px-4 py-4 text-lg font-bold text-right" :class="{ 'text-red-600': player.stats.fouls >= 5 }" v-if="type === 'fouls'">{{ player.stats.fouls || '-' }}
                    </td>

                    <td class="px-4 py-4 text-lg font-bold text-right" v-if="type === 'blocks'">{{ player.stats.blocks || '-' }}</td>

                    <td class="px-4 py-4 text-lg font-bold text-right" v-if="type === 'turnovers'">{{ player.stats.turnovers || '-' }}</td>

                    <td class="px-4 py-4 text-lg font-bold text-right" v-if="type === 'efficiency'">{{ player.stats.efficiency }}</td>
                </tr>
            </tbody>
        </table>

    </div>
</template>
