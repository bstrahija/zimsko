<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite('resources/js/live.js')
    @inertiaHead
</head>

<body class="min-h-screen text-white bg-black dark">
    <!-- Main container with perspective and gradient background -->
    <div class="relative min-h-screen bg-fixed bg-center bg-cover"
        style="background-image: url('{{ asset('img/live-001.jpg') }}');">
        <div
            class="absolute inset-0 bg-gradient-to-br mix-blend-overlay via-sky-600/40 from-cyan-600/40 to-fuchsia-600/40">
        </div>
        <div class="flex relative justify-center items-center min-h-screen">
            @inertia
        </div>
    </div>
</body>

</html>
