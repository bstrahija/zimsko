<div class="absolute top-0 left-0 w-full h-full z-10 bg-red-400">
    <div id="hero-player" class="w-full h-full hidden border-2" data-video-id="2NXwPtblEbs">
        <div id="hero-player-container">Loading...</div>
    </div>
    <div id="play-hero-video" class="absolute top-0 left-0 w-full h-full flex justify-center items-center bg-black">
        <div class="absolute inset-0 flex items-center justify-center">
            <div
                class="w-24 h-24 rounded-full bg-red-600 flex items-center justify-center hover:bg-red-700 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path d="M8 5v14l11-7z" />
                </svg>
            </div>
        </div>

        <img id="play-hero-video-img" src="{{ asset('img/hero_video_no_bars.jpg') }}"
            class="w-full h-full object-cover" />
    </div>
</div>
