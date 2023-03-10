<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePacienteRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'cpf' => 'required:unique:paciente',
            'cns' => 'required:unique:paciente',
            'nome' => 'required',
            'nome_mae' => 'required',
            'endereco' => 'required',
            'data_nascimento' => 'required',
            'imagem' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'cpf.required' => 'O campo CPF é obrigatório!',
            'cns.required' => 'O campo CNS é obrigatório!',
            'nome.required' => 'O campo Nome é obrigatório!',
            'nome_mae.required' => 'O campo de Nome materno é obrigatório!',
            'endereco.required' => 'O campo Endereço é obrigatório!',
            'data_nascimento.required' => 'O campo Data de nascimento é obrigatório!',
            'imagem.required' => 'O campo de Imagem é obrigatório!',
        ];
    }
}
