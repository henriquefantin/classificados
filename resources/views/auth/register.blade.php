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
            <div>
                <x-label for="nomeEmpresa" :value="__('Nome Empresa')" />
                <x-input id="nomeEmpresa" class="block mt-1 w-full" type="text" name="nomeEmpresa" required autofocus />
            </div>
            <div>
                <x-label for="cnpj" :value="__('CNPJ')" />
                <x-input id="cnpj" class="block mt-1 w-full" type="text" name="cnpj" required autofocus />
            </div>
            <div>
                <x-label for="telefone" :value="__('Telefone')" />
                <x-input id="telefone" class="block mt-1 w-full" type="text" name="telefone" required autofocus />
            </div>
            <div>
                <x-label for="celular" :value="__('Celular')" />
                <x-input id="celular" class="block mt-1 w-full" type="text" name="celular" required autofocus />
            </div>
            <div>
                <x-label for="cep" :value="__('CEP')" />
                <x-input id="cep" class="block mt-1 w-full" type="text" name="cep" required autofocus />
            </div>
            <div>
                <x-label for="estado" :value="__('Estado')" />
                <x-input id="estado" class="block mt-1 w-full" type="text" name="estado" required autofocus />
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
                <x-label for="complemento" :value="__('Complemento')" />
                <x-input id="complemento" class="block mt-1 w-full" type="text" name="complemento" required autofocus />
            </div>


            <!-- Dados Login -->
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
