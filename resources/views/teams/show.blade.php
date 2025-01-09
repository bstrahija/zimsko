@extends('layouts.app')

@section('content')
    @if ($team->photo())
        <x-header-photo title="{{ $team->title }}" url="{{ $team->photo('original') }}" />
    @else
        <x-header title="{{ $team->title }}" />
    @endif

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                ...
            </div>

            <x-sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
