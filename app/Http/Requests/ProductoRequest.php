<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:150',
            'segmento' => 'required|string|max:50',
            'categoria' => 'required|string|max:100',
            'registro' => 'nullable|string|max:100',
            'contenido' => 'nullable|string',
            'presentaciones' => 'nullable|string',
            'intervalo_aplicacion' => 'nullable|string',
            'incompatibilidad' => 'nullable|string',
            'certificacion' => 'nullable|string',
            'controla' => 'nullable|string',
            'ficha_tecnica' => 'nullable|string',
            'hoja_seguridad' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'cantidad_inventario' => 'required|integer|min:0',
            'urlFoto' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'numeric' => 'El campo :attribute debe ser numérico.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'max' => 'El campo :attribute no debe exceder :max caracteres.',
            'min' => 'El campo :attribute debe ser al menos :min.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre' => 'nombre',
            'segmento' => 'segmento',
            'categoria' => 'categoría',
            'registro' => 'registro',
            'contenido' => 'contenido',
            'presentaciones' => 'presentaciones',
            'intervalo_aplicacion' => 'intervalo de aplicación',
            'incompatibilidad' => 'incompatibilidad',
            'certificacion' => 'certificación',
            'controla' => 'controla',
            'ficha_tecnica' => 'ficha técnica',
            'hoja_seguridad' => 'hoja de seguridad',
            'precio' => 'precio',
            'cantidad_inventario' => 'inventario',
            'urlFoto' => 'imagen del producto',
        ];
    }
}
