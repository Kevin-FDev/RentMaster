<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-200">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-gray-900 dark:text-gray-900 dark:bg-white" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full text-gray-900 dark:text-gray-900 dark:bg-white" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-2 dark:focus:ring-indigo-600">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div>
            <x-input-label for="cpf" :value="__('CPF')" />
            <x-text-input id="cpf" name="cpf" type="text" class="mt-1 block w-full text-gray-900 dark:text-gray-900 dark:bg-white" :value="old('cpf', $user->cpf)" required autocomplete="cpf" />
            <x-input-error class="mt-2" :messages="$errors->get('cpf')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Telefone / WhatsApp')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full text-gray-900 dark:text-gray-900 dark:bg-white" :value="old('phone', $user->phone)" required autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div class="md:col-span-2">
                <x-input-label for="cep" :value="__('CEP')" />
                <x-text-input id="cep" name="cep" type="text" class="mt-1 block w-full text-gray-900 dark:text-gray-900 dark:bg-white" :value="old('cep', $user->cep)" required autocomplete="postal-code" />
                <x-input-error class="mt-2" :messages="$errors->get('cep')" />
            </div>

            <div class="md:col-span-3">
                <x-input-label for="street" :value="__('Rua / Logradouro')" />
                <x-text-input id="street" name="street" type="text" class="mt-1 block w-full text-gray-900 dark:text-gray-900 dark:bg-white" :value="old('street', $user->street)" required autocomplete="street-address" />
                <x-input-error class="mt-2" :messages="$errors->get('street')" />
            </div>

            <div class="md:col-span-1">
                <x-input-label for="number" :value="__('Número')" />
                <x-text-input id="number" name="number" type="text" class="mt-1 block w-full text-gray-900 dark:text-gray-900 dark:bg-white" :value="old('number', $user->number)" required />
                <x-input-error class="mt-2" :messages="$errors->get('number')" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="neighborhood" :value="__('Bairro')" />
                <x-text-input id="neighborhood" name="neighborhood" type="text" class="mt-1 block w-full text-gray-900 dark:text-gray-900 dark:bg-white" :value="old('neighborhood', $user->neighborhood)" required />
                <x-input-error class="mt-2" :messages="$errors->get('neighborhood')" />
            </div>

            <div class="md:col-span-3">
                <x-input-label for="city" :value="__('Cidade')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full text-gray-900 dark:text-gray-900 dark:bg-white" :value="old('city', $user->city)" required />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>

            <div class="md:col-span-1">
                <x-input-label for="state" :value="__('UF')" />
                <x-text-input id="state" name="state" type="text" maxlength="2" class="mt-1 block w-full text-gray-900 dark:text-gray-900 dark:bg-white" :value="old('state', $user->state)" required placeholder="EX: SP" />
                <x-input-error class="mt-2" :messages="$errors->get('state')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cpfInput = document.getElementById('cpf');
        const phoneInput = document.getElementById('phone');
        const cepInput = document.getElementById('cep');

        // Máscara de CEP (00000-000)
        cepInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 8) value = value.slice(0, 8);
            value = value.replace(/^(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        });

        // Evento de Blur para Buscar o CEP na API
        cepInput.addEventListener('blur', function(e) {
            let cep = e.target.value.replace(/\D/g, '');

            if (cep.length === 8) {
                document.getElementById('street').value = 'Buscando...';
                document.getElementById('neighborhood').value = 'Buscando...';
                document.getElementById('city').value = 'Buscando...';
                document.getElementById('state').value = '...';

                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('street').value = data.logradouro;
                            document.getElementById('neighborhood').value = data.bairro;
                            document.getElementById('city').value = data.localidade;
                            document.getElementById('state').value = data.uf;

                            // Move o foco para o número
                            setTimeout(() => {
                                document.getElementById('number').focus();
                            }, 50);
                        } else {
                            alert('CEP não encontrado.');
                            limparCamposEndereco();
                        }
                    })
                    .catch(() => {
                        alert('Erro ao conectar na API de CEP.');
                        limparCamposEndereco();
                    });
            }
        });

        function limparCamposEndereco() {
            document.getElementById('street').value = '';
            document.getElementById('neighborhood').value = '';
            document.getElementById('city').value = '';
            document.getElementById('state').value = '';
        }

        // Máscara de CPF Corrigida
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);

            if (value.length > 9) {
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})$/, '$1.$2.$3-$4');
            } else if (value.length > 6) {
                value = value.replace(/(\d{3})(\d{3})(\d{1,3})$/, '$1.$2.$3');
            } else if (value.length > 3) {
                value = value.replace(/(\d{3})(\d{1,3})$/, '$1.$2');
            }
            e.target.value = value;
        });

        // Máscara de Telefone Corrigida
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);

            if (value.length > 6) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
            } else if (value.length > 2) {
                value = value.replace(/^(\d{2})(\d{1,5})$/, '($1) $2');
            }
            e.target.value = value;
        });
    });
</script>
