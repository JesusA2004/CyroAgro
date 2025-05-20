<div class="row">
    @foreach ([
        'nombre' => 'Nombre', 'segmento' => 'Segmento', 'categoria' => 'Categoría',
        'registro' => 'Registro', 'contenido' => 'Contenido', 'presentaciones' => 'Presentaciones',
        'intervalo_aplicacion' => 'Intervalo de Aplicación', 'incompatibilidad' => 'Incompatibilidad',
        'certificacion' => 'Certificación', 'controla' => 'Controla',
        'ficha_tecnica' => 'Ficha Técnica', 'hoja_seguridad' => 'Hoja de Seguridad',
        'urlFoto' => 'URL de Foto', 'precio' => 'Precio', 'cantidad_inventario' => 'Inventario'
    ] as $field => $label)
        <div class="col-md-6 mb-3">
            <label for="{{ $field }}" class="form-label">{{ __($label) }}</label>
            <input type="text" name="{{ $field }}" class="form-control @error($field) is-invalid @enderror" value="{{ old($field, $producto?->$field) }}">
            @error($field)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endforeach
    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>