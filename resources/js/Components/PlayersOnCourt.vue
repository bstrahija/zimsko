<script setup>
import { inject, toRefs, ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import PlayerBlock from './PlayerBlock.vue';
import IconScore from './Icons/IconScore.vue';
import IconSubstitution from './Icons/IconSubstitution.vue';
import IconRebound from './Icons/IconRebound.vue';
import IconSteal from './Icons/IconSteal.vue';
import IconAssist from './Icons/IconAssist.vue';
import IconFoul from './Icons/IconFoul.vue';
import IconTurnover from './Icons/IconTurnover.vue';
import IconBlock from './Icons/IconBlock.vue';

const props = defineProps({
    game: { type: Object, required: true },
    team: { type: Object, required: true },
    players: { type: Array, required: true },
});

const { game, team, players } = toRefs(props);
const helpers = inject('helpers');

const activePlayer = ref(null);

const toggleIcons = (player, event) => {
    event.stopPropagation();

    if (props.game.status !== 'in_progress') {
        alert('Započnite utakmicu da bi upisivali statistiku!');
        return;
    }

    activePlayer.value = activePlayer.value === player ? null : player;
};

const hideIcons = () => {
    activePlayer.value = null;
};

const handleKeyDown = (event) => {
    if (event.key === 'Escape') {
        hideIcons();
    }
};

onMounted(() => {
    document.addEventListener('click', hideIcons);
    document.addEventListener('keydown', handleKeyDown);
});

onUnmounted(() => {
    document.removeEventListener('click', hideIcons);
    document.removeEventListener('keydown', handleKeyDown);
});

const addStat = (stat, type) => {
    console.log(stat, type, activePlayer.value.id)

    if (props.game.status !== 'in_progress') {
        alert('Započnite utakmicu da bi upisivali statistiku!');
        return;
    }

    if (stat !== 'substitution') {
        let data = {
            selectedPlayer: activePlayer.value,
            action: stat,
            type: type
        }
        router.post('/live/' + props.game.id + '/multi', data);
        console.log(data)
    } else {
        helpers.addSubstitution(props.game, props.team, activePlayer.value);
    }

    hideIcons();
}
</script>

<template>
    <div class="grid grid-cols-2 gap-2 text-3xl font-bold text-white sm:grid-cols-3 lg:grid-cols-5 players-on-court min-h-10">
        <!-- <div class="action-wheel-overlay" v-if="activePlayer">123</div> -->

        <div class="relative aspect-square action-box-container" v-for="player in players" :key="player.id"
            :class="{ 'active-with-action-box': activePlayer === player, 'inactive-with-action-box': activePlayer !== player }">

            <div class="action-box" v-if="activePlayer === player" :class="{ 'active': activePlayer === player }">
                <div class="absolute -top-[22px] py-1 w-full text-center text-white bg-cyan-500/90 text-3xs">
                    #{{ player.number }} {{ player.name }}
                </div>

                <div class="grid grid-cols-3">
                    <button class="py-3 hover:bg-green-500 bg-green-500/70" @click="addStat('score', 1)">
                        <strong>1</strong>
                    </button>

                    <button class="py-3 hover:bg-green-500 bg-green-500/70" @click="addStat('score', 2)">
                        <strong>2</strong>
                    </button>

                    <button class="py-3 hover:bg-green-500 bg-green-500/70" @click="addStat('score', 3)">
                        <strong>3</strong>
                    </button>
                </div>

                <div class="grid grid-cols-3">
                    <button class="py-2 smaller hover:bg-rose-500 bg-rose-500/70" @click="addStat('miss', 1)">
                        <strong>1</strong>
                    </button>

                    <button class="py-2 smaller hover:bg-rose-500 bg-rose-500/70" @click="addStat('miss', 2)">
                        <strong>2</strong>
                    </button>

                    <button class="py-2 smaller hover:bg-rose-500 bg-rose-500/70" @click="addStat('miss', 3)">
                        <strong>3</strong>
                    </button>
                </div>

                <div class="grid grid-cols-3">
                    <button class="py-2 action-pos-8 hover:bg-green-500 bg-green-500/70" @click="addStat('assist')">
                        <IconAssist />
                        <small>AST</small>
                    </button>

                    <button class="py-2 action-pos-inner-5 hover:bg-purple-500 bg-purple-500/70" @click="addStat('block')">
                        <IconBlock />
                        <small>BLK</small>
                    </button>

                    <button class="py-2 action-pos-9 hover:bg-green-500 bg-green-500/70" @click="addStat('steal')">
                        <IconSteal />
                        <small>STL</small>
                    </button>
                </div>

                <div class="grid grid-cols-3">
                    <button class="py-2 action-pos-4 hover:bg-purple-500 bg-purple-500/70" @click="addStat('rebound', 'def')">
                        <IconRebound />
                        <small>DREB</small>
                    </button>

                    <button class="py-2 action-pos-inner-4 hover:bg-sky-500 bg-sky-500/70" @click="addStat('substitution')">
                        <IconSubstitution />
                        <small>SUB</small>
                    </button>

                    <button class="py-2 action-pos-5 hover:bg-amber-500 bg-amber-500/70" @click="addStat('rebound', 'off')">
                        <IconRebound />
                        <small>OREB</small>
                    </button>
                </div>


                <div class="grid grid-cols-2 bg-black">
                    <button class="py-2 action-pos-6 hover:bg-rose-500 bg-rose-500/70" @click="addStat('turnover')">
                        <IconTurnover />
                        <small>TO</small>
                    </button>

                    <button class="py-2 action-pos-7 hover:bg-rose-500 bg-rose-500/70" @click="addStat('foul')">
                        <IconFoul />
                        <small>FOUL</small>
                    </button>
                </div>

            </div>

            <PlayerBlock :player="player" @click="(event) => toggleIcons(player, event)" class="relative z-20" />
        </div>
    </div>
</template>
