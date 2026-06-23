<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\CpfValido;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            // 📧 VALIDAÇÃO DE EMAIL: Obrigatório, formato real e único no banco (ignora o próprio usuário)
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // 🪪 VALIDAÇÃO DE CPF: Único no banco (ignora o próprio usuário) e chama a classe CpfValido
            'cpf' => [
                'required',
                'string',
                Rule::unique(User::class)->ignore($this->user()->id),
                new CpfValido(), // 👈 Chamando a classe externa que corrigimos
            ],

            'phone' => ['required', 'string'],

            // 🏠 VALIDAÇÃO DO ENDEREÇO SEPARADO
            'cep'          => ['required', 'string', 'max:9'],
            'street'       => ['required', 'string', 'max:255'],
            'number'       => ['required', 'string', 'max:50'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'city'         => ['required', 'string', 'max:255'],
            'state'        => ['required', 'string', 'max:2'],
        ];
    }

    /**
     * Mensagens de erro personalizadas em português.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O campo de e-mail é obrigatório.',
            'email.email'    => 'Por favor, insira um endereço de e-mail válido.',
            'email.unique'   => 'Este e-mail já está sendo utilizado por outra conta.',
            'cpf.required'   => 'O campo CPF é obrigatório.',
            'cpf.unique'     => 'Este CPF já está cadastrado no sistema.',
            'phone.required' => 'O campo de telefone é obrigatório.',


            'cep.required'          => 'O campo CEP é obrigatório.',
            'street.required'       => 'O campo Rua é obrigatório.',
            'number.required'       => 'O campo Número é obrigatório.',
            'neighborhood.required' => 'O campo Bairro é obrigatório.',
            'city.required'         => 'O campo Cidade é obrigatório.',
            'state.required'        => 'O campo UF é obrigatório.',
        ];
    }
}
