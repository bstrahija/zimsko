<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zimsko Concept 002</title>
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&family=Figtree:ital,wght@0,300..900;1,300..900&display=swap');

        * {
            font-family: 'Figtree', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Figtree', sans-serif;

        }

        p {
            font-family: 'Inter', sans-serif;
        }

        .wrapper {
            max-width: 1920px;
            margin: 0 auto;
        }
    </style>
</head>

<body class="p-8 bg-white dark">
    <div class="wrapper">
        <x-concept.002.navigation />
    </div>

    <div class="wrapper">
        <x-concept.002.hero />
    </div>

    <div class="text-amber-500">
        <x-ui.logo class="mx-auto w-[500px] h-auto" />
    </div>
</body>
