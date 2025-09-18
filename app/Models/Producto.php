<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $table = 'productos';

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $perPage = 20;

    protected $fillable = [
        'nombre','segmento','categoria','registro','contenido',
        'usoRecomendado','dosisSugerida','intervaloAplicacion','controla',
        'fichaTecnica','hojaSeguridad','fotoProducto','presentacion',
        'creadoPor','modificadoPor','fechaCreacion','fechaActualizacion','FotoCatalogo'
    ];

    // Route model binding por id (tal como lo estás usando)
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /** Relación 1:1 con destacado */
    public function featured(): HasOne
    {
        return $this->hasOne(FeaturedProduct::class, 'product_id');
    }

    /** (Opcional) Relación con usuarios si agregas created_by/updated_by en DB */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope: productos con destacado ACTIVO y VIGENTE (por fecha)
     * Uso: Producto::destacadosVigentes()->get();
     */
    public function scopeDestacadosVigentes($q)
    {
        $now = now();
        return $q->whereHas('featured', function($qq) use ($now) {
                $qq->where('is_active', true)
                   ->where(function($w) use ($now){
                       $w->whereNull('starts_at')->orWhere('starts_at','<=',$now);
                   })
                   ->where(function($w) use ($now){
                       $w->whereNull('ends_at')->orWhere('ends_at','>=',$now);
                   });
            })
            ->with(['featured' => function($r){
                $r->select(['id','product_id','position','is_active','starts_at','ends_at']);
            }]);
    }
}
