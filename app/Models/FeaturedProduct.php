<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class FeaturedProduct extends Model
    {
        protected $table = 'featured_products';
        protected $fillable = ['product_id','position','is_active','starts_at','ends_at','created_by'];

        public function product()
        {
            return $this->belongsTo(Producto::class, 'product_id');
        }

        // Scopes útiles
        public function scopeActivos($q){ return $q->where('is_active', true); }
        public function scopeVigentes($q, $at = null){
            $at = $at ?: now();
            return $q->where(function($w) use ($at){
                    $w->whereNull('starts_at')->orWhere('starts_at','<=',$at);
                })->where(function($w) use ($at){
                    $w->whereNull('ends_at')->orWhere('ends_at','>=',$at);
                });
        }
        public function scopeOrdenados($q){ return $q->orderBy('position'); }
    }
