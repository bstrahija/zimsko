@extends('layouts.app')

@section('content')
    <x-global.header title="Kontakt" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <div class="mb-8">
                    @if (session('success'))
                        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <x-ui.card class="mb-8" title="Kontaktirajte nas" subtitle="Pošaljite nam poruku">
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block mb-2">Ime</label>
                                <input type="text" id="name" name="name" required class="px-3 py-2 w-full rounded border">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block mb-2">Email</label>
                                <input type="email" id="email" name="email" required class="px-3 py-2 w-full rounded border">
                            </div>
                            <div class="mb-4">
                                <label for="message" class="block mb-2">Poruka</label>
                                <textarea id="message" name="message" required class="px-3 py-2 w-full rounded border" rows="4"></textarea>
                            </div>

                            <x-ui.button type="submit" variant="secondary" size="lg" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Pošalji</x-ui.button>
                        </form>
                    </x-ui.card>
                </div>

                <x-ui.card class="mb-8" title="Naša lokacija">
                    <div class="w-full h-96">
                        <iframe width="100%" height="100%" frameborder="0" style="border:0"
                            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyC-468CEeERV42L2CsxGySC7ps0wOsUFp4&q=Ekonomska+skola+cakovec" allowfullscreen>
                        </iframe>
                    </div>
                </x-ui.card>
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
