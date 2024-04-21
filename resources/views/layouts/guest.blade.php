<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Classificados') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/funcoes.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <script>
        var valorEstado = "@empty($estado)@else{{$estado}}@endempty";
        var valorCidade = "@empty($cidade)@else{{$cidade}}@endempty";
    </script>
</head>

<body>
    <nav class="bg-blue-100">
        <div class="mx-auto max-w-full px-2 sm:px-6 lg:px-8">
            <div class="relative flex sm:h-16 items-center justify-between">

                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="hidden sm:ml-6 sm:block">

                        <div class="flex w-full items-center justify-between">
                            <div class="flex">
                                <!-- Logo e Pesquisar -->
                                <a class="mx-2 my-2 flex items-center" href="{{ route('classificados') }}">
                                    <img class="me-2 max-w-8 min-w-8" src="https://tecdn.b-cdn.net/img/logo/te-transparent-noshadows.webp" alt="TE Logo" loading="lazy" />
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-end">
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-blue-300 text-white", Default: "bg-blue-200 hover:bg-blue-400 hover:text-white" -->
                            <a href="/" class="bg-blue-300 text-black rounded-md px-3 py-2 text-sm font-medium hover:bg-blue-400" aria-current="page">Classificados</a>
                            @if (Route::has('login'))
                            @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-200 hover:bg-blue-400 hover:text-black rounded-md px-3 py-2 text-sm font-medium">Dashboard</a>
                            @else
                            <a href="{{ route('login') }}" class="bg-blue-200 hover:bg-blue-400 hover:text-black rounded-md px-3 py-2 text-sm font-medium">Entrar</a>

                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-blue-200 hover:bg-blue-400 hover:text-black rounded-md px-3 py-2 text-sm font-medium">Anunciar</a>
                            @endif
                            @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div id="mobile-menu" class="sm:hidden shadow-md">

            <div id="divSanduicheNavbar" class="bg-blue-300 py-3">
                <div class="grid justify-items-end w-11/12">
                    <span class="[&>svg]:w-8 [&>svg]:stroke-black">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1.3">
                            <path fill-rule="evenodd" d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
            </div>

            <div id="navbarConteudo" class="hidden">
                <div class="grid justify-items-center mb-5">
                    <img class="me-2 w-8 h-8" src="https://tecdn.b-cdn.net/img/logo/te-transparent-noshadows.webp" alt="TE Logo" loading="lazy" />
                </div>

                <div class="space-y-1 px-2 pb-3 pt-2">
                    <a href="/" class="bg-blue-300 text-black block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Classificados</a>
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="bg-blue-200 hover:bg-blue-400 hover:text-black block rounded-md px-3 py-2 text-base font-medium">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="bg-blue-200 hover:bg-blue-400 hover:text-black block rounded-md px-3 py-2 text-base font-medium">Entrar</a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-blue-200 hover:bg-blue-400 hover:text-black block rounded-md px-3 py-2 text-base font-medium">Anunciar</a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>

    @yield('scripts')
</body>

</html>