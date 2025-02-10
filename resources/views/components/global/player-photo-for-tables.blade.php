@php
    $playerPhoto = $playerPhoto ?? null;
    $teamLogo = $teamLogo ?? null;
@endphp

@if ($playerPhoto)
    <span class="inline-flex overflow-hidden justify-center items-center w-8 h-8 bg-center bg-no-repeat bg-cover rounded-full {{ $class ?? '' }}"
        style="background-image: url('{{ $playerPhoto ?: $playerPhoto }}');">
    </span>
@else
    <span class="inline-flex justify-center items-center w-8 h-8 {{ $class ?? '' }}">
        <img src="{{ $teamLogo }}" alt="" class="max-w-full max-h-full">
    </span>
@endif
