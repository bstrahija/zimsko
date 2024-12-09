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
        await router.post('/live/' + game.value.game_id + '/next-period');

        $vfm.hideAll();
    }
}

const startGame = async function () {
    if (confirm('Da li ste sigurni da želite započeti utakmicu?')) {
        let response = await router.post('/live/' + game.value.game_id + '/start-game');
        console.log(response);

        $vfm.hideAll();
    }
}

const endGame = async function () {
    if (confirm('Da li ste sigurni da želite zavrsiti utakmicu?')) {
        await router.post('/live/' + game.value.game_id + '/end-game');

        $vfm.hideAll();
    }
}

const showStats = function () {
    $vfm.show({ component: StatsModal, bind: { game: game, log: log } });
}
</script>

<template>
    <div class="grid gap-2">
        <button class="btn btn-secondary" @click="nextPeriod" v-if="game.status === 'started'">Slijedeći period</button>
        <button class="btn btn-error" @click="endGame" v-if="game.status === 'started'">
            Završi utakmicu
        </button>
        <button class="btn btn-secondary" @click="startGame"
            v-if="game.status !== 'started' && game.status !== 'ended'">
            Započni utakmicu
        </button>
        <button class="btn btn-primary" @click="showStats" v-if="game.status !== 'pending'">Statistika</button>
    </div>
</template>
