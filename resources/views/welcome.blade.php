<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Classificados</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Estilos -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/funcoes.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>

<body class="">
    <nav class="bg-blue-100">
        <input type="hidden" id="urlClassificados" name="urlClassificados" value="{{ route('classificados') }}">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex sm:h-16 items-center justify-between">

                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="hidden sm:ml-6 sm:block">

                        <div class="flex w-full items-center justify-between">
                            <div class="flex">
                                <!-- Logo e Pesquisar -->
                                <a class="mx-2 my-2 flex items-center" href="#">
                                    <img class="me-2 h-3 w-3 lg:h-5 lg:w-5" src="https://tecdn.b-cdn.net/img/logo/te-transparent-noshadows.webp" alt="TE Logo" loading="lazy" />
                                </a>
                                <input type="search" id="descBuscaPC" name="descBuscaPC" class="relative m-0 block flex-auto rounded border border-solid border-secondary-500 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-surface transition duration-300 ease-in-out focus:border-primary focus:text-gray-700 focus:shadow-inset focus:outline-none motion-reduce:transition-none" placeholder="Buscar" aria-label="Buscar" aria-describedby="button-addon2" />
                            </div>

                            <!-- Icone do Mapa -->
                            <span class="cursor-pointer flex items-center whitespace-nowrap rounded px-3 py-1.5 text-center text-base font-normal text-gray-600 [&>svg]:w-5" id="basic-addon2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </span>
                            <div class="flex">
                                <select id="estadoBuscaPC" name="estadoBuscaPC" class="estadoBusca block mr-1 py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-secondary-500 appearance-none focus:outline-none focus:ring-0 focus:border-secondary-500 peer">
                                    <option value="">Estado</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                                <select id="cidadeBuscaPC" name="cidadeBuscaPC" class="cidadeBusca block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-secondary-500 appearance-none focus:outline-none focus:ring-0 focus:border-secondary-500 peer">
                                    <option value="">Cidade</option>
                                </select>
                            </div>
                            <span class="buscarAnuncioPC cursor-pointer flex items-center whitespace-nowrap rounded px-3 py-1.5 text-center text-base font-normal text-gray-600 [&>svg]:w-5" id="basic-addon2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </span>
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

            <div id="divSanduicheNavbar" class="bg-blue-300 mb-5 py-3">
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
                    <div class="">
                        <input type="search" id="descBuscaMobile" name="descBuscaMobile" class="w-full relative m-0 block flex-auto rounded border border-solid border-secondary-500 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-surface transition duration-300 ease-in-out focus:border-primary focus:text-gray-700 focus:shadow-inset focus:outline-none motion-reduce:transition-none" placeholder="Buscar" aria-label="Buscar" aria-describedby="button-addon2" />
                        <select id="estadoBuscaMobile" name="estadoBuscaMobile" class="estadoBusca block py-2.5 px-2 mt-1 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-secondary-500 appearance-none focus:outline-none focus:ring-0 focus:border-secondary-500 peer">
                            <option value="">Estado</option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                        <select id="cidadeBuscaMobile" name="cidadeBuscaMobile" class="cidadeBusca block py-2.5 px-2 mt-1 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-secondary-500 appearance-none focus:outline-none focus:ring-0 focus:border-secondary-500 peer">
                            <option value="">Cidade</option>
                        </select>
                        <div class="grid justify-items-end mt-4 mb-4">
                            <span class="buscarAnuncioMobile cursor-pointer flex items-center whitespace-nowrap rounded px-3 py-1.5 text-center text-base font-normal text-gray-600 [&>svg]:w-8" id="basic-addon2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </div>

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




    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">

            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">


                @foreach ($lista as $reg)
                <div class="group relative border-solid border rounded border-gray-200 shadow-md hover:shadow-xl">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-t bg-gray-200 lg:aspect-none group-hover:opacity-85 lg:h-80">
                        <img src="{{ url('arquivos/imagens/'.$reg->imagem) }}" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                    <div class="mt-4 flex justify-between p-1">
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <a href="#">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $reg->titulo }}
                                </a>
                            </h3>
                        </div>
                        <p class="text-sm font-medium text-gray-900 p-1">R$ {{ campoVazio($reg->valor) }}</p>
                    </div>
                    <p class="mt-1 text-justify text-sm text-gray-500 p-1">{{ limiteDesc($reg->descricao) }}</p>
                </div>

                <!-- More products... -->
                @endforeach
            </div>
        </div>
    </div>

</body>

</html>

<?php
function campoVazio($valor)
{
    if ($valor != null && $valor != "") {
        return $valor;
    } else {
        return "-";
    }
}

function limiteDesc($valor)
{
    return mb_strimwidth($valor, 0, 100, "...");
}
?>