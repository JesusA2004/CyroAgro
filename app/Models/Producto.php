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
        'nombre','segmento','categoria','registro','contenido',
        'usoRecomendado','dosisSugerida','intervaloAplicacion','controla',
        'fichaTecnica','hojaSeguridad','fotoProducto','presentacion',
        'creadoPor','modificadoPor','fechaCreacion','fechaActualizacion','FotoCatalogo'
    ];

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
