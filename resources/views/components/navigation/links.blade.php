<li><x-navigation.link href="{{ \App\Services\Settings::get('general.facebook') }}" target="_blank">Novosti</x-navigation.link></li>
<li><x-navigation.link href="{{ route('results') }}">Rezultati</x-navigation.link></li>
<li><x-navigation.link href="{{ route('schedule') }}">Raspored</x-navigation.link></li>
<li><x-navigation.link href="{{ route('teams') }}">Ekipe</x-navigation.link></li>
<li><x-navigation.link href="https://www.facebook.com/ZimskoPrvenstvoCK/photos_albums" target="_blank">Galerije</x-navigation.link></li>
<!-- <li><x-navigation.link href="{{ route('history') }}">Povijest</x-navigation.link></li> -->
<li><x-navigation.link href="{{ route('contact') }}">Kontakt</x-navigation.link></li>

@if (auth()->check())
    <li class="pt-4 border-t border-secondary/40 md:hidden"><x-navigation.link href="{{ url('admin') }}">Admin</x-navigation.link></li>
    <li class="md:hidden"><x-navigation.link href="{{ url('live') }}">Live</x-navigation.link></li>
@endif
