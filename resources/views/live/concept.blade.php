<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zimsko</title>

    @livewireStyles
    @vite(['resources/js/app.js'])
    <style>
        .grid-bg {
            background-image: linear-gradient(rgba(0, 0, 0, .1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, .1) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>

<body class="p-4 min-h-screen text-white bg-gray-900">
    <!-- Main Container -->
    <div class="p-6 mx-auto space-y-6 max-w-7xl bg-gradient-to-br from-gray-900 to-black rounded-xl border-transparent border-5"
        style="background-clip: padding-box; border-image: linear-gradient(to bottom right, rgba(6,182,212,0.5), rgba(219,39,119,0.5)) 1;">
        <!-- Header with Team Names and Score -->
        <div
            class="grid grid-cols-3 gap-6 p-6 bg-gradient-to-r from-cyan-900 to-fuchsia-900 rounded-2xl border-2 border-cyan-400 shadow-lg shadow-cyan-500/50">
            <!-- Home Team -->
            <div class="space-y-2 text-center">
                <h2 class="text-3xl font-bold text-cyan-300 neon-text-cyan">CYBER KNIGHTS</h2>
                <p class="text-6xl font-bold text-cyan-400 neon-text-cyan">85</p>
                <div class="flex justify-center space-x-2">
                    <button
                        class="px-3 py-1 text-cyan-100 bg-cyan-600 rounded-full transition hover:bg-cyan-500">+1</button>
                    <button
                        class="px-3 py-1 text-cyan-100 bg-cyan-600 rounded-full transition hover:bg-cyan-500">+2</button>
                    <button
                        class="px-3 py-1 text-cyan-100 bg-cyan-600 rounded-full transition hover:bg-cyan-500">+3</button>
                </div>
            </div>
            <!-- Quarter Info -->
            <div class="space-y-2 text-center">
                <div class="text-2xl font-bold text-yellow-300 neon-text-yellow">QUARTER</div>
                <div class="text-4xl font-bold text-yellow-400 neon-text-yellow">4</div>
                <div class="text-xl text-yellow-300 neon-text-yellow">08:45</div>
            </div>
            <!-- Away Team -->
            <div class="space-y-2 text-center">
                <h2 class="text-3xl font-bold text-fuchsia-300 neon-text-fuchsia">NEON RAIDERS</h2>
                <p class="text-6xl font-bold text-fuchsia-400 neon-text-fuchsia">82</p>
                <div class="flex justify-center space-x-2">
                    <button
                        class="px-3 py-1 text-fuchsia-100 bg-fuchsia-600 rounded-full transition hover:bg-fuchsia-500">+1</button>
                    <button
                        class="px-3 py-1 text-fuchsia-100 bg-fuchsia-600 rounded-full transition hover:bg-fuchsia-500">+2</button>
                    <button
                        class="px-3 py-1 text-fuchsia-100 bg-fuchsia-600 rounded-full transition hover:bg-fuchsia-500">+3</button>
                </div>
            </div>
        </div>

        <!-- Quarter Scores -->
        <div class="grid grid-cols-5 gap-4 p-4 bg-gray-800 rounded-xl border border-yellow-400">
            <div class="text-center">
                <span class="text-yellow-300">Q1</span>
                <p class="text-xl font-bold text-yellow-400">22-20</p>
            </div>
            <div class="text-center">
                <span class="text-yellow-300">Q2</span>
                <p class="text-xl font-bold text-yellow-400">18-24</p>
            </div>
            <div class="text-center">
                <span class="text-yellow-300">Q3</span>
                <p class="text-xl font-bold text-yellow-400">25-19</p>
            </div>
            <div class="text-center">
                <span class="text-yellow-300">Q4</span>
                <p class="text-xl font-bold text-yellow-400">20-19</p>
            </div>
            <div class="text-center">
                <span class="text-yellow-300">Total</span>
                <p class="text-xl font-bold text-yellow-400">85-82</p>
            </div>
        </div>

        <!-- Players and Stats Container -->
        <div class="grid grid-cols-2 gap-8">
            <!-- Home Team Section -->
            <div class="space-y-6">
                <!-- Players on Court -->
                <div class="p-6 bg-gradient-to-r from-cyan-900 to-blue-900 rounded-xl border-2 border-cyan-400">
                    <h3 class="mb-4 text-2xl font-bold text-cyan-300 neon-text-cyan">ON COURT</h3>
                    <div class="grid grid-cols-5 gap-3">
                        @foreach ([5, 7, 11, 23, 33] as $number)
                            <div class="p-3 text-center bg-cyan-800 rounded-lg border border-cyan-300">
                                <span
                                    class="text-2xl font-bold text-cyan-300 neon-text-cyan">#{{ $number }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Stats Boxes -->
                <div class="grid grid-cols-3 gap-4">
                    @foreach (['ASSISTS' => 15, 'REBOUNDS' => 28, 'FOULS' => 12] as $stat => $value)
                        <div
                            class="p-4 text-center bg-gradient-to-r from-cyan-900 to-blue-900 rounded-xl border-2 border-cyan-400">
                            <span class="text-lg text-cyan-300">{{ $stat }}</span>
                            <p class="text-3xl font-bold text-cyan-400 neon-text-cyan">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Bench Players -->
                <div class="p-6 bg-gradient-to-r from-cyan-900 to-blue-900 rounded-xl border-2 border-cyan-400">
                    <h3 class="mb-4 text-2xl font-bold text-cyan-300 neon-text-cyan">BENCH</h3>
                    <div class="grid grid-cols-4 gap-3">
                        @foreach ([4, 15, 21, 45] as $number)
                            <div class="p-3 text-center rounded-lg border bg-cyan-800/50 border-cyan-300/50">
                                <span class="text-xl text-cyan-300">#{{ $number }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Away Team Section -->
            <div class="space-y-6">
                <!-- Players on Court -->
                <div class="p-6 bg-gradient-to-r from-fuchsia-900 to-purple-900 rounded-xl border-2 border-fuchsia-400">
                    <h3 class="mb-4 text-2xl font-bold text-fuchsia-300 neon-text-fuchsia">ON COURT</h3>
                    <div class="grid grid-cols-5 gap-3">
                        @foreach ([3, 8, 12, 24, 32] as $number)
                            <div class="p-3 text-center bg-fuchsia-800 rounded-lg border border-fuchsia-300">
                                <span
                                    class="text-2xl font-bold text-fuchsia-300 neon-text-fuchsia">#{{ $number }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Stats Boxes -->
                <div class="grid grid-cols-3 gap-4">
                    @foreach (['ASSISTS' => 18, 'REBOUNDS' => 25, 'FOULS' => 14] as $stat => $value)
                        <div
                            class="p-4 text-center bg-gradient-to-r from-fuchsia-900 to-purple-900 rounded-xl border-2 border-fuchsia-400">
                            <span class="text-lg text-fuchsia-300">{{ $stat }}</span>
                            <p class="text-3xl font-bold text-fuchsia-400 neon-text-fuchsia">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Bench Players -->
                <div class="p-6 bg-gradient-to-r from-fuchsia-900 to-purple-900 rounded-xl border-2 border-fuchsia-400">
                    <h3 class="mb-4 text-2xl font-bold text-fuchsia-300 neon-text-fuchsia">BENCH</h3>
                    <div class="grid grid-cols-4 gap-3">
                        @foreach ([6, 14, 22, 44] as $number)
                            <div class="p-3 text-center rounded-lg border bg-fuchsia-800/50 border-fuchsia-300/50">
                                <span class="text-xl text-fuchsia-300">#{{ $number }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>
