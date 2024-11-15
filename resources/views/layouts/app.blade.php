<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zimsko</title>
    <script defer src="https://cloud.umami.is/script.js" data-website-id="efe2fff4-3192-4870-9a3a-d56d04f56341"></script>

    @livewireStyles
    @vite(['resources/js/app.js'])

</head>

<body class="dark bg-gray-100">
    <x-header />

    @yield('content')

    <x-footer />

    @livewireScripts
</body>

</html>
