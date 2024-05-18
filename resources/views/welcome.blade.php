<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Carro Certo</title>

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
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDazB7D8h2Or4USL3k9TGMDmuz-vm326XA&callback=console.debug&libraries=maps,marker&v=beta"></script>

</head>

<body class="bg-neutral-800">
    <nav class="bg-neutral-950 border-b-2 border-red-600">
        <div id="menuPrincipal" class="mx-auto max-w-full pr-2 lg:pr-6 lg:pr-8">
            <div class="relative flex md:h-16 items-center justify-between">

                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="sm:ml-6 sm:block">

                        <div class="flex w-full items-center justify-between">
                            <a class="mx-2 my-2 flex items-center" href="{{ route('listarAnunciantes') }}">
                                <img class="me-2 max-w-24 min-w-8" src="{{ url('arquivos/logo.png') }}" alt="TE Logo" loading="lazy" />
                                <!-- <p class="text-base text-white font-sans font-bold">Carro<br>Certo</p> -->
                            </a>
                            <div class="flex">
                                <!-- Logo e Pesquisar -->
                                <input type="search" id="descBuscaPC" name="descBuscaPC" value="@empty($busca)@else{{$busca}}@endempty" class="relative m-0 block flex-auto rounded border border-solid bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-surface transition duration-300 ease-in-out text-white focus:shadow-inset focus:outline-none motion-reduce:transition-none focus:borda-vermelha focus:border-red-600" placeholder="Buscar" aria-label="Buscar" aria-describedby="button-addon2" />
                            </div>

                            <!-- Icone do Mapa -->
                            <span class="cursor-pointer flex items-center whitespace-nowrap rounded px-3 py-1.5 text-center text-base font-normal text-gray-600 [&>svg]:w-5" id="basic-addon2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </span>
                            <div class="flex">
                                <select id="estadoBuscaPC" name="estadoBuscaPC" class="estadoBusca block mr-1 py-2.5 px-0 w-full text-sm text-white bg-neutral-950 border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer">
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
                                <select id="cidadeBuscaPC" name="cidadeBuscaPC" class="cidadeBusca block mr-1 py-2.5 px-0 w-full text-sm text-white bg-neutral-950 border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer">
                                    <option value="">Cidade</option>
                                </select>
                            </div>
                            <span id="buscarAnuncioPC" class="cursor-pointer flex items-center whitespace-nowrap rounded px-3 py-1.5 text-center text-base font-normal text-white [&>svg]:w-5" id="basic-addon2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-white">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>

                    </div>
                </div>


                <div class="flex items-center justify-center sm:items-stretch sm:justify-end">
                    <div class="sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-blue-300 text-white", Default: "bg-blue-200 hover:bg-blue-400 hover:text-white" -->
                            <a href="/" class="bg-red-600 text-black rounded-md px-3 py-2 text-base font-semibold" aria-current="page">Classificados</a>
                            @if (Route::has('login'))
                            @auth
                            <a href="{{ url('/dashboard') }}" class="bg-red-500 hover:bg-red-600 text-black rounded-md px-3 py-2 text-base font-semibold">Dashboard</a>
                            @else
                            <a href="{{ route('login') }}" class="bg-red-500 hover:bg-red-600 text-black rounded-md px-3 py-2 text-base font-semibold">Entrar</a>

                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-red-500 hover:bg-red-600 text-black rounded-md px-3 py-2 text-base font-semibold">Anunciar</a>
                            @endif
                            @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div id="mobile-menu" class="lg:hidden shadow-md">

            <div id="divSanduicheNavbar" class="bg-neutral-950 py-3">
                <div class="grid justify-items-end w-11/12">
                    <span class="[&>svg]:w-8 [&>svg]:stroke-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1.3">
                            <path fill-rule="evenodd" d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
            </div>

            <div id="navbarConteudo" class="hidden">
                <div class="grid justify-items-center mb-5">
                    <img class="me-2 max-w-32 max-h-32" src="{{ url('arquivos/logo.png') }}" alt="TE Logo" loading="lazy" />
                </div>

                <div class="space-y-1 px-2 pb-3 pt-2">
                    <div class="">
                        <input type="search" id="descBuscaMobile" name="descBuscaMobile" class="w-full relative m-0 block flex-auto rounded border border-solid bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-surface transition duration-300 ease-in-out focus:border-primary text-white focus:shadow-inset focus:outline-none motion-reduce:transition-none focus:borda-vermelha focus:border-red-600" placeholder="Buscar" aria-label="Buscar" aria-describedby="button-addon2" />
                        <select id="estadoBuscaMobile" name="estadoBuscaMobile" class="estadoBusca block py-2.5 px-2 mt-1 w-full text-sm text-white bg-neutral-950 border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer">
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
                        <select id="cidadeBuscaMobile" name="cidadeBuscaMobile" class="cidadeBusca block py-2.5 px-2 mt-1 w-full text-sm text-white bg-neutral-950 border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer">
                            <option value="">Cidade</option>
                        </select>
                        <div class="grid justify-items-end mt-4 mb-4">
                            <span id="buscarAnuncioMobile" class="cursor-pointer flex items-center whitespace-nowrap rounded px-3 py-1.5 text-center text-base font-normal text-white [&>svg]:w-8" id="basic-addon2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-white">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <a href="/" class="bg-red-600 text-black block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Classificados</a>
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="bg-red-500 hover:bg-red-600 text-black block rounded-md px-3 py-2 text-base font-medium">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="bg-red-500 hover:bg-red-600 text-black block rounded-md px-3 py-2 text-base font-medium">Entrar</a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-red-500 hover:bg-red-600 text-black block rounded-md px-3 py-2 text-base font-medium">Anunciar</a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>




    <div class="bg-neutral-800">
        <div class="mx-auto max-w-2xl px-4 py-3 sm:px-6 sm:py-12 lg:max-w-7xl lg:px-8">
            @yield('conteudo')
        </div>
    </div>

    <!-- PopUp de Loading -->
    <div id="popupCarregando" data-te-modal-init data-te-backdrop="static" data-te-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" aria-labelledby="popupCarregandoTitle">
        <div data-te-modal-dialog-ref class="pointer-events-none relative flex flex-col justify-center items-center h-full">
            <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] text-danger motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Extra Large Modal -->
    <button type="button" id="btnProduto" data-modal-target="modalProduto" data-modal-toggle="modalProduto"></button>
    <div id="modalProduto" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-7xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-neutral-800 rounded-lg shadow-2xl border-4 rounded-lg border-gray-600 shadow-slate-600">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                    <h3 id="tituloProduto" class="text-xl font-medium text-white"></h3>
                    <button type="button" class="text-white bg-transparent hover:bg-gray-200 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modalProduto">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 text-white">
                    <div class="mb-8">
                        <span class="flex my-3 items-center text-lg font-medium me-3"><span class="flex w-3 h-3 me-3 bg-red-600 rounded-full"></span>Valor do produto</span>
                        <p>R$<span id="valorProduto"></span></p>
                    </div>
                    <div class="mb-8">
                        <span class="flex my-3 items-center text-lg font-medium me-3"><span class="flex w-3 h-3 me-3 bg-red-600 rounded-full"></span>Forma de pagamento</span>
                        <p id="formaPagamento"></p>
                    </div>
                    <div class="mb-8">
                        <span class="flex my-3 items-center text-lg font-medium me-3"><span class="flex w-3 h-3 me-3 bg-red-600 rounded-full"></span>Descrição do produto</span>
                        <p id="descricaoProduto"></p>
                    </div>
                    <div class="container mx-auto">
                        <div id="conteudoImg" class="-m-1 flex flex-wrap justify-center sm:justify-start md:-m-2">
                        </div>
                    </div>
                    <div id="videoProduto" class="flex justify-center sm:justify-start mt-10 mb-8"></div>

                    <div class="mb-8">
                        <span class="flex my-3 items-center text-lg font-medium me-3"><span class="flex w-3 h-3 me-3 bg-green-500 rounded-full"></span>Dados do Anunciante</span>
                        <p><span class="font-bold">Nome:</span> <span id="nomeEmpresa"></span></p>
                        <p class="hidden"><span class="font-bold">Email:</span> <span id="email"></span></p>
                        <p class="hidden">
                        <div class="flex items-start">
                            <span class="font-bold">
                                WhatsApp:
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="25px" height="25px" clip-rule="evenodd">
                                <path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z" />
                                <path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z" />
                                <path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z" />
                                <path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z" />
                                <path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd" />
                            </svg>
                            <a id="celular" href="#" target="_blank" class="underline"></a>
                        </div>
                        </p>
                        <p class="hidden"><span class="font-bold">Telefone:</span> <span id="telefone"></span></p>
                    </div>
                    <div class="w-auto lg:w-4/5">
                        <div id="map" style="width: auto; height: 550px; position: relative; overflow: hidden;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>