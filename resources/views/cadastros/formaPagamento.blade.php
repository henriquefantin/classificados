<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Forma Pagamento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="" method="post">
                        @csrf
                        <div class="mb-4">
                            <label for="descricao" class="form-label">Tipo do Pagamento</label>
                            <input type="text" id="descricao" name="descricao" class="" placeholder="Descrição do tipo de pagamento Ex: Credito, boleto, pix">
                        </div>
                        <div class="mb-4">
                            <label for="parcelas" class="form-label">Limite de parcelas</label>
                            <input type="number" id="parcelas" name="parcelas" class="">
                        </div>
                        <div class="mt-6 flex items-center justify-end">
                            <button type="button" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>