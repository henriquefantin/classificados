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
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mt-6 flex items-center justify-start">
                            <a href="{{ route('novoAnuncio') }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cadastrar</a>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-3">
                            <label for="statusAnuncio" class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                            <select id="statusAnuncio" name="statusAnuncio" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-32 sm:text-sm sm:leading-6">
                                <option value="">Ativo</option>
                                <option value="E">Encerrado</option>
                                <option value="T">Todos</option>
                            </select>
                        </div>
                    </div>
                    <table class="mt-6 w-full border-collapse bg-white text-left text-sm text-gray-500">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium text-gray-900">Produto</th>
                                <th scope="col" class="px-6 py-4 font-medium text-gray-900">Tipo Anuncio</th>
                                <th scope="col" class="px-6 py-4 font-medium text-gray-900">Forma Pagamento</th>
                                <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                            @foreach ($lista as $reg)
                            <tr class="hover:bg-gray-50">
                                <td class="flex items-center gap-4 px-2">
                                    <div class="py-4">
                                        <img class="h-24 w-24 rounded-lg object-cover object-center" src="{{ url('arquivos/imagens/'.$reg->imagem) }}" alt="" />
                                    </div>
                                    <div class="py-4">
                                        {{ $reg->titulo }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $reg->tipo }}</td>
                                <td class="px-6 py-4">{{ $reg->pagamento }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-4">
                                        <a x-data="{ tooltip: 'Delete' }" href="{{route('encerrarAnuncio', ['id' => $reg->id]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6" x-tooltip="tooltip">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </a>
                                        <a x-data="{ tooltip: 'Edite' }" href="{{ route('editarAnuncio', ['id' => $reg->id]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6" x-tooltip="tooltip">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>