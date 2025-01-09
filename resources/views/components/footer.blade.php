<footer class="items-center pt-12 mt-24 space-y-12 text-gray-100 footer bg-slate-950">
    <div class="container grid grid-cols-4 gap-12 mx-auto">
        <div>
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-auto w-18">
            </a>
        </div>

        <div>
            <h2 class="mb-10 text-lg uppercase font-oswald">NAJNOVIJE VIJESTI</h2>
            <div class="space-y-4">
                @foreach (App\Models\Post::orderBy('published_at', 'desc')->take(3)->get() as $item)
                    <a href="{{ route('news.show', $item->slug) }}" class="block text-sm font-bold text-gray-200 transition-all hover:text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block mr-1 w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M2 3a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H3a1 1 0 01-1-1V3zm2 2v10h12V5H4zm2 2h8v2H6V7zm0 4h8v2H6v-2z"
                                clip-rule="evenodd" />
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
                            <path d="M11.939,8.819c-0.42-0.06-0.834-0.104-1.239-0.136c-0.914,1.908-1.53,3.981-1.794,6.168
   c2.799-0.01,7.457,1.146,8.943,8.518c0.731,3.649,2.479,5.508,5.408,5.713c2.418-1.377,4.426-3.386,5.809-5.797
   C26.671,15.833,20.206,10.006,11.939,8.819z" />
                            <path d="M7.483,16.269c-2.133,0.324-3.621,1.168-4.422,2.504c-1.134,1.89-0.675,4.371-0.339,5.58
   c2.164,3.154,5.462,5.472,9.307,6.363c-2.882-3.611-4.57-8.258-4.57-13.457C7.458,16.927,7.469,16.599,7.483,16.269z" />
                            <path d="M9.932,7.334c0.589-1.104,1.269-2.152,2.038-3.134c-1.835-0.64-2.397-1.984-2.453-2.979
   C5.762,2.808,2.754,5.825,1.188,9.595C3.576,8.108,6.31,7.323,9.321,7.323C9.522,7.325,9.728,7.33,9.932,7.334z" />
                            <path d="M7.586,14.941c0.244-2.226,0.833-4.35,1.712-6.316c-3.495,0.007-6.413,1.1-8.791,2.99C0.175,12.874,0,14.196,0,15.562
   c0,1.98,0.37,3.879,1.045,5.625c0.06-1.024,0.309-2.098,0.894-3.08C2.989,16.355,4.891,15.291,7.586,14.941z" />
                            <path d="M12.888,3.112c1.029-1.149,2.184-2.187,3.439-3.087c-0.256-0.013-0.513-0.02-0.767-0.02c-2.982,0-4.725,0.814-4.725,0.814
   C10.804,1.003,10.618,2.593,12.888,3.112z" />
                            <path d="M28.184,6.471l-0.027,0.019c-2.914-3.642-7.619-1.747-7.668-1.728c-1.279,0.53-3.613,0.456-7.125-0.224
   c-0.751,0.9-1.424,1.869-2.008,2.898c0.254,0.026,0.512,0.056,0.772,0.093c5.934,0.851,11.178,3.966,14.771,8.761
   c1.25,1.67,2.248,3.474,2.979,5.364c0.8-1.87,1.24-3.932,1.24-6.092C31.115,12.167,30.029,9.027,28.184,6.471z" />
                            <path d="M19.99,3.56c1.086-0.452,2.943-0.836,4.865-0.47c-1.889-1.416-4.113-2.403-6.529-2.839
   c-1.447,0.883-2.771,1.944-3.946,3.154C17.811,4.004,19.324,3.835,19.99,3.56z" />
                            <path d="M16.574,23.626c-1.293-6.422-5.12-7.531-7.781-7.479c-0.021,0.367-0.031,0.735-0.031,1.106
   c0,5.353,1.922,10.207,5.259,13.783c0.506,0.047,1.02,0.075,1.541,0.075c2.023,0,3.961-0.387,5.739-1.092
   C18.85,29.208,17.266,27.07,16.574,23.626z" />
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

        <nav class="flex gap-4 justify-self-end">
            <a href="https://www.instagram.com/zimsko.prvenstvo.cakovec/" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                    <path
                        d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z">
                    </path>
                </svg>
            </a>
            <a href="https://www.facebook.com/ZimskoPrvenstvoCK/" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                    <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z">
                    </path>
                </svg>
            </a>
        </nav>
    </div>

    <div class="py-8 text-center bg-gradient-to-br from-secondary to-burger">
        <div class="flex gap-6 justify-center items-center mx-auto text-white uppercase wraper font-oswald">
            <a href="{{ route('home') }}" class="transition-all hover:text-primary">Početna</a>
            <a href="{{ route('results') }}" class="transition-all hover:text-primary">Rezultati</a>
            <a href="{{ route('schedule') }}" class="transition-all hover:text-primary">Raspored</a>
            <a href="{{ route('teams') }}" class="transition-all hover:text-primary">Ekipe</a>
            <a href="{{ route('galleries') }}" class="transition-all hover:text-primary">Galerije</a>
            <a href="{{ route('history') }}" class="transition-all hover:text-primary">Povijest</a>
            <a href="{{ route('contact') }}" class="transition-all hover:text-primary">Kontakt</a>
        </div>
    </div>

    <div class="grid-flow-col items-center pb-10 mx-auto wrapper">
        <p class="text-xs text-center">
            Copyright © {{ Carbon\Carbon::now()->year }} - by
            <a href="https://www.creolab.hr" target="_blank" class="transition-all hover:underline hover:text-blue-300" target="_blank">Creo</a>
        </p>
    </div>
</footer>
