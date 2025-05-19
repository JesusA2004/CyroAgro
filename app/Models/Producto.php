<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // La PK ahora es 'id', ya no 'folio'
    protected $primaryKey = 'id';

    public $incrementing = true;
    protected $keyType = 'int';

    // Route model binding
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    protected $perPage = 20;

    // Campos masivamente asignables
    protected $fillable = [
        'nombre',
        'segmento',
        'categoria',
        'registro',
        'contenido',
        'presentaciones',
        'intervalo_aplicacion',
        'incompatibilidad',
        'certificacion',
        'controla',
        'ficha_tecnica',
        'hoja_seguridad',
        'precio',
        'cantidad_inventario',
        'urlFoto',
    ];
}
