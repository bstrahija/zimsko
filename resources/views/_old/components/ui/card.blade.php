@php
    $variant = isset($variant) ? $variant : 'default';
    $title = isset($title) ? $title : null;
    $subtitle = isset($subtitle) ? $subtitle : null;
    $icon = isset($icon) ? $icon : null;

    if ($variant === 'light') {
        $bgTop = 'bg-[#b6d7e4]';
        $headColor = 'text-secondary';
        $bgLogo = 'text-sky-800 opacity-20 ';
    } elseif ($variant === 'cta') {
        $bgTop = 'bg-primary';
        $headColor = 'text-white';
        $bgLogo = 'text-orange-900 opacity-20 ';
    } else {
        $bgTop = 'bg-secondary';
        $headColor = 'text-white';
        $bgLogo = 'text-sky-900 opacity-40 ';
    }
@endphp

<div class="block ui-card bg-white border border-gray-200 overflow-hidden rounded shadow-sm {{ $class ?? '' }}">
    @if ($title || $subtitle)
        <div class="overflow-hidden relative ui-card__top-bar {{ $bgTop }} {{ $headColor }} px-6 pt-4 pb-4 text-center">


            @if ($title)
                <h2 class="flex relative z-20 gap-3 justify-center mb-1 text-3xl font-semibold uppercase font-heading">
                    @if ($icon)
                        <img src="{{ $icon }}" class="max-h-10 rounded-full max-w-10" />
                    @endif

                    {{ $title }}
                </h2>
            @endif

            @if ($subtitle)
                <h3 class="relative z-20 uppercase font-heading text-md">
                    {{ $subtitle }}
                </h3>
            @endif

            <div class="aspect-square h-[600px] {{ $bgLogo }} absolute -top-[25px] -left-[150px] z-10">
                <x-ui.logo-basket class="w-[950px] mx-6 aspect-square" />
            </div>
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>
</div>
