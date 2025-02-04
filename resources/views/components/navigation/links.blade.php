<li><x-navigation.link href="{{ \App\Services\Settings::get('general.facebook') }}" target="_blank">Novosti</x-navigation.link></li>
<li><x-navigation.link href="{{ route('results') }}">Rezultati</x-navigation.link></li>
<li><x-navigation.link href="{{ route('schedule') }}">Raspored</x-navigation.link></li>
<li class="relative group">
    <x-navigation.link href="{{ route('teams') }}" class="flex items-center">
        Ekipe
        <svg class="inline-block w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </x-navigation.link>
    <div class="hidden absolute z-50 py-2 w-48 bg-white rounded-md shadow-xl group-hover:block">
        @foreach (\App\Services\Helpers::currentTeams() as $team)
            <a href="{{ route('teams.show', $team->slug) }}" class="flex px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <span class="flex mr-2 w-6"><img src="{{ $team->logo() }}" alt="" class="max-h-6 max-w-6"></span>
                {{ $team->title }}
            </a>
        @endforeach
    </div>
</li>
<li><x-navigation.link href="https://www.facebook.com/ZimskoPrvenstvoCK/photos_albums" target="_blank">Galerije</x-navigation.link></li>
<li><x-navigation.link href="{{ route('contact') }}">Kontakt</x-navigation.link></li>

@if (auth()->check())
    <li class="pt-4 border-t border-secondary/40 md:hidden"><x-navigation.link href="{{ url('admin') }}">Admin</x-navigation.link></li>
    <li class="md:hidden"><x-navigation.link href="{{ url('live') }}">Live</x-navigation.link></li>
@endif
