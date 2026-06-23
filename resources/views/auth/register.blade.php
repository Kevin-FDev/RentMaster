<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" x-data="{
        cep: '{{ old('cep') }}',
        logradouro: '{{ old('logradouro') }}',
        bairro: '{{ old('bairro') }}',
        cidade: '{{ old('cidade') }}',
        estado: '{{ old('estado') }}',

        buscarCep() {
            let limpo = this.cep.replace(/\D/g, '');
            if (limpo.length === 8) {
                this.logradouro = 'Buscando...';
                this.bairro = 'Buscando...';
                this.cidade = 'Buscando...';
                this.estado = '...';

                fetch(`https://viacep.com.br/ws/${limpo}/json/`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data.erro) {
                            this.logradouro = data.logradouro;
                            this.bairro = data.bairro;
                            this.cidade = data.localidade;
                            this.estado = data.uf;
                            // Foca automaticamente no campo de número
                            document.getElementById('numero').focus();
                        } else {
                            alert('CEP não encontrado.');
                            this.limpar();
                        }
                    })
                    .catch(() => {
                        alert('Erro ao buscar CEP.');
                        this.limpar();
                    });
            }
        },
        limpar() {
            this.logradouro = '';
            this.bairro = '';
            this.cidade = '';
            this.estado = '';
        }
    }">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="cpf" :value="__('CPF')" />
            <x-text-input id="cpf" class="block mt-1 w-full" type="text" name="cpf" :value="old('cpf')" required />
            <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="phone" :value="__('Telefone / WhatsApp')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Endereço de Entrega</h3>

            <div>
                <label for="cep" class="block font-medium text-sm text-gray-700 dark:text-gray-300">CEP</label>
                <input id="cep" type="text" name="cep" x-model="cep" x-on:blur="buscarCep()" placeholder="Ex: 01001000" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                <x-input-error :messages="$errors->get('cep')" class="mt-2" />
            </div>

            <div class="grid grid-cols-3 gap-4 mt-4">
                <div class="col-span-2">
                    <label for="logradouro" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Rua / Logradouro</label>
                    <input id="logradouro" type="text" name="logradouro" x-model="logradouro" class="border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                    <x-input-error :messages="$errors->get('logradouro')" class="mt-2" />
                </div>
                <div>
                    <label for="numero" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Número</label>
                    <input id="numero" type="text" name="numero" value="{{ old('numero') }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                    <x-input-error :messages="$errors->get('numero')" class="mt-2" />
                </div>
            </div>

            <div class="mt-4">
                <label for="bairro" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Bairro</label>
                <input id="bairro" type="text" name="bairro" x-model="bairro" class="border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                <x-input-error :messages="$errors->get('bairro')" class="mt-2" />
            </div>

            <div class="grid grid-cols-3 gap-4 mt-4">
                <div class="col-span-2">
                    <label for="cidade" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Cidade</label>
                    <input id="cidade" type="text" name="cidade" x-model="cidade" class="border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                    <x-input-error :messages="$errors->get('cidade')" class="mt-2" />
                </div>
                <div>
                    <label for="estado" class="block font-medium text-sm text-gray-700 dark:text-gray-300">UF</label>
                    <input id="estado" type="text" name="estado" x-model="estado" class="border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                    <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
