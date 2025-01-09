<div class="{{ $class ?? '' }}">
    <x-ui.h2-double sub="Blog">Posljednje novosti</x-ui.h2-double>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        @foreach ($articles as $article)
            <x-ui.card class="flex flex-col h-full prose">
                <div class="flex-grow mb-8">
                    <h2 class="mb-4 text-2xl font-bold line-clamp-2"><a href="{{ route('news.show', $article) }}"
                            class="transition-colors hover:text-secondary">{{ $article->title }}</a></h2>
                    <p class="leading-6 line-clamp-5">{{ $article->summary() }}</p>
                </div>
                <div class="mt-auto">
                    <x-ui.button tag="a" variant="secondary" href="{{ route('news.show', $article) }}">Procitaj više</x-ui.button>
                </div>
            </x-ui.card>
        @endforeach
    </div>
</div>
