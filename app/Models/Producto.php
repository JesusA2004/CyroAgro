<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // 1) El nombre de la PK no es "id" sino "folio"
    protected $primaryKey = 'folio';

    // 2) Sigue siendo autoincremental e integer
    public $incrementing = true;
    protected $keyType = 'int';

    // 3) Para que el route‑model binding use `folio` en lugar de `id`
    public function getRouteKeyName(): string
    {
        return 'folio';
    }

    // 4) Por página en tu paginación
    protected $perPage = 20;

    // 5) Campos masivamente asignables (no incluyas folio aquí)
    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'cantidad_inventario',
    ];
    
}
