<div class="hero w-full h-[75vh] max-h-[40svh] md:max-h-[45svh] lg:max-h-[60svh] xl:max-h-[70svh] outline-2 outline-red-500 overflow-hidden pt-[72px]"
    data-bg="{{ asset('img/video-overlay.jpg') }}" style="background-image: url({{ asset('img/video-overlay.jpg') }}); background-position: 50% 50%; position: relative;">

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
