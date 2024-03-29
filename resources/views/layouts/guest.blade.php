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
</head>

<body>
    <nav class="bg-blue-100 relative flex w-full flex-wrap items-center justify-between lg:py-4">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="flex w-full flex-wrap items-center justify-between px-3">
                    <div class="flex flex-shrink-0 items-center">
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                    </div>

                    <div class="flex">
                        <!-- Brand -->
                        <a class="mx-2 my-1 flex items-center lg:mb-0 lg:mt-0" href="#">
                            <img class="me-2" src="https://tecdn.b-cdn.net/img/logo/te-transparent-noshadows.webp" style="height: 20px" alt="TE Logo" loading="lazy" />
                        </a>
                        <form class="hidden md:flex">
                            <div class="flex w-[30%] items-center justify-between">
                                <input type="search" class="relative m-0 block flex-auto rounded border border-solid border-secondary-500 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-surface transition duration-300 ease-in-out focus:border-primary focus:text-gray-700 focus:shadow-inset focus:outline-none motion-reduce:transition-none" placeholder="Search" aria-label="Search" aria-describedby="button-addon2" />

                                <!-- Icone do Mapa -->
                                <span class="cursor-pointer flex items-center whitespace-nowrap rounded px-3 py-1.5 text-center text-base font-normal text-gray-600 [&>svg]:w-5" id="basic-addon2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </span>

                                <!--Search icon-->
                                <span class="cursor-pointer flex items-center whitespace-nowrap rounded px-3 py-1.5 text-center text-base font-normal text-gray-600 [&>svg]:w-5" id="basic-addon2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </form>
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
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu">
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
    </nav>

    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>

    @yield('scripts')
</body>

</html>