@extends('layouts.app')

@section('content')
    <x-header title="Novosti" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8 prose">
                <h1 class="mb-4 text-2xl font-bold md:text-3xl">{{ $post->title }}</h1>
                {!! $post->body !!}
            </div>

            <x-sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
