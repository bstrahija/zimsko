<script setup>
import { router } from '@inertiajs/vue3';
import { toRefs } from 'vue';
import { $vfm } from 'vue-final-modal';
import StatsModal from './Modals/StatsModal.vue';

const props = defineProps({
    game: {
        type: Object,
        required: true,
    },
    log: {
        type: Array,
        required: true,
    },
});

const { game, log } = toRefs(props);

const nextPeriod = async function () {
    if (confirm('Da li ste sigurni da želite zavrsiti period?')) {
        await router.put('/live/' + props.game.id + '/next-period');

        $vfm.hideAll();
    }
}

const startGame = async function () {
    if (confirm('Da li ste sigurni da želite započeti utakmicu?')) {
        let response = await router.put('/live/' + props.game.id + '/start');
        console.log(response);

        $vfm.hideAll();
    }
}

const endGame = async function () {
    if (confirm('Da li ste sigurni da želite zavrsiti utakmicu?')) {
        await router.put('/live/' + props.game.id + '/end');

        $vfm.hideAll();
    }
}

function backToPlayers() {
    router.visit('/live/' + props.game.id + '/starting-players');
}

const showStats = function () {
    $vfm.show({ component: StatsModal, bind: { game: props.game } });
}
</script>

<template>
    <div class="grid gap-2">
        <button class="btn btn-secondary text-3xs md:text-2xs xl:text-xs" @click="nextPeriod" v-if="game.status === 'in_progress'">
            Slijedeći period
        </button>

        <button class="btn btn-error text-3xs md:text-2xs xl:text-xs" @click="endGame" v-if="game.status === 'in_progress'">
            Završi utakmicu
        </button>

        <button class="btn btn-secondary text-3xs md:text-2xs xl:text-xs" @click="startGame" v-if="game.status !== 'in_progress' && game.status !== 'ended'">
            Započni utakmicu
        </button>

        <button class="btn btn-error text-3xs md:text-2xs xl:text-xs" @click="backToPlayers" v-if="game.status !== 'in_progress' && game.status !== 'ended'">
            Natrag
        </button>

        <button class="btn btn-primary text-3xs md:text-2xs xl:text-xs" @click="showStats" v-if="game.status !== 'scheduled'">
            Statistika
        </button>
    </div>
</template>
