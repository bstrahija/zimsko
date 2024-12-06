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

<body class="min-h-screen bg-black">
    <!-- Main container with perspective and gradient background -->
    <div class="relative min-h-screen bg-fixed bg-center bg-cover"
        style="background-image: url('{{ asset('img/live-001.jpg') }}');">
        <div
            class="absolute inset-0 bg-gradient-to-br via-transparent mix-blend-overlay from-cyan-600/40 to-fuchsia-600/40">
        </div>
        <div class="flex relative justify-center items-center p-6 min-h-screen">
            <div class="w-full max-w-7xl transform scale-105 perspective-3000 rotate-x-10">
                <div
                    class="bg-slate-900/95 p-6 rounded-lg border-2 border-cyan-400/50 shadow-[0_0_15px_rgba(6,182,212,0.5)] grid-bg">

                    <div class="grid grid-cols-3 gap-6">
                        <div class="space-y-4">
                            <div class="p-4 rounded-lg border bg-cyan-900/60 border-cyan-400/30">
                                <h2 class="mb-2 font-mono text-xl text-cyan-300">HOME</h2>
                                <div class="text-6xl font-bold text-cyan-400">108</div>
                                <div class="mt-2 text-sm text-cyan-300/80">CYBER KNIGHTS</div>
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="p-2 text-center rounded bg-cyan-900/40">
                                    <div class="text-xs text-cyan-400">FOULS</div>
                                    <div class="font-bold text-cyan-300">4</div>
                                </div>
                                <div class="p-2 text-center rounded bg-cyan-900/40">
                                    <div class="text-xs text-cyan-400">TO</div>
                                    <div class="font-bold text-cyan-300">2</div>
                                </div>
                                <div class="p-2 text-center rounded bg-cyan-900/40">
                                    <div class="text-xs text-cyan-400">BONUS</div>
                                    <div class="font-bold text-cyan-300">✓</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-2">
                                <button class="p-2 text-xs text-cyan-200 bg-cyan-700 rounded">2PT</button>
                                <button class="p-2 text-xs text-cyan-200 bg-cyan-700 rounded">3PT</button>
                                <button class="p-2 text-xs text-cyan-200 bg-cyan-700 rounded">FT</button>
                                <button class="p-2 text-xs text-cyan-200 bg-cyan-700 rounded">REB</button>
                                <button class="p-2 text-xs text-cyan-200 bg-cyan-700 rounded">AST</button>
                                <button class="p-2 text-xs text-cyan-200 bg-cyan-700 rounded">STL</button>
                                <button class="p-2 text-xs text-cyan-200 bg-cyan-700 rounded">BLK</button>
                                <button class="p-2 text-xs text-cyan-200 bg-cyan-700 rounded">TO</button>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div
                                class="flex flex-col justify-center items-center p-4 h-full rounded-lg border bg-slate-800/60 border-fuchsia-400/30">
                                <div class="mb-4 font-mono text-fuchsia-300">POSSESSION</div>
                                <div class="flex justify-center space-x-4">
                                    <div class="w-4 h-4 bg-cyan-400 rounded-full animate-pulse"></div>
                                    <div class="w-4 h-4 rounded-full bg-slate-600"></div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="p-2 text-center rounded bg-slate-800/40">
                                    <div class="text-xs text-fuchsia-400">PERIOD</div>
                                    <div class="font-bold text-fuchsia-300">4TH</div>
                                </div>
                                <div class="p-2 text-center rounded bg-slate-800/40">
                                    <div class="text-xs text-fuchsia-400">SHOT</div>
                                    <div class="font-bold text-fuchsia-300">14</div>
                                </div>
                            </div>
                            <div class="p-4 rounded-lg border bg-slate-800/60 border-fuchsia-400/30">
                                <h3 class="mb-2 font-mono text-center text-fuchsia-300">ON COURT</h3>
                                <div class="flex justify-center space-x-2">
                                    <span class="px-2 py-1 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">4</span>
                                    <span class="px-2 py-1 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">7</span>
                                    <span class="px-2 py-1 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">11</span>
                                    <span class="px-2 py-1 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">23</span>
                                    <span class="px-2 py-1 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">30</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="p-4 rounded-lg border bg-fuchsia-900/60 border-fuchsia-400/30">
                                <h2 class="mb-2 font-mono text-xl text-fuchsia-300">AWAY</h2>
                                <div class="text-6xl font-bold text-fuchsia-400 font-oswald">96</div>
                                <div class="mt-2 text-sm text-fuchsia-300/80">NEON RAIDERS</div>
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="p-2 text-center rounded bg-fuchsia-900/40">
                                    <div class="text-xs text-fuchsia-400">FOULS</div>
                                    <div class="font-bold text-fuchsia-300">3</div>
                                </div>
                                <div class="p-2 text-center rounded bg-fuchsia-900/40">
                                    <div class="text-xs text-fuchsia-400">TO</div>
                                    <div class="font-bold text-fuchsia-300">1</div>
                                </div>
                                <div class="p-2 text-center rounded bg-fuchsia-900/40">
                                    <div class="text-xs text-fuchsia-400">BONUS</div>
                                    <div class="font-bold text-fuchsia-300">-</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-2">
                                <button class="p-2 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">2PT</button>
                                <button class="p-2 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">3PT</button>
                                <button class="p-2 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">FT</button>
                                <button class="p-2 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">REB</button>
                                <button class="p-2 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">AST</button>
                                <button class="p-2 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">STL</button>
                                <button class="p-2 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">BLK</button>
                                <button class="p-2 text-xs text-fuchsia-200 bg-fuchsia-700 rounded">TO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>
