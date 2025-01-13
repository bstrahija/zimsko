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
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <button @click="$live.addFoul(game, team)" class="grid grid-cols-2 items-center px-2 py-2 space-y-1 text-center rounded md:grid-cols-1 foul-timeout-btn">
            <div class="text-3xs sm:text-2xs">PREKRŠAJI</div>
            <div class="text-xs font-bold sm:text-lg lg:text-2xl">{{ team.stats.current_period_fouls }}</div>
        </button>
        <button @click="$live.addTimeout(game, team)" class="grid grid-cols-2 items-center px-2 py-2 space-y-1 text-center rounded md:grid-cols-1 foul-timeout-btn">
            <div class="text-3xs sm:text-2xs">TIMEOUT</div>
            <div class="text-xs font-bold sm:text-lg lg:text-2xl">{{ team.stats.current_period_timeouts }}</div>
        </button>
        <div class="grid grid-cols-2 items-center px-2 py-2 space-y-1 text-center rounded md:grid-cols-1 foul-timeout-btn">
            <div class="text-3xs sm:text-2xs">BONUS</div>
            <div class="text-xs font-bold text-pink-500 sm:text-lg lg:text-2xl" v-if="team.stats.current_period_fouls >= 5">✓</div>
            <div class="text-xs font-bold sm:text-lg lg:text-2xl" v-else>-</div>
        </div>
    </div>
</template>
