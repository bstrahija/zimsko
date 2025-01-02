<script setup>
import { ref } from 'vue'
import Layout from './Layout.vue';
import { Head } from '@inertiajs/vue3'

const teams = ref([
    { id: 1, name: 'Team 1' },
    { id: 2, name: 'Team 2' },
    // Add more teams as needed
])

const events = ref([
    { id: 1, name: 'Event 1' },
    { id: 2, name: 'Event 2' },
    // Add more events as needed
])

const form = ref({
    homeTeamId: '',
    awayTeamId: '',
    title: '',
    eventId: '',
    referees: '',
    scheduledAt: '',
})
</script>

<template>
    <Layout>

        <Head title="Zimsko Live Score - Nova Utakmica" />

        <div class="flex relative min-h-screen">
            <div class="space-y-2 w-full max-w-[1920px] mx-auto">
                <div class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] grid-bg w-full create-live-game">
                    <form @submit.prevent="submitForm" class="space-y-6">
                        <div class="grid gap-4 mb-4 score-top" style="grid-template-columns: 1fr 160px 1fr">
                            <div class="space-y-4 home-team-top">
                                <ScoreBar :score="game.home_score" :team="game.home_team" :side="'home'" />
                            </div>

                            <div class="grid text-center rounded bg-slate-800/40">
                                <Pretty />
                            </div>

                            <div class="space-y-4 away-team-top">
                                <ScoreBar :score="game.away_score" :team="game.away_team" :side="'away'" />
                            </div>
                        </div>

                        <!-- Teams Selection Grid -->
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Home Team -->
                            <div class="space-y-2">
                                <label for="home-team" class="block text-sm font-medium text-gray-200">Home Team</label>
                                <select id="home-team" v-model="form.homeTeamId"
                                    class="w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200">
                                    <option value="">Select Home Team</option>
                                    <option v-for="team in teams" :key="team.id" :value="team.id">
                                        {{ team.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Away Team -->
                            <div class="space-y-2">
                                <label for="away-team" class="block text-sm font-medium text-gray-200">Away Team</label>
                                <select id="away-team" v-model="form.awayTeamId"
                                    class="w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200">
                                    <option value="">Select Away Team</option>
                                    <option v-for="team in teams" :key="team.id" :value="team.id">
                                        {{ team.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Additional Game Details -->
                        <div class="space-y-4">
                            <!-- Game Title -->
                            <div>
                                <label for="game-title" class="block text-sm font-medium text-gray-200">Game Title</label>
                                <input type="text" id="game-title" v-model="form.title"
                                    class="mt-1 w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200"
                                    placeholder="Enter game title" />
                            </div>

                            <!-- Event Selection -->
                            <div>
                                <label for="event" class="block text-sm font-medium text-gray-200">Event</label>
                                <select id="event" v-model="form.eventId"
                                    class="mt-1 w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200">
                                    <option value="">Select Event</option>
                                    <option v-for="event in events" :key="event.id" :value="event.id">
                                        {{ event.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Referees -->
                            <div>
                                <label for="referees" class="block text-sm font-medium text-gray-200">Referees</label>
                                <input type="text" id="referees" v-model="form.referees"
                                    class="mt-1 w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200"
                                    placeholder="Enter referees" />
                            </div>

                            <!-- Scheduled Date -->
                            <div>
                                <label for="scheduled-at" class="block text-sm font-medium text-gray-200">Scheduled Date</label>
                                <input type="datetime-local" id="scheduled-at" v-model="form.scheduledAt"
                                    class="mt-1 w-full px-4 py-3 text-gray-200 bg-gray-800/80 rounded-lg border border-cyan-500/20 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.1)] hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all duration-200" />
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-3 text-white bg-cyan-600 rounded-lg hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-gray-900 shadow-[0_0_15px_rgba(34,211,238,0.3)] hover:shadow-[0_0_20px_rgba(34,211,238,0.4)] transition-all duration-200">
                                Create Game
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>
