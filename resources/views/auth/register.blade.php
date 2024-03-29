@section('scripts')
<script>
    $('#cnpj').keyup(function() {
        return mascara(this, "cnpj");
    });
    $('#cep').keyup(function() {
        return mascara(this, "cep");
    });
    $('.phoneMask').keyup(function() {
        return mascara(this, "fone");
    });
</script>
@endsection

<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="oculto">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Dados Empresa -->
            <h3 class="mb-5 font-bold">Dados da Empresa</h3>
            <div>
                <x-label for="nomeEmpresa" :value="__('Nome Empresa')" />
                <x-input id="nomeEmpresa" class="block mt-1 w-full" type="text" name="nomeEmpresa" required autofocus />
            </div>
            <div>
                <x-label for="cnpj" :value="__('CNPJ')" />
                <x-input id="cnpj" class="block mt-1 w-full" type="text" name="cnpj" required autofocus />
                <p class="mt-2 text-sm text-red-600 oculto">CNPJ inválido!</p>
            </div>
            <div class="mt-4">
                <x-label for="emailEmpresa" :value="__('Email Empresa')" />
                <x-input id="emailEmpresa" class="block mt-1 w-full" type="email" name="emailEmpresa" :value="old('email')" required />
            </div>
            <div>
                <x-label for="telefone" :value="__('Telefone')" />
                <x-input id="telefone" class="phoneMask block mt-1 w-full" type="text" name="telefone" autofocus />
            </div>
            <div>
                <x-label for="celular" :value="__('Celular')" />
                <x-input id="celular" class="phoneMask block mt-1 w-full" type="text" name="celular" autofocus />
            </div>
            <div>
                <x-label for="cep" :value="__('CEP')" />
                <x-input id="cep" class="block mt-1 w-full" type="text" name="cep" required autofocus />
            </div>
            <div>
                <x-label for="estado" :value="__('Estado')" />
                <select id="estado" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="estado" required autofocus>
                    <option value="">Selecione o Estado</option>
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
            <div>
                <x-label for="cidade" :value="__('Cidade')" />
                <x-input id="cidade" class="block mt-1 w-full" type="text" name="cidade" required autofocus />
            </div>
            <div>
                <x-label for="bairro" :value="__('Bairro')" />
                <x-input id="bairro" class="block mt-1 w-full" type="text" name="bairro" required autofocus />
            </div>
            <div>
                <x-label for="rua" :value="__('Rua')" />
                <x-input id="rua" class="block mt-1 w-full" type="text" name="rua" required autofocus />
            </div>
            <div>
                <x-label for="numero" :value="__('Número')" />
                <x-input id="numero" class="block mt-1 w-full" type="text" name="numero" required autofocus />
            </div>
            <div>
                <x-label for="complemento" :value="__('Complemento')" />
                <x-input id="complemento" class="block mt-1 w-full" type="text" name="complemento" autofocus />
            </div>


            <!-- Dados Login -->
            <h3 class="mt-10 mb-5 font-bold">Dados de Acesso</h3>
            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>