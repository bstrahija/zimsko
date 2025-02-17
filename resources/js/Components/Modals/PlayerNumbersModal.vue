<script setup>
import { reactive, ref, toRefs } from 'vue';
import CloseButton from './CloseButton.vue';
import { $vfm } from 'vue-final-modal';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    game: {
        type: Object,
        required: true,
    },
});

const { game } = toRefs(props);

const data = reactive({});

const save = async () => {
    let homePlayers = props.game.home_players
        .filter(player => player.number !== null)
        .map(player => ({ id: player.id, number: player.pivot.number }));
    let awayPlayers = props.game.away_players
        .filter(player => player.number !== null)
        .map(player => ({ id: player.id, number: player.pivot.number }));
    let data = {
        home_team_id: props.game.home_team_id,
        away_team_id: props.game.away_team_id,
        home_players: homePlayers,
        away_players: awayPlayers,
    }

    await router.put('/live/' + props.game.id + '/player-numbers', data);
    window.location.reload();
    $vfm.hideAll();
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog max-w-[800px] w-full" style="min-width: 300px; max-width: 1200px;">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="grid">
                            <div class="grid relative">
                                <CloseButton @click="close" />

                                <div class="grid grid-cols-[1fr_auto_1fr] gap-8 px-6 pt-16 pb-6">
                                    <div class="space-y-4">
                                        <div v-for="player in game.home_players" :key="player.id" class="flex items-center space-x-3">
                                            <input type="text" v-model="player.pivot.number"
                                                class="w-16 h-12 text-lg font-bold text-center rounded-lg border-2 border-cyan-400 bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-500" />
                                            <span class="text-lg font-semibold text-cyan-300">{{ player.name }}</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col justify-center">
                                        <button class="text-lg btn btn-primary" @click="save">
                                            SPREMI
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        <div v-for="player in game.away_players" :key="player.id" class="flex justify-end items-center space-x-3">
                                            <span class="text-lg font-semibold text-cyan-300">{{ player.name }}</span>
                                            <input type="text" v-model="player.pivot.number"
                                                class="w-16 h-12 text-lg font-bold text-center rounded-lg border-2 border-cyan-400 bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-500" />
                                        </div>
                                    </div>
                                </div>
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
