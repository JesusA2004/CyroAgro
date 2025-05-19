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
            'urlFoto' => 'required|string|max:255',
        ];
    }
    
}
