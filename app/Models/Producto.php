<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'IdProducto';

    protected $fillable = [
        'IdCategoria',
        'Nombre',
        'Descripcion',
        'Precio',
        'Stock',
        'Imagen',
        'Estado',
    ];

    protected $casts = [
        'Precio' => 'decimal:2',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'IdCategoria', 'IdCategoria');
    }

    public function inventario()
    {
        return $this->hasMany(Inventario::class, 'IdProducto', 'IdProducto');
    }

    public function scopeActivos($query)
    {
        return $query->where('Estado', 'activo');
    }
    public $timestamps = false;

    public function imagenes()
    {
    return $this->hasMany(Imagen::class, 'IdProducto', 'IdProducto');
    }

    public function promociones()
    {
        return $this->belongsToMany(
            Promocion::class,
            'Producto_Promocion',
            'IdProducto',
            'IdPromocion'
        );
    }

    public function promocionVigente()
    {
        return $this->promociones->first(fn ($promo) => $promo->estaVigente());
    }

    public function tieneDescuento(): bool
    {
        return $this->promocionVigente() !== null;
    }

    public function precioFinal(): float
    {
        $promo = $this->promocionVigente();

        if ($promo) {
            return round((float) $this->Precio * (1 - $promo->PorcentajeDescuento / 100), 2);
        }

        return (float) $this->Precio;
    }
}