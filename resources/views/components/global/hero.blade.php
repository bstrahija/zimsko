<div class="hero w-full h-[75vh] max-h-[40svh] md:max-h-[45svh] lg:max-h-[60svh] xl:max-h-[70svh] outline-2 outline-red-500 overflow-hidden mt-[62px] lg:mt-0 mb-16 md:mb-24 lg:mb-32"
    data-bg="{{ asset('img/video-overlay.jpg') }}" style="background-image: url({{ asset('img/video-overlay.jpg') }}); background-position: 50% 50%; position: relative;">

    <div class="container">
        <div class="flex relative z-0 flex-col justify-center items-center w-full h-full">
            <p class="my-4 text-2xl font-bold text-white uppercase drop-shadow-lg">Zimsko košarkaško prvenstvo</p>
            <p class="my-4 text-6xl font-bold text-amber-400 uppercase drop-shadow-xl">Čakovec</p>
        </div>
    </div>

    <a href="https://www.facebook.com/burgerweekendcakovec/" class="absolute top-0 right-0 z-50 py-2 md:py-4 pr-4 md:pr-8 pl-[100px] md:pl-[150px] bg-white/80 overflow-hidden"
        style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%, 70px 100%, 0 0);" target="_blank">
        <span class="absolute top-2 left-10 text-xs md:top-4 md:left-16 text-secondary font-condensed md:text-base">Powered by</span>
        <img src="{{ asset('img/logo_burger.png') }}" alt="" class="w-32 md:w-48" />
    </a>

    <x-global.hero-video />
</div>
