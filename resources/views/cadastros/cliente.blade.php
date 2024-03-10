@section('scripts')
<script>
    $("#btnGravar").click(function() {
        let modal = document.getElementById('popupCarregando');
        if (validarFormulario("formCadastro", "obrigatorio")) {
            modal.classList.remove('hidden');

            let formData = new FormData(document.getElementById('formCadastro'));
            $.ajax({
                url: "{{ $actionForm }}",
                type: "POST",
                cache: false,
                processData: false, // Não processar os dados
                contentType: false, // Não configurar o tipo de conteúdo
                data: formData,
                error: function() {
                    modal.classList.add('hidden');
                },
                success: function(data) {
                    modal.classList.add('hidden');
                    if (data.success) {
                        window.location.href = "{{ route('listarClientes') }}?mensagem=" + encodeURIComponent(data.msg);
                    } else {
                        $('#btnModalAvisoMsg').click();
                        $('#mensagemRetorno').text(data.msg);
                    }
                }
            });
        }
    });
</script>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="max-auto max-w-2xl">
                        <form id="formCadastro" name="formCadastro" action="#" method="post" autocomplete="off">
                            @csrf
                            <div class="grid grid-cols-3">
                                <div class="mb-4 col-span-3">
                                    <label for="empresa" class="block text-sm font-medium leading-6 text-gray-900">Empresa</label>
                                    <input type="text" id="empresa" name="empresa" value="@empty($empresa)@else{{$empresa->nome}}@endempty" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" disabled>
                                </div>
                                <div class="mb-4 col-span-1 col-start-1">
                                    <label for="cnpj" class="block text-sm font-medium leading-6 text-gray-900">CNPJ</label>
                                    <input type="text" id="cnpj" name="cnpj" value="@empty($empresa)@else{{$empresa->cnpj}}@endempty" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" disabled>
                                </div>
                                <div class="mt-6 flex items-center justify-end col-span-3">
                                    <button type="button" id="btnGravar" name="btnGravar" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>