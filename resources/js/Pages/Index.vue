<script setup>
import { onMounted, reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Layout from './Layout.vue';

let props = defineProps({
    games: Array,
    events: Array,
    eventId: Number,
    teams: Array,
});

let data = reactive({
    saving: false,
    query: '',
    event: "",
    team: "",
});

onMounted(() => {
    data.event = props.events.find(event => event.id === props.eventId)?.id || "";
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

const scoreUrl = function (game) {
    let url = 'live/' + game.id + '/edit';

    if (game.status === 'in_progress') url = 'live/' + game.id + '/score';

    return url
}

const deleteGame = async function (game) {
    if (confirm('Da li ste sigurni da zelite obrisati ovu utakmicu?')) {
        data.saving = true
        await router.delete('/live/' + game.id);
        data.saving = false
    }
}

const generateStats = async function () {
    if (confirm('Da li ste sigurni da zelite generirati statistiku?')) {
        data.saving = true
        await router.post('/live/generate-stats');
        data.saving = false
    }
}

const goToGame = function (game) {
    if (game.status === 'in_progress') {
        router.visit('live/' + game.id + '/score', {
            preserveState: true,
            preserveScroll: true,
        })
    } else {
        router.visit('live/' + game.id + '/edit', {
            preserveState: true,
            preserveScroll: true,
        })
    }
}
</script>

<template>
    <Layout>

        <Head title="Zimsko Live Score - Utakmice" />

        <div class="flex relative min-h-screen">
            <div class="space-y-2 w-full max-w-[1920px] mx-auto">
                <div class="bg-slate-900/95 p-6 rounded-lg border-5 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] grid-bg w-full">
                    <div class="flex gap-8 justify-between items-center mb-4">
                        <div class="flex relative w-64">
                            <input type="text" placeholder="Pretraži utakmice..." v-model="data.query" @change="filterResults()"
                                class="px-4 py-2 w-full text-gray-300 rounded-lg bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            <svg class="absolute top-2.5 right-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <Link href="/live/create" class="flex justify-center items-center px-4 py-2 w-48 text-center rounded-lg btn-primary group">
                        <svg class="mr-2 w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nova Utakmica
                        </Link>

                        <div class="flex space-x-4">
                            <div class="relative">
                                <select v-model="data.event" @change="filterResults()"
                                    class="px-4 py-2 pr-8 text-gray-300 rounded-lg appearance-none bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                    <option value="">Svi turniri</option>
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
                                    <option value="">Sve ekipe</option>
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


                    <table class="overflow-hidden w-full text-sm rounded-lg shadow-md bg-slate-800" v-if="games.length > 0">
                        <thead class="text-gray-300 bg-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left">Turnir</th>
                                <th class="px-4 py-3 text-left">Naslov</th>
                                <th class="px-4 py-3 text-left">Rezultat</th>
                                <th class="px-4 py-3 text-left">Datum</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="game in games" :key="game.id" class="border-b cursor-pointer border-slate-600 hover:bg-slate-700">
                                <td class="px-4 py-3 text-gray-300" @click="goToGame(game)">{{ game.event ? game.event.title : 'N/A' }}</td>
                                <td class="px-4 py-3 text-gray-300" @click="goToGame(game)">{{ game.title }}</td>
                                <td class="px-4 py-3 text-gray-300" @click="goToGame(game)">
                                    {{ game.home_score }} - {{ game.away_score }}
                                </td>
                                <td class="px-4 py-3 text-gray-300" @click="goToGame(game)">{{ game.scheduled_at }}</td>
                                <td class="px-4 py-3 text-gray-300" @click="goToGame(game)">
                                    <span class="px-2 py-1 text-xs font-medium whitespace-nowrap rounded-full opacity-80" :class="{
                                        'bg-slate-600 text-slate-100': game.status === 'completed',
                                        'bg-green-500 text-green-100 animate-pulse': game.status === 'in_progress',
                                        'bg-orange-600 text-yellow-100': game.status === 'draft',
                                        'bg-blue-500 text-blue-100': game.status === 'scheduled'
                                    }">
                                        {{ game.status.replace(/_/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex gap-2 justify-end">
                                        <Link :href="scoreUrl(game)" class="btn btn-primary">
                                        Score
                                        </Link>


                                        <a class="btn btn-error" @click.prevent="deleteGame(game)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div v-else class="p-4 mt-12 text-yellow-300 rounded-lg bg-yellow-900/50">
                        <p class="text-center">Nije pronađena nijedna utakmica.</p>
                    </div>

                    <div class="pt-6 text-center">
                        <button class="btn btn-error" @click.prevent="generateStats()">
                            Generiraj statistiku
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
