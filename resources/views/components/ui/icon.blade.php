@php
    $iconName = $icon ? 'heroicon-' . $icon : 'heroicon-o-question-mark-circle';
@endphp

<x-dynamic-component :component="$iconName" class="{{ $class }}" />
