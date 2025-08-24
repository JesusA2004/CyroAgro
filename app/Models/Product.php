<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    // Tu tabla real
    protected $table = 'productos';

    // No usas timestamps de Laravel
    public $timestamps = false;

    // Campos asignables de tu esquema
    protected $fillable = [
        'id',
        'nombre',
        'segmento',
        'categoria',
        'registro',
        'contenido',
        'usoRecomendado',
        'dosisSugerida',
        'intervaloAplicacion',
        'controla',
        'fichaTecnica',
        'hojaSeguridad',
        'fotoProducto',
        'presentacion',
        'creadoPor',
        'modificadoPor',
        'fechaCreacion',
        'fechaActualizacion',
        'FotoCatalogo',
    ];

    // ========================
    // ACCESSORS / HELPERS
    // ========================

    // URL de “botella” (foto principal)
    public function getBotellaUrlAttribute(): string
    {
        if (!empty($this->fotoProducto)) {
            return asset(ltrim($this->fotoProducto, '/'));
        }
        // fallback al catálogo si no hay fotoProducto
        if (!empty($this->FotoCatalogo)) {
            return asset(ltrim($this->FotoCatalogo, '/'));
        }
        return asset('img/defaults/botella.png');
    }

    // Banner/cabecera (usamos FotoCatalogo si existe)
    public function getBannerUrlAttribute(): string
    {
        if (!empty($this->FotoCatalogo)) {
            return asset(ltrim($this->FotoCatalogo, '/'));
        }
        return asset('img/defaults/banner-producto.jpg');
    }

    // Logo (si algún día lo agregas; por ahora usa FotoCatalogo)
    public function getLogoUrlAttribute(): string
    {
        if (!empty($this->FotoCatalogo)) {
            return asset(ltrim($this->FotoCatalogo, '/'));
        }
        return asset('img/defaults/logo.png');
    }

    // Ficha/Hoja (normalizamos a URLs absolutas)
    public function getHojaTecnicaUrlAttribute(): ?string
    {
        return $this->fichaTecnica ? asset(ltrim($this->fichaTecnica, '/')) : null;
    }

    public function getHojaSeguridadUrlAttribute(): ?string
    {
        return $this->hojaSeguridad ? asset(ltrim($this->hojaSeguridad, '/')) : null;
    }

    // “Controles” como array (tu columna es texto con comas)
    public function getControlesArrayAttribute(): array
    {
        if (!$this->controla) return [];
        return collect(explode(',', $this->controla))
            ->map(fn($s) => trim($s))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    // “Categoría” normalizada
    public function getCategoriaNombreAttribute(): string
    {
        return $this->categoria ?: 'Sin categoría';
    }

    public function getCategoriaSlugAttribute(): string
    {
        return Str::slug($this->getCategoriaNombreAttribute());
    }

    // Route binding por ID (no tienes slug en BD)
    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
