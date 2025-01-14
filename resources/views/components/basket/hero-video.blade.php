<div class="absolute top-0 left-0 z-10 w-full h-full">
    <div id="hero-player" class="hidden w-full h-full border-2" data-video-id="2NXwPtblEbs">
        <div id="hero-player-container">Loading...</div>
    </div>
    <div id="play-hero-video" class="flex absolute top-0 left-0 justify-center items-center w-full h-full bg-black">
        <div class="flex absolute inset-0 justify-center items-center">
            <div class="flex relative top-8 justify-center items-center w-24 h-24 bg-red-600 rounded-full transition-colors cursor-pointer hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8 5v14l11-7z" />
                </svg>
            </div>
        </div>

        <img id="play-hero-video-img" src="{{ asset('img/video-overlay.jpg') }}" class="object-cover w-full h-full" />
    </div>
</div>
