@extends('layouts.app')

@section('content')
    <x-header />

    <div class="wrapper">
        <div class="prose">
            <p>Ovdje dolazi livewire komponenta koja ima izbor eventa i kola (mozda i teama)</p>
            <p>Ispod toga je tablica sa svim utakmicama prema odabranim filterima</p>
        </div>

        <x-sponsors />
    </div>
@endsection
