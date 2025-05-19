<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class UsuarioRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta petición.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Reglas de validación para el request.
     */
    public function rules(): array
    {
        // Capturamos el modelo inyectado por route‑model binding.
        // Puede venir como 'user' o como 'usuario' según tu definición de ruta.
        $usuario = $this->route('user') ?? $this->route('usuario');
        $userId  = $usuario?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:101',
                // Ignora el usuario actual al validar unicidad
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => $this->isMethod('POST')
                ? ['required', 'string', 'min:8', 'confirmed']
                : ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['empleado', 'cliente', 'administrador'])],
        ];
    }

    /**
     * Atributos personalizados para los mensajes de error.
     */
    public function attributes(): array
    {
        return [
            'name'     => 'nombre de usuario',
            'email'    => 'correo electrónico',
            'password' => 'contraseña',
            'role'     => 'rol de usuario',
        ];
    }

    /**
     * Mensajes de error personalizados.
     */
    public function messages(): array
    {
        return [
            'email.unique'     => 'El correo ya ha sido registrado.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
    
}
