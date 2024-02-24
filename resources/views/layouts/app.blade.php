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

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @yield('scripts')

    <!-- PopUp de Loading -->
    <div id="popupCarregando" data-te-modal-init data-te-backdrop="static" data-te-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" aria-labelledby="popupCarregandoTitle">
        <div data-te-modal-dialog-ref class="pointer-events-none relative flex flex-col justify-center items-center h-full">
            <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] text-danger motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <!-- PopUp de aviso mensagem-->
    <button type="button" id="btnModalAvisoMsg" data-te-target="#avisoMsg" data-te-ripple-init data-te-ripple-color="light" data-te-toggle="modal" class="hidden"></button>
    <div id="avisoMsg" data-te-modal-init data-te-backdrop="static" data-te-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" aria-labelledby="avisoMsgTitle" >
        <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none">
                <div class="flex flex-shrink-0 items-center justify-between border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none" data-te-modal-dismiss aria-label="Close">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 id="mensagemRetorno" class="mb-5 text-lg font-normal text-gray-500"></h3>
                    <button type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100" data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                        Ok
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- PopUp de aviso exclusão-->
    <button type="button" id="btnModalAvisoExclusao" data-te-target="#avisoExclusao" data-te-ripple-init data-te-ripple-color="light" data-te-toggle="modal" class="hidden"></button>
    <div id="avisoExclusao" data-te-modal-init data-te-backdrop="static" data-te-keyboard="false" class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" tabindex="-1" aria-labelledby="avisoExclusaoTitle" aria-modal="true" role="dialog">
        <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none">
                <div class="flex flex-shrink-0 items-center justify-between border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none" data-te-modal-dismiss aria-label="Close">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Tem certeza que deseja encerrar este registro?</h3>
                    <button type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center" data-te-ripple-init data-te-ripple-color="light">
                        Sim, eu tenho
                    </button>
                    <button type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100" data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                        Não, cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>