<script setup>
import { onMounted, reactive, watch } from 'vue';
import Layout from './Layout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import LiveTopBar from '../Components/LiveTopBar.vue';

let props = defineProps({
    game: Object,
    events: Array,
    referees: Array,
    currentEvent: Object,
});

let selectedEvent = reactive({})
const form = reactive({
    saving: false,
    homeTeamId: '',
    awayTeamId: '',
    title: '',
    eventId: '',
    roundId: '',
    refereeId1: '',
    refereeId2: '',
    scheduledAt: '',
})

onMounted(() => {
    let eventId = props.game.event_id ? props.game.event_id : props.currentEvent.id

    // Set the event
    form.eventId = eventId ? eventId : ''

    // Fill the rest of the data
    form.title = props.game.title
    form.roundId = props.game.round_id ? props.game.round_id : ''
    form.homeTeamId = props.game.home_team_id ? props.game.home_team_id : ""
    form.awayTeamId = props.game.away_team_id ? props.game.away_team_id : ""
    form.scheduledAt = props.game.scheduled_at

    // Add referees
    props.game?.referees?.forEach((referee, index) => {
        if (index < 2) form[`refereeId${index + 1}`] = referee?.id;
    });
})

function findEventById(id) {
    return props.events.find(event => event.id == id);
}

function findTeamById(id) {
    return selectedEvent.teams.find(team => team.id == id);
}

function updateEvent() {
    // Reset  the round
    form.roundId = ''

    updateTitle()
}

function updateTitle() {
    let title = ''
    let homeTeam = findTeamById(form.homeTeamId);
    let awayTeam = findTeamById(form.awayTeamId);
    let round = selectedEvent.rounds.find(round => round.id == form.roundId);

    // Add round to title
    if (round) {
        title += round.title + ' | ';
    }

    // Add teams to title
    title += (homeTeam ? homeTeam.title : '?')
        + ' - ' +
        (awayTeam ? awayTeam.title : '?');

    form.title = title

}

watch(form, async (newForm, oldForm) => {
    selectedEvent = findEventById(newForm.eventId);
})

function canContinue() {
    if (form.homeTeamId && form.awayTeamId && form.roundId && form.title && form.scheduledAt && !form.saving) {
        return true
    }

    return false
}

const save = async function () {
    form.saving = true
    await router.post('/live/' + props.game.id + '/details', form);
    form.saving = false
};
</script>

<template>
    <Layout>

        <Head title="Zimsko Live Score - Nova Utakmica" />

        <div class="flex relative min-h-screen">
            <div class="space-y-2 w-full max-w-[1920px] mx-auto">
                <div class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] grid-bg w-full create-live-game">
                    <LiveTopBar :title="form.title" :backUrl="'/live'" />

                    <form @submit.prevent="save" class="space-y-6 transition-all" :class="{ 'opacity-50': form.saving }">
                        <!-- Event Selection -->
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="home-team" class="block text-sm font-medium text-gray-200">Turnir</label>
                                <select id="home-team" v-model="form.eventId" @change="updateEvent"
                                    class="w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200">
                                    <option value="" disabled>Odaberi turnir</option>
                                    <option v-for="event in events" :key="'event-' + event.id" :value="event.id">
                                        {{ event.title }}
                                    </option>
                                </select>
                            </div>

                            <div class="space-y-2" v-if="selectedEvent">
                                <label for="home-team" class="block text-sm font-medium text-gray-200">Kolo</label>
                                <select id="home-team" v-model="form.roundId" @change="updateTitle"
                                    class="w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200">
                                    <option value="" disabled>Odaberi kolo</option>
                                    <option v-for="round in selectedEvent.rounds" :key="'round-' + round.id" :value="round.id">
                                        {{ round.title }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Teams Selection Grid -->
                        <div class="grid grid-cols-2 gap-6" v-if="selectedEvent">
                            <!-- Home Team -->
                            <div class="space-y-2">
                                <label for="home-team" class="block text-sm font-medium text-gray-200">Ekipa 1</label>
                                <select id="home-team" v-model="form.homeTeamId" @change="updateTitle"
                                    class="w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200">
                                    <option value="">Odaberi ekipu</option>
                                    <option v-for="team in selectedEvent.teams" :key="team.id" :value="team.id">
                                        {{ team.title }}
                                    </option>
                                </select>
                            </div>

                            <!-- Away Team -->
                            <div class="space-y-2">
                                <label for="away-team" class="block text-sm font-medium text-gray-200">Ekipa 2</label>
                                <select id="away-team" v-model="form.awayTeamId" @change="updateTitle"
                                    class="w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200">
                                    <option value="">Odaberi ekipu</option>
                                    <option v-for="team in selectedEvent.teams" :key="team.id" :value="team.id">
                                        {{ team.title }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Additional Game Details -->
                        <div class="space-y-4" v-if="selectedEvent">
                            <!-- Game Title -->
                            <div>
                                <label for="game-title" class="block text-sm font-medium text-gray-200">Naslov</label>
                                <input type="text" id="game-title" v-model="form.title"
                                    class="mt-1 w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200"
                                    placeholder="Enter game title" />
                            </div>

                            <div class="grid grid-cols-2 gap-6" v-if="selectedEvent">
                                <!-- Home Team -->
                                <div class="space-y-2">
                                    <label for="referee1" class="block text-sm font-medium text-gray-200">Sudac 1</label>
                                    <select id="referee1" v-model="form.refereeId1"
                                        class="w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200">
                                        <option value="">Odaberi suca</option>
                                        <option v-for="referee in referees" :key="referee.id" :value="referee.id">
                                            {{ referee.name }}
                                        </option>
                                    </select>
                                </div>

                                <!-- Away Team -->
                                <div class="space-y-2">
                                    <label for="referee2" class="block text-sm font-medium text-gray-200">Sudac 2</label>
                                    <select id="referee2" v-model="form.refereeId2"
                                        class="w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200">
                                        <option value="">Odaberi suca</option>
                                        <option v-for="referee in referees" :key="referee.id" :value="referee.id">
                                            {{ referee.first_name }} {{ referee.last_name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Scheduled Date -->
                            <div>
                                <label for="scheduled-at" class="block text-sm font-medium text-gray-200">Datum i vrijeme utakmice</label>
                                <input type="datetime-local" id="scheduled-at" v-model="form.scheduledAt"
                                    class="mt-1 w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200" />
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" :disabled="!canContinue()" :class="{ 'opacity-50': !canContinue() }"
                                class="px-6 py-3 text-white bg-cyan-600 rounded-lg hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-gray-900 shadow-[0_0_15px_rgba(34,211,238,0.3)] hover:shadow-[0_0_20px_rgba(34,211,238,0.4)] transition-all duration-200">
                                Dalje
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>
