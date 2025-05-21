<div class="container product-form p-4 shadow rounded-4 bg-white">
    <div class="row">
        @foreach ([
                'nombre' => 'Nombre',
                'segmento' => 'Segmento',
                'categoria' => 'Categoría',
                'registro' => 'Registro',
                'contenido' => 'Contenido',
                'presentaciones' => 'Presentaciones',
                'intervalo_aplicacion' => 'Intervalo de Aplicación',
                'incompatibilidad' => 'Incompatibilidad',
                'certificacion' => 'Certificación',
                'controla' => 'Controla',
                'precio' => 'Precio',
                'cantidad_inventario' => 'Inventario'
            ] as $field => $label)
            <div class="col-md-6 mb-4">
                <label for="{{ $field }}" class="form-label fw-semibold">{{ __($label) }}</label>
                <input type="text" name="{{ $field }}" id="{{ $field }}"
                       class="form-control rounded-3 shadow-sm @error($field) is-invalid @enderror"
                       value="{{ old($field, $producto?->$field) }}">
                @error($field)
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @endforeach
        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary px-5 py-2 shadow">Guardar</button>
        </div>
    </div>
</div>
