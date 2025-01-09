<div class="hero w-full min-h-[75vh] outline-2 outline-red-500 overflow-hidden pt-[72px]" data-bg="{{ asset('img/hero.png') }}"
    style="background-image: url({{ asset('img/hero.png') }}); background-position: 50% 50%; position: relative;">

    <x-navigation.main />

    <div class="container">
        <div class="flex relative z-0 flex-col justify-center items-center w-full h-full">
            <p class="my-4 text-2xl font-bold text-white uppercase drop-shadow-lg">Zimsko košarkaško prvenstvo</p>
            <p class="my-4 text-6xl font-bold text-amber-400 uppercase drop-shadow-xl">Čakovec</p>
        </div>
    </div>

    <x-basket.hero-video />
</div>

<div class="mb-12">
    <x-burger-weekend />
</div>
