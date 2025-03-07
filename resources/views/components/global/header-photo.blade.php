<div class="overflow-hidden relative mb-12 bg-black header">
    <a href="#" class="block overflow-hidden relative w-full bg-black bg-center bg-cover opacity-50">
        <img src="{{ $url ?? asset('img/hero.jpg') }}" alt="" class="object-cover w-full h-full max-h-[40svh]">
    </a>

    <h2 class="flex absolute inset-0 z-20 justify-center items-center px-12 text-2xl font-bold text-center text-white uppercase sm:text-4xl md:text-5xl">
        {{ html_entity_decode($title ?? 'Zimsko Prvenstvo') }}
    </h2>
</div>
