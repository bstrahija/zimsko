<script setup>
import { reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Layout from './Layout.vue';

let props = defineProps({
    games: Array,
    events: Array,
    teams: Array,
});

let data = reactive({
    query: '',
    event: "",
    team: "",
});

const filterResults = () => {
    let query = data.query;
    let event = data.event;
    let team = data.team;

    router.visit('live', {
        data: {
            query: query,
            event: event,
            team: team,
        },
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Layout>

        <Head title="Zimsko Live Score" />

        <div class="flex relative min-h-screen">
            <div class="space-y-2 w-full max-w-[1920px] mx-auto">
                <div class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] grid-bg w-full">

                    <div class="flex justify-between items-center mb-4">
                        <div class="relative w-64">
                            <input type="text" placeholder="Search games..." v-model="data.query" @change="filterResults()"
                                class="px-4 py-2 w-full text-gray-300 rounded-lg bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            <svg class="absolute top-2.5 right-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <div class="flex space-x-4">
                            <div class="relative">
                                <select v-model="data.event" @change="filterResults()"
                                    class="px-4 py-2 pr-8 text-gray-300 rounded-lg appearance-none bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                    <option value="">All Events</option>
                                    <option v-for="event in events" :key="event.id" :value="event.id">
                                        {{ event.title }}
                                    </option>
                                </select>
                                <svg class="absolute top-3 right-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <div class="relative">
                                <select v-model="data.team" @change="filterResults()"
                                    class="px-4 py-2 pr-8 text-gray-300 rounded-lg appearance-none bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                    <option value="">All Teams</option>
                                    <option v-for="team in teams" :key="team.id" :value="team.id">
                                        {{ team.title }}
                                    </option>
                                </select>
                                <svg class="absolute top-3 right-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>


                    <table class="overflow-hidden w-full text-sm rounded-lg shadow-md bg-slate-800">
                        <thead class="text-gray-300 bg-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left">Event</th>
                                <th class="px-4 py-3 text-left">Title</th>
                                <th class="px-4 py-3 text-left">Score</th>
                                <th class="px-4 py-3 text-left">Date</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="game in games" :key="game.id" class="border-b cursor-pointer border-slate-600 hover:bg-slate-700" @click="router.visit('live/' + game.id)">
                                <td class="px-4 py-3 text-gray-300">{{ game.event ? game.event.title : 'N/A' }}</td>
                                <td class="px-4 py-3 text-gray-300">{{ game.title }}</td>
                                <td class="px-4 py-3 text-gray-300">
                                    {{ game.home_score }} - {{ game.away_score }}
                                </td>
                                <td class="px-4 py-3 text-gray-300">{{ game.scheduled_at }}</td>
                                <td class="px-4 py-3 text-gray-300">{{ game.status }}</td>
                                <td class="px-4 py-3 text-center">
                                    <Link :href="'live/' + game.id" class="btn btn-primary">
                                    Live score
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </Layout>
</template>
