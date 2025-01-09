<div class="header bg-black w-full h-[300px] overflow-hidden  flex flex-col justify-center items-center relative">
    <div class="absolute inset-0 z-10 w-full h-full bg-black bg-center bg-cover opacity-50" style="background-image: url('{{ asset('img/hero.jpg') }}');"></div>
    <h2 class="relative z-20 text-5xl font-bold text-white uppercase">{{ $title ?? 'Zimsko Prvenstvo' }}</h2>
</div>

<div class="mb-12">
    <x-burger-weekend />
</div>
