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
            'nombre'               => ['required','string','max:255'],
            'segmento'             => ['nullable','string','max:255'],
            'categoria'            => ['nullable','string','max:255'],
            'registro'             => ['nullable','string','max:255'],
            'contenido'            => ['nullable','string'],
            'usoRecomendado'       => ['nullable','string'],
            'dosisSugerida'        => ['nullable','string'],
            'intervaloAplicacion'  => ['nullable','string'],
            'controla'             => ['nullable','string'],
            'presentacion'         => ['nullable','string','max:255'],

            // Rutas (texto) — se mantienen si no se sube un archivo nuevo
            'fichaTecnica'         => ['nullable','string'],
            'hojaSeguridad'        => ['nullable','string'],

            // Archivos (opcionales)
            'fichaTecnica_file'    => ['nullable','file','mimes:pdf','max:10240'],   // 10 MB
            'hojaSeguridad_file'   => ['nullable','file','mimes:pdf','max:10240'],
            'foto'                 => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'], // 5 MB
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
