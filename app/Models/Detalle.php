<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Detalle
 *
 * @property $id
 * @property $ticket_id
 * @property $producto_id
 * @property $cantidad
 * @property $precio_unit
 * @property $subtotal
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Detalle extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['ticket_id', 'producto_id', 'cantidad', 'precio_unit', 'subtotal'];


}
