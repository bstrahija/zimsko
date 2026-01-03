<footer class="items-center pt-12 mt-24 space-y-12 text-gray-100 footer bg-secondary">
    <div class="container grid grid-cols-1 gap-12 p-8 mx-auto md:grid-cols-4">
        <div>
            <a href="{{ route('home') }}" class="flex justify-center items-center text-white md:justify-start">
                <x-global.logo class="w-48 h-auto" />
            </a>
        </div>

        <div>
            <h2 class="mb-10 text-lg uppercase font-oswald">NAJNOVIJE VIJESTI</h2>
            <div class="space-y-4">
                @foreach (App\Models\Post::query()->orderBy('published_at', 'desc')->take(3)->get() as $item)
                    <a href="{{ route('news.show', $item->slug) }}" class="block text-sm font-bold leading-5 text-gray-200 transition-all hover:text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block mr-1 w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M2 3a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H3a1 1 0 01-1-1V3zm2 2v10h12V5H4zm2 2h8v2H6V7zm0 4h8v2H6v-2z" clip-rule="evenodd" />
                        </svg>
                        {{ $item->title }}
                    </a>
                @endforeach
            </div>
        </div>

        <div>
            <h2 class="mb-10 text-lg uppercase font-oswald">Prijavite ekipu</h2>

            <div class="mb-8">
                <svg fill="currentColor" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                     class="mr-4 mb-4 w-12 h-12 float-start" viewBox="0 0 31.118 31.119" xml:space="preserve">
                    <g>
                        <g>
                            <path d="M11.939,8.819c-0.42-0.06-0.834-0.104-1.239-0.136c-0.914,1.908-1.53,3.981-1.794,6.168 c2.799-0.01,7.457,1.146,8.943,8.518c0.731,3.649,2.479,5.508,5.408,5.713c2.418-1.377,4.426-3.386,5.809-5.797 C26.671,15.833,20.206,10.006,11.939,8.819z" />
                            <path d="M7.483,16.269c-2.133,0.324-3.621,1.168-4.422,2.504c-1.134,1.89-0.675,4.371-0.339,5.58 c2.164,3.154,5.462,5.472,9.307,6.363c-2.882-3.611-4.57-8.258-4.57-13.457C7.458,16.927,7.469,16.599,7.483,16.269z" />
                            <path d="M9.932,7.334c0.589-1.104,1.269-2.152,2.038-3.134c-1.835-0.64-2.397-1.984-2.453-2.979 C5.762,2.808,2.754,5.825,1.188,9.595C3.576,8.108,6.31,7.323,9.321,7.323C9.522,7.325,9.728,7.33,9.932,7.334z" />
                            <path d="M7.586,14.941c0.244-2.226,0.833-4.35,1.712-6.316c-3.495,0.007-6.413,1.1-8.791,2.99C0.175,12.874,0,14.196,0,15.562 c0,1.98,0.37,3.879,1.045,5.625c0.06-1.024,0.309-2.098,0.894-3.08C2.989,16.355,4.891,15.291,7.586,14.941z" />
                            <path d="M12.888,3.112c1.029-1.149,2.184-2.187,3.439-3.087c-0.256-0.013-0.513-0.02-0.767-0.02c-2.982,0-4.725,0.814-4.725,0.814 C10.804,1.003,10.618,2.593,12.888,3.112z" />
                            <path d="M28.184,6.471l-0.027,0.019c-2.914-3.642-7.619-1.747-7.668-1.728c-1.279,0.53-3.613,0.456-7.125-0.224 c-0.751,0.9-1.424,1.869-2.008,2.898c0.254,0.026,0.512,0.056,0.772,0.093c5.934,0.851,11.178,3.966,14.771,8.761 c1.25,1.67,2.248,3.474,2.979,5.364c0.8-1.87,1.24-3.932,1.24-6.092C31.115,12.167,30.029,9.027,28.184,6.471z" />
                            <path d="M19.99,3.56c1.086-0.452,2.943-0.836,4.865-0.47c-1.889-1.416-4.113-2.403-6.529-2.839 c-1.447,0.883-2.771,1.944-3.946,3.154C17.811,4.004,19.324,3.835,19.99,3.56z" />
                            <path d="M16.574,23.626c-1.293-6.422-5.12-7.531-7.781-7.479c-0.021,0.367-0.031,0.735-0.031,1.106 c0,5.353,1.922,10.207,5.259,13.783c0.506,0.047,1.02,0.075,1.541,0.075c2.023,0,3.961-0.387,5.739-1.092 C18.85,29.208,17.266,27.07,16.574,23.626z" />
                        </g>
                    </g>
                </svg>
                <h3 class="mb-1 text-xs font-bold uppercase">E-Mail</h3>
                <p><a href="mailto:zimsko.prvenstvo.ck@gmail.com" class="text-xs text-gray-200 transition-all hover:text-primary">zimsko.prvenstvo.ck@gmail.com</a>
                </p>
            </div>

            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 mb-4 w-12 h-12 float-start" viewBox="0 0 24 24" fill="currentColor">
                    <path
                          d="M20.59 6.87c-.01-.01-.02-.03-.03-.04l-3.39-3.39A.996.996 0 0 0 16.46 3H7.54c-.28 0-.56.11-.76.32L3.41 6.86c-.01.01-.02.02-.03.03A.996.996 0 0 0 3 7.54V16.46c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V7.54c0-.26-.1-.51-.28-.69zM12 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm4.5-9h-9L9 5h6l1.5 2z" />
                </svg>
                <h3 class="mb-1 text-xs font-bold uppercase">Prijava!</h3>
                <p><a href="{{ route('contact') }}" class="text-xs text-gray-200 transition-all hover:text-primary">Prijavite se ovdje</a>
                </p>
            </div>
        </div>

        <nav class="flex gap-4 justify-self-center md:justify-self-end">
            <a href="{{ \App\Services\Settings::get('general.instagram') }}" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                    <path
                          d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                </svg>
            </a>
            <a href="{{ \App\Services\Settings::get('general.facebook') }}" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                    <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z">
                    </path>
                </svg>
            </a>
            <a href="{{ \App\Services\Settings::get('general.youtube') }}" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                    <path
                          d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z">
                    </path>
                </svg>
            </a>
        </nav>
    </div>

    <div class="py-8 text-center bg-black/20">
        <div class="flex flex-wrap gap-6 justify-center items-center mx-auto text-white uppercase wraper font-nav">
            <a href="{{ route('home') }}" class="transition-all hover:text-primary">Početna</a>
            <a href="{{ route('results') }}" class="transition-all hover:text-primary">Rezultati</a>
            <a href="{{ route('schedule') }}" class="transition-all hover:text-primary">Raspored</a>
            <a href="{{ route('teams') }}" class="transition-all hover:text-primary">Ekipe</a>
            <a href="https://www.facebook.com/ZimskoPrvenstvoCK/photos_albums" class="transition-all hover:text-primary" target="_blank">Galerije</a>
            <a href="{{ url('admin') }}" class="transition-all hover:text-primary">{{ auth()->check() ? 'Admin' : 'Login' }}</a>
            <a href="{{ route('contact') }}" class="transition-all hover:text-primary">Kontakt</a>
        </div>
    </div>

    <div class="hidden grid-flow-col items-center pb-10 mx-auto wrapper">
        <p class="text-xs text-center">
            Copyright © {{ Carbon\Carbon::now()->year }} - by
            <a href="https://www.creolab.hr" target="_blank" class="transition-all hover:underline hover:text-blue-300" target="_blank">Creo</a>
        </p>
    </div>
</footer>
