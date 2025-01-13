<script setup>
import { reactive, ref, toRefs } from 'vue';
import { router } from '@inertiajs/vue3';
import PlayerBlock from '../PlayerBlock.vue';
import { $vfm } from 'vue-final-modal';

const props = defineProps({
    team: {
        type: Object,
        required: true,
    },
    players: {
        type: Array,
        required: true,
    },
    game: {
        type: Object,
        required: true,
    },
});

const { game } = toRefs(props);

const data = reactive({
    gameId: null,
});

const save = async function () {
    await router.post('/live/' + props.game.game_id + '/timeout', {
        'team_id': props.team.id
    });

    $vfm.hideAll();
};

const canBeSaved = function () {
    return true;
}
</script>

<template>
    <vue-final-modal v-bind="$attrs" v-slot="{ close }" :esc-to-close="true" :click-to-close="true">
        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>TIMEOUT?</h3>
                        <button @click="close" class="close">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-8 py-10 min-w-[400px] modal-body">
                        <div class="flex justify-center p-6">
                            <button :disabled="!canBeSaved()" :class="{ 'opacity-50': !canBeSaved(), 'pointer-events-none': !canBeSaved() }" @click="save"
                                class="flex justify-center items-center py-5 space-x-2 w-full text-sm transition-transform duration-300 btn btn-secondary hover:scale-105">
                                <span>TIMEOUT</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
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
