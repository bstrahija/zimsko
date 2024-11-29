<script setup>
import IconAssist from './Icons/IconAssist.vue';
import IconBlock from './Icons/IconBlock.vue';
import IconFoul from './Icons/IconFoul.vue';
import IconMiss from './Icons/IconMiss.vue';
import IconRebound from './Icons/IconRebound.vue';
import IconScore from './Icons/IconScore.vue';
import IconSubstitution from './Icons/IconSubstitution.vue';
import IconTimeout from './Icons/IconTimeout.vue';
import IconTurnover from './Icons/IconTurnover.vue';

defineProps({
    log: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="p-3 rounded-sm shadow bg-slate-50">
        <h3 class="pb-2 mb-2 uppercase border-b border-gray-200 text-medium font-oswald">
            <IconScore class="inline mr-1 h-6 text-emerald-500" v-if="log.type === 'player_score' || log.type === 'player_score_with_assist'" />
            <IconMiss class="inline mr-1 h-6 text-rose-500" v-if="log.type === 'player_miss'" />
            <IconAssist class="inline mr-1 h-6 text-slate-600" v-if="log.type === 'player_assist'" />
            <IconSubstitution class="inline mr-1 h-6 text-slate-600" v-if="log.type === 'substitution'" />
            <IconTimeout class="inline mr-1 h-6 text-sky-600" v-if="log.type === 'timeout'" />
            <IconBlock class="inline mr-1 h-6 text-amber-600" v-if="log.type === 'player_block'" />
            <IconTurnover class="inline mr-1 h-6 text-rose-600" v-if="log.type === 'player_turnover'" />
            <IconFoul class="inline mr-1 h-6 text-red-600" v-if="log.type === 'player_foul' && log.subtype === 'pf'" />
            <IconSteal class="inline mr-1 h-6" v-if="log.type === 'player_steal'" />
            <IconRebound class="inline mr-1 h-6" v-if="log.type === 'player_rebound'" />
            {{ log.quarter }}. četvrtina
        </h3>

        <p class="text-sm">
            {{ log.message }}
        </p>
    </div>
</template>
