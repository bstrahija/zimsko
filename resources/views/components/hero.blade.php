<div class="hero w-full min-h-[75vh] outline-2 outline-red-500 overflow-hidden pt-[72px]"
    data-bg="{{ asset('img/hero.png') }}"
    style="background-image: url({{ asset('img/hero.png') }}); background-position: 50% 50%; position: relative;">

    <x-navigation.main />

    <x-burger-weekend />

    <div class="container">
        <div class="w-full h-full flex flex-col justify-center items-center relative z-0">
            <p class="text-white text-2xl font-bold drop-shadow-lg my-4 uppercase">Zimsko košarkaško prvenstvo</p>
            <p class="text-amber-400 text-6xl font-bold uppercase drop-shadow-xl my-4">Čakovec</p>
        </div>
    </div>

    <x-basket.hero-video />
</div>
