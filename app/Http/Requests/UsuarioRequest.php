<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El correo electronico es obligatorio',
            'email.email' => 'El correo no es válido'
        ];
    }
}
