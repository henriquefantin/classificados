@section('scripts')
<script>
    @empty($produto)
    @else
    $("#descricao").val("{{$produto->descricao}}");
    $("#codFormaPagamento").val("{{$produto->codFormaPagamento}}");
    $("#codTipoAnuncio").val("{{$produto->codTipoAnuncio}}");
    @endempty
</script>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Anuncios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="max-auto max-w-2xl">
                        <form id="form" name="form" action="{{ $actionForm }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="nome" class="block text-sm font-medium leading-6 text-gray-900">Nome</label>
                                <input type="text" id="nome" name="nome" value="@empty($produto)@else{{$produto->titulo}}@endempty" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Nome do produto">
                            </div>
                            <div class="mb-4">
                                <label for="descricao" class="block text-sm font-medium leading-6 text-gray-900">Descrição</label>
                                <textarea id="descricao" name="descricao" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" rows="4" placeholder="Descrição do produto"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="codFormaPagamento" class="block text-sm font-medium leading-6 text-gray-900">Forma de Pagamento</label>
                                <select id="codFormaPagamento" name="codFormaPagamento" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option value="">-- Selecione --</option>
                                    @foreach($formaPagamento as $val)
                                    <option value="{{ $val->id }}">{{$val->descricao}} - (até {{$val->limiteParcelas}}x)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="codTipoAnuncio" class="block text-sm font-medium leading-6 text-gray-900">Tipo do Anuncio</label>
                                <select id="codTipoAnuncio" name="codTipoAnuncio" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option value="">-- Selecione --</option>
                                    @foreach($tipoAnuncio as $val)
                                    <option value="{{ $val->id }}">{{$val->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Imagens do produto</label>
                                <div class="mt-4 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                            <label for="imagensUpload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                                <span>Selecione as fotos</span>
                                                <input id="imagensUpload" name="imagensUpload[]" type="file" class="sr-only" multiple>
                                            </label>
                                            <!-- <p class="pl-1">ou arraste e solte</p> -->
                                        </div>
                                        <p class="text-xs leading-5 text-gray-600">PNG, JPG até 10MB</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Video do produto</label>
                                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                            <label for="videoUpload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                                <span>Selecione um vídeo</span>
                                                <input id="videoUpload" name="videoUpload" type="file" class="sr-only">
                                            </label>
                                            <!-- <p class="pl-1">ou arraste e solte</p> -->
                                        </div>
                                        <p class="text-xs leading-5 text-gray-600">MP4, AVI até 25MB</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                @empty($imagens)
                                @else
                                <div class="flex justify-center">
                                    <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->
                                    <div id="carroselImagens" class="relative w-9/12" data-te-carousel-init data-te-ride="carousel">
                                        <!--Carousel indicators-->
                                        <div class="absolute bottom-0 left-0 right-0 z-[2] mx-[15%] mb-4 flex list-none justify-center p-0" data-te-carousel-indicators>
                                            @for ($i = 0; $i < count($imagens); $i++)
                                                @if ($i > 0)
                                                <button type="button" data-te-target="#carroselImagens" data-te-slide-to="{{ $i }}" class="mx-[3px] box-content h-[3px] w-[30px] flex-initial cursor-pointer border-0 border-y-[10px] border-solid border-transparent bg-white bg-clip-padding p-0 -indent-[999px] opacity-50 transition-opacity duration-[600ms] ease-[cubic-bezier(0.25,0.1,0.25,1.0)] motion-reduce:transition-none" aria-label="Slide {{ $i + 1 }}"></button>
                                                @else
                                                <button type="button" data-te-target="#carroselImagens" data-te-slide-to="{{ $i }}" data-te-carousel-active class="mx-[3px] box-content h-[3px] w-[30px] flex-initial cursor-pointer border-0 border-y-[10px] border-solid border-transparent bg-white bg-clip-padding p-0 -indent-[999px] opacity-50 transition-opacity duration-[600ms] ease-[cubic-bezier(0.25,0.1,0.25,1.0)] motion-reduce:transition-none" aria-current="true" aria-label="Slide {{ $i + 1 }}"></button>
                                                @endif
                                            @endfor
                                            @empty($video)
                                            @else
                                                <button type="button" data-te-target="#carroselImagens" data-te-slide-to="{{ count($imagens) }}" class="mx-[3px] box-content h-[3px] w-[30px] flex-initial cursor-pointer border-0 border-y-[10px] border-solid border-transparent bg-white bg-clip-padding p-0 -indent-[999px] opacity-50 transition-opacity duration-[600ms] ease-[cubic-bezier(0.25,0.1,0.25,1.0)] motion-reduce:transition-none" aria-label="Slide {{ count($imagens) + 1 }}"></button>
                                            @endempty
                                        </div>

                                        <!--Carousel items-->
                                        <div class="relative w-full overflow-hidden after:clear-both after:block after:content-[''] rounded-lg">
                                            @for ($i = 0; $i < count($imagens); $i++)
                                                @if ($i > 0)
                                                <!--Second item-->
                                                <div class="relative float-left -mr-[100%] hidden w-full transition-transform duration-[600ms] ease-in-out motion-reduce:transition-none" data-te-carousel-item>
                                                    <img src="{{ $imagens[$i] }}" class="block rounded-lg w-full h-80" alt="..." />
                                                </div>
                                                @else
                                                <!--First item-->
                                                <div class="relative float-left -mr-[100%] w-full transition-transform duration-[600ms] ease-in-out motion-reduce:transition-none" data-te-carousel-active data-te-carousel-item>
                                                    <img src="{{ $imagens[$i] }}" class="block rounded-lg w-full h-80" alt="..." />
                                                </div>
                                                @endif
                                            @endfor
                                            @empty($video)
                                            @else
                                            <div class="relative float-left -mr-[100%] hidden w-full !transform-none opacity-0 transition-opacity duration-[600ms] ease-in-out motion-reduce:transition-none" data-te-carousel-fade data-te-carousel-item>
                                                <video class="block rounded-lg w-full max-h-80" autoplay muted>
                                                    <source src="{{ $video[0] }}" type="video/mp4">
                                                </video>
                                            </div>
                                            @endempty
                                        </div>

                                        <!--Carousel controls - prev item-->
                                        <button class="absolute bottom-0 left-0 top-0 z-[1] flex w-[15%] items-center justify-center border-0 bg-none p-0 text-center text-white opacity-50 transition-opacity duration-150 ease-[cubic-bezier(0.25,0.1,0.25,1.0)] hover:text-white hover:no-underline hover:opacity-90 hover:outline-none focus:text-white focus:no-underline focus:opacity-90 focus:outline-none motion-reduce:transition-none" type="button" data-te-target="#carroselImagens" data-te-slide="prev">
                                            <span class="inline-block h-8 w-8">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                                </svg>
                                            </span>
                                            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Previous</span>
                                        </button>
                                        <!--Carousel controls - next item-->
                                        <button class="absolute bottom-0 right-0 top-0 z-[1] flex w-[15%] items-center justify-center border-0 bg-none p-0 text-center text-white opacity-50 transition-opacity duration-150 ease-[cubic-bezier(0.25,0.1,0.25,1.0)] hover:text-white hover:no-underline hover:opacity-90 hover:outline-none focus:text-white focus:no-underline focus:opacity-90 focus:outline-none motion-reduce:transition-none" type="button" data-te-target="#carroselImagens" data-te-slide="next">
                                            <span class="inline-block h-8 w-8">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                </svg>
                                            </span>
                                            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Next</span>
                                        </button>
                                    </div>
                                </div>
                                @endempty
                            </div>
                            <div class="mt-6 flex items-center justify-end">
                                <button type="button" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>