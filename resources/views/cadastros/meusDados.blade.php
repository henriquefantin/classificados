@section('scripts')
<script>
    $(document).ready(function() {
        $('#cnpj').keyup(function() {
            return mascara(this, "cnpj");
        });
        $('#cep').keyup(function() {
            return mascara(this, "cep");
        });
        $('.phoneMask').keyup(function() {
            return mascara(this, "fone");
        });

        @empty($usuario)
        @else
        $("#name").val("{{$usuario->name}}");
        $("#email").val("{{$usuario->email }}");
        @endempty

        @empty($empresa)
        @else
        $("#nomeEmpresa").val("{{$empresa->nome}}");
        $("#cnpj").val("{{$empresa->cnpj}}");
        $("#emailEmpresa").val("{{$empresa->email}}");
        $("#telefone").val("{{$empresa->telefone}}");
        $("#celular").val("{{$empresa->celular}}");
        $("#cep").val("{{$empresa->cep}}").keyup();
        $("#numero").val("{{$empresa->numero}}").keyup();
        $("#complemento").val("{{$empresa->complemento}}").keyup();
        @endempty
    });
</script>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Dados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="max-auto max-w-2xl">
                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        
                        <form id="formCadastro" name="formCadastro" action="{{ route('atualizarMeusDados') }}" method="post" autocomplete="off">
                            @csrf

                            <!-- Dados Empresa -->
                            <span class="flex my-5 items-center text-xl font-medium text-gray-900"><span class="flex w-2.5 h-2.5 bg-purple-500 rounded-full me-1.5 flex-shrink-0"></span>Dados da Empresa</span>
                            <div class="mt-4">
                                <x-label for="nomeEmpresa" :value="__('Nome Empresa')" />
                                <x-input id="nomeEmpresa" class="block mt-1 w-full" type="text" name="nomeEmpresa" required autofocus />
                            </div>
                            <div class="mt-4">
                                <x-label for="cnpj" :value="__('CNPJ')" />
                                <x-input id="cnpj" class="block mt-1 w-full" type="text" name="cnpj" required autofocus />
                                <p class="mt-2 text-sm text-red-600 oculto">CNPJ inválido!</p>
                            </div>
                            <div class="mt-4">
                                <x-label for="emailEmpresa" :value="__('Email de Contato')" />
                                <x-input id="emailEmpresa" class="block mt-1 w-full" type="email" name="emailEmpresa" :value="old('email')" required />
                            </div>
                            <div class="mt-4">
                                <x-label for="telefone" :value="__('Telefone')" />
                                <x-input id="telefone" class="phoneMask block mt-1 w-full" type="text" name="telefone" autofocus />
                            </div>
                            <div class="mt-4">
                                <x-label for="celular" :value="__('WhatsApp')" />
                                <x-input id="celular" class="phoneMask block mt-1 w-full" type="text" name="celular" autofocus />
                            </div>
                            <div class="mt-4">
                                <x-label for="cep" :value="__('CEP')" />
                                <x-input id="cep" class="block mt-1 w-full" type="text" name="cep" required autofocus />
                            </div>
                            <div class="mt-4">
                                <x-label for="estado" :value="__('Estado')" />
                                <select id="estado" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="estado" required autofocus>
                                    <option value="">Selecione</option>
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
                            </div>
                            <div class="mt-4">
                                <x-label for="cidade" :value="__('Cidade')" />
                                <x-input id="cidade" class="block mt-1 w-full" type="text" name="cidade" required autofocus />
                            </div>
                            <div class="mt-4">
                                <x-label for="bairro" :value="__('Bairro')" />
                                <x-input id="bairro" class="block mt-1 w-full" type="text" name="bairro" required autofocus />
                            </div>
                            <div class="mt-4">
                                <x-label for="rua" :value="__('Rua')" />
                                <x-input id="rua" class="block mt-1 w-full" type="text" name="rua" required autofocus />
                            </div>
                            <div class="mt-4">
                                <x-label for="numero" :value="__('Número')" />
                                <x-input id="numero" class="block mt-1 w-full" type="text" name="numero" required autofocus />
                            </div>
                            <div class="mt-4">
                                <x-label for="complemento" :value="__('Complemento')" />
                                <x-input id="complemento" class="block mt-1 w-full" type="text" name="complemento" autofocus />
                            </div>


                            <!-- Dados Login -->
                            <span class="flex mt-20 my-5 items-center text-xl font-medium text-gray-900"><span class="flex w-2.5 h-2.5 bg-purple-500 rounded-full me-1.5 flex-shrink-0"></span>Dados de Acesso</span>
                            <!-- Name -->
                            <div class="mt-4">
                                <x-label for="name" :value="__('Name')" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-label for="email" :value="__('Email de Acesso')" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-label for="password" :value="__('Senha')" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-label for="password_confirmation" :value="__('Confirmar Senha')" />
                                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" id="btnGravar" name="btnGravar" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>