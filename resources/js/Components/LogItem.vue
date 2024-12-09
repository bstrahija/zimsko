<script setup>
import { reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import IconAssist from './Icons/IconAssist.vue';
import IconBlock from './Icons/IconBlock.vue';
import IconFoul from './Icons/IconFoul.vue';
import IconMiss from './Icons/IconMiss.vue';
import IconRebound from './Icons/IconRebound.vue';
import IconScore from './Icons/IconScore.vue';
import IconSteal from './Icons/IconSteal.vue';
import IconSubstitution from './Icons/IconSubstitution.vue';
import IconTimeout from './Icons/IconTimeout.vue';
import IconTurnover from './Icons/IconTurnover.vue';
import IconArrow from './Icons/IconArrow.vue';

const props = defineProps({
    log: {
        type: Object,
        required: true,
    },
    game: {
        type: Object,
        required: true,
    },
});

const { log } = toRefs(props);

const remove = () => {
    console.log(log.value);

    if (!confirm('Da li ste sigurni?')) return;

    router.delete('live/log/' + log.value.id);
};
</script>

<template>
    <div
        class="relative p-3 text-gray-200 rounded border shadow scroll-p-3 bg-emerald-800/30 border-emerald-500/50 log-item">
        <div class="absolute right-1 top-3 text-xs text-slate-400">
            <button @click="remove">
                <IconMiss
                    class="inline mr-1 w-5 h-5 text-gray-300 opacity-30 transition-all duration-200 hover:text-rose-500 hover:opacity-100" />
            </button>
        </div>

        <h3 class="flex gap-2 items-center pb-2 mb-2 text-sm uppercase border-b border-emerald-500/50 font-oswald">
            <IconArrow class="inline mr-1 h-6 text-emerald-500" v-if="log.type === 'game_initialized'" />
            <IconArrow class="inline mr-1 h-6 text-emerald-500" v-if="log.type === 'game_starting_players'" />
            <IconArrow class="inline mr-1 h-6 text-emerald-500" v-if="log.type === 'game_started'" />
            <IconArrow class="inline mr-1 h-6 text-emerald-500" v-if="log.type === 'period_started'" />
            <IconScore class="inline mr-1 h-6 text-emerald-500"
                v-if="log.type === 'player_score' || log.type === 'player_score_with_assist'" />
            <IconMiss class="inline mr-1 h-6 text-rose-500" v-if="log.type === 'player_miss'" />
            <IconAssist class="inline mr-1 h-6 text-slate-600" v-if="log.type === 'player_assist'" />
            <IconSubstitution class="inline mr-1 h-6 text-sky-600" v-if="log.type === 'substitution'" />
            <IconTimeout class="inline mr-1 h-6 text-sky-600" v-if="log.type === 'timeout'" />
            <IconBlock class="inline mr-1 h-6 text-amber-600" v-if="log.type === 'player_block'" />
            <IconTurnover class="inline mr-1 h-6 text-rose-600" v-if="log.type === 'player_turnover'" />
            <IconFoul class="inline mr-1 h-6 text-red-600" v-if="log.type === 'player_foul' && log.subtype === 'pf'" />
            <IconSteal class="inline mr-1 h-6" v-if="log.type === 'player_steal'" />
            <IconRebound class="inline mr-1 h-6" v-if="log.type === 'player_rebound'" />
            {{ log.period }}.
            {{ (log.period <= 4 ? 'Četvrtina' : 'Produžetak') }} &mdash; {{ log.home_score }}:{{ log.away_score }}
                </h3>

                <div class="text-xs text-gray-300">
                    <div v-if="log.type === 'game_starting_players'">
                        {{ log.message }}
                        <hr class="my-3" />
                        <strong>{{ game.home_team.title }}:</strong>
                        <ul>
                            <li v-for="player in game.home_starting_players" class="my-1">
                                <span
                                    class="inline-block px-1 mr-1 w-7 font-bold text-center text-white rounded bg-slate-400">{{
                                        player.number }}</span>
                                {{ player.name }}
                            </li>
                        </ul>
                        <hr class="my-3" />
                        <strong>{{ game.away_team.title }}:</strong>
                        <ul>
                            <li v-for="player in game.away_starting_players" class="my-1">
                                <span
                                    class="inline-block px-1 mr-1 w-7 font-bold text-center text-white rounded bg-slate-400">{{
                                        player.number }}</span>
                                {{ player.name }}
                            </li>
                        </ul>
                    </div>

                    <div v-else>
                        <p>
                            {{ log.message }}
                        </p>
                    </div>
                </div>
    </div>
</template>
