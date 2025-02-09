<div class="header bg-black w-full h-[300px] overflow-hidden mb-12 flex flex-col justify-center items-center relative">
    <div class="absolute inset-0 z-10 w-full h-full bg-black bg-center bg-cover opacity-50" style="background-image: url('{{ asset('img/hero.jpg') }}');"></div>

    <h2 class="relative z-20 px-6 text-2xl font-bold text-center text-white uppercase sm:text-4xl md:text-5xl">
        {{ html_entity_decode($title ?? 'Zimsko Prvenstvo') }}
    </h2>
</div>
