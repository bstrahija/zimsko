<script setup>
import { toRefs } from 'vue';
import { $vfm } from 'vue-final-modal';
import AddFoulModal from './Modals/AddFoulModal.vue';
import AddTimeoutModal from './Modals/AddTimeoutModal.vue';

const props = defineProps({
    game: {
        type: Object,
        required: true,
    },
    team: {
        type: Object,
        required: true,
    },
    side: {
        type: String,
        required: true,
    },
});

const { team, side } = toRefs(props);

const timeout = () => {
    $vfm.show({ component: AddTimeoutModal, bind: { team: team, players: players, game: game } });
};

const foul = () => {
    $vfm.show({ component: AddFoulModal, bind: { team: team, players: players, game: game } });
};
</script>

<template>
    <div class="grid grid-cols-3 gap-4">
        <button @click="$live.addFoul(game, team)" class="px-2 py-2 space-y-1 text-center rounded foul-timeout-btn">
            <div class="text-xs">PREKRŠAJI</div>
            <div class="text-2xl font-bold">{{ team.stats.current_period_fouls }}</div>
        </button>
        <button @click="$live.addTimeout(game, team)" class="px-2 py-2 space-y-1 text-center rounded foul-timeout-btn">
            <div class="text-xs">TIMEOUT</div>
            <div class="text-2xl font-bold">{{ team.stats.current_period_timeouts }}</div>
        </button>
        <div class="px-2 py-2 space-y-1 text-center rounded foul-timeout-btn">
            <div class="text-xs">BONUS</div>
            <div class="text-2xl font-bold text-pink-500" v-if="team.stats.current_period_fouls >= 5">✓</div>
            <div class="text-2xl font-bold" v-else>-</div>
        </div>
    </div>
</template>
