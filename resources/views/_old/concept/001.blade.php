<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zimsko Concept 001</title>
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .font-inter {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Barlow Condensed', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .bg-animated {
            position: fixed;
            background: conic-gradient(from 180deg at 50% 70%, hsla(0, 0%, 98%, 1) 0deg, #eec32d 72.0000010728836deg, #ec4b4b 144.0000021457672deg, #709ab9 216.00000858306885deg, #4dffbf 288.0000042915344deg, hsla(0, 0%, 98%, 1) 1turn);
            width: 100%;
            height: 100%;
            mask:
                radial-gradient(circle at 50% 50%, white 2px, transparent 2.5px) 50% 50% / var(--size) var(--size),
                url("https://assets.codepen.io/605876/noise-mask.png") 256px 50% / 256px 256px;
            mask-composite: intersect;
            animation: flicker 20s infinite linear;
        }

        @keyframes flicker {
            to {
                mask-position: 50% 50%, 0 50%;
            }
        }

        .card-gradient {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.7) 0%, rgba(15, 23, 42, 0.7) 100%);
            border: 1px solid rgba(148, 163, 184, 0.1);
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);

        }

        .leaderboard-separator {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
            margin: 0.75rem 0;
        }

        /* Navigation link effects */
        .nav-link {
            position: relative;
            overflow: hidden;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: #3b82f6;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Glow effect for important elements */
        .glow-hover:hover {
            text-shadow: 0 0 8px rgba(59, 130, 246, 0.6);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.3);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.7);
        }
    </style>
    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        function toggleTeamDropdown() {
            const dropdown = document.getElementById('team-dropdown');
            dropdown.classList.toggle('hidden');
        }
    </script>
</head>

<body class="relative text-gray-100 font-inter bg-dark">
    {{-- <div class="bg-animated"></div> --}}

    @include('concept.001.navigation')


    @include('concept.001.hero')

    <!-- Latest Games -->
    <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h2 class="mb-8 text-center uppercase">
            <div class="font-semibold text text-neutral">Rezultati</div>
            <div class="text-4xl font-medium">Posljednje utakmice</div>
        </h2>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
            @include('concept.001.game-card')
            @include('concept.001.game-card')
            @include('concept.001.game-card')
            @include('concept.001.game-card')
        </div>
    </div>

    <!-- Leaderboards Section -->
    <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            @include('concept.001.leaderboard')
            @include('concept.001.leaderboard')
            @include('concept.001.leaderboard')


        </div>
    </div>

    <!-- Latest Blog Posts -->
    <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h2 class="mb-6 text-2xl font-bold">Latest News</h2>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <!-- Blog Post Card -->
            <div class="overflow-hidden rounded-lg shadow-lg card-gradient card-hover">
                <img src="https://placehold.co/600x400/1a1a1a/ffffff" alt="Blog post" class="object-cover w-full h-48">
                <div class="p-6">
                    <h3 class="mb-2 text-xl font-bold">Season Highlights</h3>
                    <p class="text-gray-400">Check out the best moments from this season's games...</p>
                    <a href="#" class="inline-block mt-4 text-blue-500 hover:text-blue-400">Read more →</a>
                </div>
            </div>
            <!-- Blog Post Card 2 -->
            <div class="overflow-hidden rounded-lg shadow-lg card-gradient card-hover">
                <img src="https://placehold.co/600x400/1a1a1a/ffffff" alt="Blog post" class="object-cover w-full h-48">
                <div class="p-6">
                    <h3 class="mb-2 text-xl font-bold">Player Spotlight</h3>
                    <p class="text-gray-400">An in-depth look at this season's rising stars...</p>
                    <a href="#" class="inline-block mt-4 text-blue-500 hover:text-blue-400">Read more →</a>
                </div>
            </div>
            <!-- Blog Post Card 3 -->
            <div class="overflow-hidden rounded-lg shadow-lg card-gradient card-hover">
                <img src="https://placehold.co/600x400/1a1a1a/ffffff" alt="Blog post" class="object-cover w-full h-48">
                <div class="p-6">
                    <h3 class="mb-2 text-xl font-bold">League Updates</h3>
                    <p class="text-gray-400">Latest news and announcements from the league...</p>
                    <a href="#" class="inline-block mt-4 text-blue-500 hover:text-blue-400">Read more →</a>
                </div>
            </div>
        </div>
    </div>

    @include('concept.001.footer')
</body>

</html>
