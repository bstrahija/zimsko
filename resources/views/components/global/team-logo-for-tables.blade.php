@php
    $title = $title ?? null;
    $teamLogo = $teamLogo ?? null;
@endphp

<span class="inline-flex justify-center items-center w-8 h-8 {{ $class ?? '' }}">
    <img src="{{ $teamLogo }}" alt="{{ $title }}" class="max-w-full max-h-full">
</span>
